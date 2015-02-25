<?php 
/**  

 * @author Thongchai Lim  *  ???   
 *	Tel:0816477729  0866018771  
 *	Email/MSN:limweb@hotmail.com,thongchai@servit.co.th  
 *	GoogleTalk:lim.thongchai@gmail.com  
 *	Social Network Name: “limweb” Skype/HI5/Twitter/Facebook  
 *  @copyright 2010  TH/BKK 
**/  

 class  Pdoconfig {
	public static $username = "root";
	public static $password = "";
	public static $server = "127.0.0.1";
	public static $port = "3306";
	public static $databasename = "fieldlogger";
	
	
	public function __construct() 
	{ 
		set_time_limit(0); 
	} 
	
      public static  function  prepareForAMF($data, $arrTypes) { 
      if (count($data) == 0) 
          return $data; 
       
      $ret = array(); 
      $substract = false; 
       
       
      if (!array_key_exists('0', $data)) { 
          $data = array($data); 
          $substract = true; 
      } 
       
      for ($i=0; $i<count($data); $i++) { 
          $o = new $arrTypes[0](); 
          foreach ($data[$i] as $property => $value) { 
  //            $pproperty = strtolower($property); 
                $pproperty = $property; 
              if (!property_exists($o, $pproperty)) { 
                  continue; 
              } 
              if (array_key_exists($property, $arrTypes)) { 
                  if ($value == NULL) { 
                      $o->$property = array(); 
                      continue; 
                  } 
                  $newArr = $arrTypes; 
                  $newArr[0] = $arrTypes[$property]; 
                  $o->$pproperty = prepareForAMF($value, $newArr); 
              } else { 
                  $o->$pproperty = $value; 
              } 
          } 
          $ret[] = $o; 
      } 
      if ($substract) 
          $ret = $ret[0]; 
      return $ret; 
  } 
	
	
	
	
       public static function makeArrayFromObject($data, $arrDates=NULL) 
       { 
       	$data = (array)$data; 
       	foreach ($data as $k => $v) { 
       		if (is_array($v)) { 
       			$data[$k] = makeArrayFromObject($v, $arrDates); 
       		} else { 
       			if ($arrDates && array_key_exists($k, $arrDates)) { 
       				if ($v instanceof DateTime) { 
                      $data[$k] = $v->format('Y-m-d'); 
       				} else { 
                      $data[$k] = $v->toString('Y-M-d'); 
       				} 
       			} else if (is_object($v)) { 
       				$data[$k] = (array)$v; 
       			} 
       		} 
       	} 
       	return $data; 
       } 
	
 }
   

  function consolelog($status = 200) {
        $lists = func_get_args();
        $status = '';
        foreach ($lists as $list) {
          $status .= json_encode(json_decode(json_encode($list,true)));
        }

       if(isset($_SERVER["REMOTE_ADDR"]) && !empty($_SERVER["REMOTE_ADDR"])){
          $raddr =$_SERVER["REMOTE_ADDR"];
       } else {
          $raddr = '127.0.0.1';
       }

       if(isset($_SERVER["REMOTE_PORT"]) && !empty($_SERVER["REMOTE_PORT"])){
          $rport = $_SERVER["REMOTE_PORT"];
       } else {
          $rport = '8000';
       }

       if(isset($_SERVER["REQUEST_URI"]) && !empty($_SERVER["REQUEST_URI"])){
          $ruri = $_SERVER["REQUEST_URI"];
       } else {
          $ruri = '/console';
       }

       file_put_contents("php://stdout",
           sprintf("[%s] %s:%s [%s]:%s \n",
               date("D M j H:i:s Y"),
               $raddr,$rport,
               $status,
               $ruri
               )
           );
       // echo '<script>console.log(\''.$status.'\');</script>';
}
 