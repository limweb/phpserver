<?php

/**
 * @author lolkittens
 * @copyright 2013
 */
require "LDAPHost.php";

class LDAPService{
    /*private $host = 'ldap://ldap.dyndns-server.com:6666';
    private $port = 6689;
    private $LDAPusername='cn=manager,dc=maxcrc,dc=com';
    private $LDAPpassword='icdldap';
    private $subfix='dc=maxcrc,dc=com';*/
    private $projectAll;
    protected $connection = NULL;
    private $host1 = null;
    private $host2 = null;
    private $ldapbind = null;
    private $suffix = '';
      
    public function __construct() {
        $this->initHost();      
        //return $this->connectLDAP();
    }
    public function __destruct() {
        $this->closeLDAP();
    }
    private function initHost(){
        $this->host1 = new LDAPHost();
        $this->host2 = new LDAPHost();
        /**Host : 1 Connection String **/        
        $this->host1->hostURL = 'ldap://vause.dyndns-server.com:8889';
        $this->host1->port = 8889;
        $this->host1->username = 'cn=manager,dc=maxcrc,dc=com';
        $this->host1->password = '1c0ntr0ld4t4';
        $this->host1->suffix = 'dc=maxcrc,dc=com';
        
        /**Host : 2 Connection String **/        
        $this->host2->hostURL = 'ldap://ldap.dyndns-server.com:6666';
        $this->host2->port = 6666;
        $this->host2->username = 'cn=manager,dc=maxcrc,dc=com';
        $this->host2->password = 'icdldap';
        $this->host2->suffix = 'dc=maxcrc,dc=com';
        
        $this->connectAndBind();
    }

    private function connectAndBind(){
        for($i=1;$i<=2;$i++){
            if($i==1) $host = $this->host1;
            if($i==2) $host = $this->host2;
            
            try{
                $this->connection = @ldap_connect($host->hostURL) or die("Could not connect to $host->hostURL");
                ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option ($this->connection, LDAP_OPT_REFERRALS, 0);
            	$bind = @ldap_bind($this->connection, $host->username, $host->password);
                
                if($bind){ //bind success
                    $this->ldapbind = $bind;
                    $this->suffix = $host->suffix;
                    break;
                }
            }catch(exception $e){
                echo "error cause : ".$e;
            }      
        }
    }
        
    private function closeLDAP() {
        try {
                if($this->connection ) {
                        //ldap_unbind($this->connection);
                        ldap_close($this->connection);
                } else {
                        return false;
                }
        } catch( Exception $e ) {
                return false;
        }
        return true;
    }
    private function initRtrn(){
        $rtrn = new stdClass();
        $rtrn->id = "";
        $rtrn->mail = "";
        $rtrn->name = "";
        $rtrn->returnValue = 0;
        $rtrn->usertype = "";
        
        return $rtrn;
    }
    public function checkLogin($mail,$password,$suff){
        $rtrn = $this->initRtrn();
        try{
                $pjID = $this->checkApp($suff);
                if($pjID == '0'){ //IF Web Application Not Active
                    $rtrn->returnValue = -2;
                    return $rtrn;
                }
                $pwd = $password;
                $filterUser = "(&(mail=".$mail.")(userpassword=".$pwd.")(ou:dn:=users)(objectClass=person))";
                $result = ldap_search($this->connection, $this->suffix,$filterUser);
                $rec = ldap_get_entries($this->connection,$result);
                $count = ldap_count_entries($this->connection,$result);
                if($count <= 0 )  {
                    $rtrn->returnValue = 0;
                    return $rtrn;
                }
                
                $pjArry = $rec[0]["ou"];
                $userTypeID = "0";
                foreach($pjArry as $pj){
                    $pjIdArry = explode("|",$pj);
                    if($pjIdArry[0] === $pjID) {
                        $userTypeID = $pjIdArry[1];
                        break;
                    }
                }
                if($userTypeID === "0"){
                    $rtrn->returnValue = -1;
                    return $rtrn;
                }
                
                $rtrn->id = $rec[0]["uid"][0];
                $rtrn->mail = $rec[0]["mail"][0];
                $rtrn->name = $rec[0]["cn"][0];
                $rtrn->returnValue = 1;
                $rtrn->usertype = $userTypeID;
        }catch(exception $e){
            $rtrn->returnValue = -9;
        }
        return $rtrn;
    }
    
     public function checkType($mail,$suff){
        $rtrn = $this->initRtrn();
        try{
                $pjID = $this->checkApp($suff);
                if($pjID == '0'){ //IF Web Application Not Active
                    $rtrn->returnValue = -2;
                    return $rtrn;
                }
                $filterUser = "(&(mail=".$mail.")(ou:dn:=users)(objectClass=person))";
                $result = ldap_search($this->connection, $this->suffix,$filterUser);
                $rec = ldap_get_entries($this->connection,$result);
                $count = ldap_count_entries($this->connection,$result);
                if($count <= 0 )  {
                    $rtrn->returnValue = 0;
                    return $rtrn;
                }
                
                $pjArry = $rec[0]["ou"];
                $userTypeID = "0";
                foreach($pjArry as $pj){
                    $pjIdArry = explode("|",$pj);
                    if($pjIdArry[0] === $pjID) {
                        $userTypeID = $pjIdArry[1];
                        break;
                    }
                }
                if($userTypeID === "0"){
                    $rtrn->returnValue = -1;
                    return $rtrn;
                }
                
                $rtrn->id = $rec[0]["uid"][0];
                $rtrn->mail = $rec[0]["mail"][0];
                $rtrn->name = $rec[0]["cn"][0];
                $rtrn->returnValue = 1;
                $rtrn->usertype = $userTypeID;
        }catch(exception $e){
            $rtrn->returnValue = -9;
        }
        return $rtrn;
    }
    private function checkApp($pjSuffix){
        $rtrn = "0";
        try{
            $filter = "(&(ou:dn:=projects)(objectClass=posixGroup))";
            $result = ldap_search($this->connection, $this->suffix,$filter);
            $rec = ldap_get_entries($this->connection,$result);
            $count = ldap_count_entries($this->connection,$result);
            
            foreach($rec as $pj){
                if($pjSuffix == $pj["cn"][0]){
                    if($pj["description"][1] === "0"){
                        $rtrn = "0";
                        break;
                    }
                    $rtrn = $pj["gidnumber"][0];
                }       
            }
        }catch(exception $e){
            return "0";
        }
        return $rtrn;
    }
}


?>