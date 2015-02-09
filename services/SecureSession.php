<?php
ini_set("display_errors", 0);
date_default_timezone_set('Asia/Bangkok');
$sessionPath = sys_get_temp_dir();
session_save_path($sessionPath);
/**
 * ------------------------------------------------
 * Encrypt PHP session data using files
 * ------------------------------------------------
 * The encryption is built using mcrypt extension 
 * and the randomness is managed by openssl
 * The default encryption algorithm is AES (Rijndael-128)
 * and we use CBC+HMAC (Encrypt-then-mac) with SHA-256
 * 
 * @author    Enrico Zimuel (enrico@zimuel.it)
 * @copyright GNU General Public License
 */
$max = 1800; // 1 mins
$pro = 1;
$divi = 1;
//echo   'set session init maxto ', $max,' sec  gc_probability ',$pro,' divisor ',$divi,'<br>';
ini_set('session.gc_maxlifetime',$max);
ini_set('session.gc_probability',$pro);
ini_set('session.gc_divisor',$divi);

class SecureSession {
    /**
     * Encryption algorithm
     * 
     * @var string
     */
    protected $_algo= MCRYPT_RIJNDAEL_128;    
    /**
     * Key for encryption/decryption
    * 
    * @var string
    */
    protected $_key;
    /**
     * Key for HMAC authentication
    * 
    * @var string
    */
    protected $_auth;
    /**
     * Path of the session file
     *
     * @var string
     */
    protected $_path;
    /**
     * Session name (optional)
     * 
     * @var string
     */
    protected $_name;
    /**
     * Size of the IV vector for encryption
     * 
     * @var integer
     */
    protected $_ivSize;
    /**
     * Cookie variable name of the encryption + auth key
     * 
     * @var string
     */
    protected $_keyName;
    /**
     * Generate a random key using openssl
     * fallback to mcrypt_create_iv
     * 
     * @param  integer $length
     * @return string
     */
    protected function _randomKey($length=32) {
        //echo   __METHOD__,'<BR>';
        if(function_exists('openssl_random_pseudo_bytes')) {
            $rnd = openssl_random_pseudo_bytes($length, $strong);
            if ($strong === true) { 
                return $rnd;
            }    
        }
        if (defined('MCRYPT_DEV_URANDOM')) {
            return mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
        } else {
            throw new Exception("I cannot generate a secure pseudo-random key. Please install OpenSSL or Mcrypt extension");
        }	
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        //echo   __METHOD__,'<BR>';
        session_set_save_handler(
            array($this, "open"),
            array($this, "close"),
            array($this, "read"),
            array($this, "write"),
            array($this, "destroy"),
            array($this, "gc")
        );

        if (!isset($_SESSION)) {
          session_start();
            // echo 'start session<br>';
         } else {
            // echo 'have session <br>';
         } 

    }
    /**
     * Open the session
     * 
     * @param  string $save_path
     * @param  string $session_name
     * @return bool
     */
    public function open($save_path, $session_name) 
    {
        //echo   __METHOD__,'<BR>';
           $this->_path    = $save_path.'/';	
	$this->_name    = $session_name;
	$this->_keyName = "KEY_$session_name";
	$this->_ivSize  = mcrypt_get_iv_size($this->_algo, MCRYPT_MODE_CBC);
		
	if (empty($_COOKIE[$this->_keyName]) || strpos($_COOKIE[$this->_keyName],':')===false) {
            $keyLength    = mcrypt_get_key_size($this->_algo, MCRYPT_MODE_CBC);
            $this->_key   = self::_randomKey($keyLength);
            $this->_auth  = self::_randomKey(32);
            $cookie_param = session_get_cookie_params();
            setcookie(
                $this->_keyName,
                base64_encode($this->_key) . ':' . base64_encode($this->_auth),
                ($cookie_param['lifetime'] > 0) ? time() + $cookie_param['lifetime'] : 0, // if session cookie lifetime > 0 then add to current time; otherwise leave it as zero, honoring zero's special meaning: expire at browser close.
                $cookie_param['path'],
                $cookie_param['domain'],
                $cookie_param['secure'],
                $cookie_param['httponly']
            );
	} else {
            list ($this->_key, $this->_auth) = explode (':',$_COOKIE[$this->_keyName]);
            $this->_key  = base64_decode($this->_key);
            $this->_auth = base64_decode($this->_auth);
	} 
	return true;
    }
    /**
     * Close the session
     * 
     * @return bool
     */
    public function close() 
    {
        //echo   __METHOD__,'<BR>';
        return true;
    }
    /**
     * Read and decrypt the session
     * 
     * @param  integer $id
     * @return string 
     */
    public function read($id) 
    {
        // echo   __METHOD__,'<BR>';        
        $sess_file = $this->_path.$this->_name."_$id";
        if (!file_exists($sess_file)) {
              // echo 'read false<br>';
              return false;
        }    
        // echo 'session file = ',$sess_file,'<br>';
        $data      = file_get_contents($sess_file);
        // var_dump($data);
        list($hmac, $iv, $encrypted)= explode(':',$data);
        $iv        = base64_decode($iv);
        $encrypted = base64_decode($encrypted);
        $newHmac   = hash_hmac('sha256', $iv . $this->_algo . $encrypted, $this->_auth);
        if ($hmac !== $newHmac) {
            return false;
        }
  	$decrypt = mcrypt_decrypt(
            $this->_algo,
            $this->_key,
            $encrypted,
            MCRYPT_MODE_CBC,
            $iv
        );
        return rtrim($decrypt, "\0"); 
         // echo 'data =';
         // var_dump($data);
        // return $data;
    }
    /**
     * Encrypt and write the session
     * 
     * @param integer $id
     * @param string $data
     * @return bool
     */
    public function write($id, $data) 
    {
        // echo   __METHOD__,'<BR>';       
        // var_dump($data); 
        $sess_file = $this->_path . $this->_name . "_$id";
        // echo 'session file = ',$sess_file,'<br>';
	$iv        = mcrypt_create_iv($this->_ivSize, MCRYPT_DEV_URANDOM);
        $encrypted = mcrypt_encrypt(
            $this->_algo,
            $this->_key,
            $data,
            MCRYPT_MODE_CBC,
            $iv
        );
        $hmac  = hash_hmac('sha256', $iv . $this->_algo . $encrypted, $this->_auth);
        $bytes = file_put_contents($sess_file, $hmac . ':' . base64_encode($iv) . ':' . base64_encode($encrypted));
        // $bytes = file_put_contents($sess_file,$data);
           // echo 'write=',$bytes;
        return ($bytes !== false);  
    }
    /**
     * Destoroy the session
     * 
     * @param int $id
     * @return bool
     */
    public function destroy($id) 
    {
        //echo   __METHOD__,'<BR>';        
        $sess_file = $this->_path . $this->_name . "_$id";
        setcookie ($this->_keyName, '', time() - 3600);
	return(@unlink($sess_file));
    }
    /**
     * Garbage Collector
     * 
     * @param int $max 
     * @return bool
     */
    public function gc($max) 
    {
        // echo   __METHOD__,'<br>maxtime = ',$max,'<br>';        
        foreach (glob($this->_path . $this->_name . '_*') as $filename) {
            if (filemtime($filename) + $max < time()) {
                $rs =@unlink($filename);
                // $rs =unlink($filename);
                // echo   'delete ',$filename,'=',$rs,'<br>';
            }
    }
    return true;
    }

    public function chktimeout() {
            // echo   __METHOD__,'<br>';
            //error_log(__METHOD__);
            if(isset($_SESSION) && isset($_SESSION['timelogin'])) {
                    $to = time() - $_SESSION['timelogin'];
                    if( $to > ini_get('session.gc_maxlifetime') ){
                        // echo 'timeout =', time() - $_SESSION['timelogin'];
                        session_destroy();
                        return  1;
                    } else {
                        // echo ' not time out =', time() - $_SESSION['timelogin'];
                        $_SESSION['timelogin'] = time();
                        return 0;
                    }
            } else {
                //error_log('no have session');
                return 1 ;
            }
    } 

    public  function checkApp($app) {
         $chk = 0;
        if( isset($_SESSION) && !$this->chktimeout() ) {
            foreach ($_SESSION['User']->pj as $pj) {
                    if($pj->gid == $app ) {
                        $chk = 1;
                        return $chk;
                        exit();
                    }
            }
        } else {
            return $chk;
        }
    }
}

$sv = new SecureSession();
