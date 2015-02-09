<?php
date_default_timezone_set('Asia/Bangkok');
require_once 'SecureSession.php';

// $lsv = new LoginService();
// $rs = $lsv->chklogin('1004');
// var_dump($rs );
// echo  $lsv->chktimeout();
// exit();

class LoginService {

    public  function chklogin($app) {
            global $sv;
            error_log($sv);
            $chk = 0;
            if(!empty($app) && !$sv->chktimeout()){
                if($sv->checkApp($app) && isset($_SESSION['User'])){
                    $user =$_SESSION['User'];
                    return $user;
                }
            } else {
                return $chk;
            }
    }

    /**
        1 = timeour
        0 = not timeout
    **/
    public function chktimeout() {
        global $sv;
         return $sv->chktimeout();
    }

}
