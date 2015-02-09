<?php
require_once 'Pdoconfig.php';
// require_once '../vo/UserModel.php';

/**
 * @author Thongchai Lim  *  ???
 *	Tel:0816477729  0866018771
 *	Email/MSN:limweb@hotmail.com,thongchai@servit.co.th
 *	GoogleTalk:lim.thongchai@gmail.com
 *	Social Network Name: �limweb� Skype/HI5/Twitter/Facebook
 *  @copyright 2010 TH/BKK
 **/


/*   $a = new UserService();
   print_r($a->getUserByID('a', 'a'));

*/
class UserService
{

	private $connection = null;
	var $tbname = "user";

	public function __construct()
	{
		global $option;


		$this->connection = new PDO("mysql:host=" . Pdoconfig::$server . "; port=" .
				Pdoconfig::$port . "; dbname=" . Pdoconfig::$databasename, Pdoconfig::$username,
				Pdoconfig::$password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		//    $this->connection->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('myPDOStatement',array($this->connection)) );
		//    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//    $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	}

	public function getAllUser()
	{
		$stmt = $this->connection->prepare("SELECT * FROM $this->tbname");
		if ($stmt->execute()) {
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$errorInfo = $stmt->errorInfo();
			throw new Exception(sprintf('PDO Error %d: %s', $errorInfo[1], $errorInfo[2]));
		}

		return $rows;
	}

	private function pdo_sql_debug($sql, $placeholders)
	{
		foreach ($placeholders as $k => $v) {
			$sql = preg_replace('/:' . $k . '/', "'" . $v . "'", $sql);
		}
		return $sql;
	}

	public function getUserByID($username, $password)
	{
// 		$stmt = $this->connection->prepare("SELECT `user`.userid,  PASSWORD(password) as password, `user`.`status`, `user`.wh, `user`.roll, `user`.cDate, `user`.mDate, `user`.cBy, `user`.mBy, warehouse.warehouseSN, warehouse.warehouseName, NOW() as server_date, now() as workdate, '' as comment  FROM `user` INNER JOIN warehouse ON `user`.wh = warehouse.warehouseID  where 1=1 and userid = :username1  and password = :password2  ");
		$stmt = $this->connection->prepare("call spsystemlogin(:username1,:password2)");
		$stmt->bindParam('username1', $username);
		$stmt->bindParam('password2', $password);
		//$stmt->bindParam('docid',$docid);
		if($stmt->execute()) {
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$row = Pdoconfig::prepareForAMF($row,array(0 => 'UserModel'));
          //  echo "user <br>";
          //  var_dump($row);
			$stmt->nextRowset();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$rows = Pdoconfig::prepareForAMF($rows,array(0 => 'Roles'));
           // echo "<br>roles<br>";
           // var_dump($rows);
		} else {
			$errorInfo = $stmt->errorInfo();
		    throw new Exception('MySQL Error ' . $errorInfo[2], $errorInfo[1]); 
		}

        if( $row && $rows ) {
            $row[0]->roles = $rows;
            return $row[0];
         } else {
            return new UserModel();
         }    

// 		if ($stmt->execute()) {
// 			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
// 			$rows = Pdoconfig::prepareForAMF($rows, array(0 => 'UserModel'));
// 			Pdoconfig::write_mysql_log($stmt->queryString, $this->connection, func_get_args(),'IN');
// 		} else {
// 			           $errorInfo = $stmt->errorInfo();
// 					   Pdoconfig::write_mysql_log($stmt->queryString, $this->connection,$errorInfo,'ERROR');
// 			           throw new Exception(sprintf('PDO Error %d: %s', $errorInfo[1], $errorInfo[2]));
// 		}
// 		if ($rows != null) {
// 			return $rows[0];
// 		} else {
// 			return new UserModel();
// 		}

		//     $stmt = $this->connection->prepare("select * from $this->tbname where userid= ? and password = ? ");
		//         $stmt->bindParam(1,$username);
		//         $stmt->bindParam(2,$password);
		//     if($stmt->execute()) {
		//         $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		//     } else {
		//     $errorInfo = $stmt->errorInfo();
		// 	throw new Exception(sprintf('PDO Error %d: %s', $errorInfo[1], $errorInfo[2]));
		// 	}
		//  //    var_dump($rows);
		//     if($rows){
		//         $rows = Pdoconfig::prepareForAMF($rows,array(0 => 'UserModel'));
		//         $now = $this->get_Datetime_Now();
		//         $stat = 'IN';
		//         $stmt = $this->connection->prepare(" INSERT INTO userlogs (userid,times,status,comments,createddate ) VALUES ( :userid,:times,:stat,:comment,:createddate)");
		//         $stmt->bindParam('userid',$username);
		//         $stmt->bindParam('times',$now);
		//         $stmt->bindParam('stat',$stat);
		//         $stmt->bindParam('comment',$stat);
		//         $stmt->bindParam('createddate',$now);
		//         $stmt->execute();
		//         return $rows[0];
		//     } else {
		//         return new UserModel();
		//     }
	}


	public function logout($username)
	{
// 		$now = $this->get_Datetime_Now();
// 		$stat = 'OUT';
// 		$stmt = $this->connection->prepare(" INSERT INTO userlogs (userid,times,status,comments,createddate ) VALUES ( :userid,:times,:stat,:comment,:createddate)");
// 		$stmt->bindParam('userid', $username);
// 		$stmt->bindParam('times', $now);
// 		$stmt->bindParam('stat', $stat);
// 		$stmt->bindParam('comment', $stat);
// 		$stmt->bindParam('createddate', $now);
// 		$stmt->execute();
// 		Pdoconfig::write_mysql_log('Logout user ', $this->connection, func_get_args(),'OUT');

		
		$stmt = $this->connection->prepare("call spsystemlogout(:username1)");
		$stmt->bindParam('username1', $username);
		if($stmt->execute()) {
			$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$errorInfo = $stmt->errorInfo();
			throw new Exception(sprintf('PDO Error %d: %s', $errorInfo[1], $errorInfo[2]));
		}
		return (int) $row[0];
	}


	private function get_Datetime_Now()
	{
		$date = date("Y-m-d H:i:s", time());
		return $date;
	}


	public function deleteUser($itemID)
	{
		$stmt = $this->connection->prepare("delete from $this->tbname where  userid = ?  ");
		$stmt->bindParam(1, $itemID);
		if ($stmt->execute()) {
			$row = $stmt->rowCount();
			Pdoconfig::write_mysql_log($stmt->queryString, $this->connection, func_get_args(),'DELUSER');
		} else {
			$errorInfo = $stmt->errorInfo();
			throw new Exception(sprintf('PDO Error %d: %s', $errorInfo[1], $errorInfo[2]));
		}
		// return $row;

	}

	public function createUser($item)
	{
		$stmt = $this->connection->prepare("insert into $this->tbname(userid,password,status,wh,roll,cDate,mDate,cBy,mBy) values (:userid, :password, :status, :wh, :roll, :cDate, :mDate, :cBy, :mBy)");
		$stmt->bindParam('userid', $item->userid);
		$stmt->bindParam('password', $item->password);
		$stmt->bindParam('status', $item->status);
		$stmt->bindParam('wh', $item->wh);
		$stmt->bindParam('roll', $item->roll);
		$stmt->bindParam('cDate', $item->cDate);
		$stmt->bindParam('mDate', $item->mDate);
		$stmt->bindParam('cBy', $item->cBy);
		$stmt->bindParam('mBy', $item->mBy);
		if ($stmt->execute()) {
			$autoid = $this->connection->lastInsertId();
			Pdoconfig::write_mysql_log($stmt->queryString, $this->connection, func_get_args(),'CREATE USER');
		} else {
			//            $errorInfo = $stmt->errorInfo();
			//            throw new Exception(sprintf('PDO Error %d: %s', $errorInfo[1], $errorInfo[2]));
			$this->throwExceptionOnError();
		}
		return $autoid;
	}

	public function updateUser($item)
	{
		$stmt = $this->connection->prepare("UPDATE $this->tbname SET userid= :userid , password= :password , status= :status , wh= :wh , roll= :roll , cDate= :cDate , mDate= :mDate , cBy= :cBy , mBy= :mBy where userid= :userid");
		$stmt->bindParam('userid', $item->userid);
		$stmt->bindParam('password', $item->password);
		$stmt->bindParam('status', $item->status);
		$stmt->bindParam('wh', $item->wh);
		$stmt->bindParam('roll', $item->roll);
		$stmt->bindParam('cDate', $item->cDate);
		$stmt->bindParam('mDate', $item->mDate);
		$stmt->bindParam('cBy', $item->cBy);
		$stmt->bindParam('mBy', $item->mBy);
		if ($stmt->execute()) {
			$row = $stmt->rowCount();
			Pdoconfig::write_mysql_log($stmt->queryString, $this->connection, func_get_args(),'UPDATE USER');
		} else {
			$errorInfo = $stmt->errorInfo();
			throw new Exception(sprintf('PDO Error %d: %s', $errorInfo[1], $errorInfo[2]));
		}
		//return $row;
	}

	public function count()
	{
		$stmt = $this->connection->prepare("select count(*) AS COUNT from $this->tbname ");
		if ($stmt->execute()) {
			$count = $stmt->fetch();
		} else {
			$errorInfo = $stmt->errorInfo();
			throw new Exception(sprintf('PDO Error %d: %s', $errorInfo[1], $errorInfo[2]));
		}
		return $count['COUNT'];
	}

	public function getUser_paged($startIndex, $numItems)
	{
		$stmt = $this->connection->prepare("SELECT * FROM $this->tbname LIMIT ?, ?");
		$stmt->bindParam(1, $startIndex, PDO::PARAM_INT);
		$stmt->bindParam(2, $numItems, PDO::PARAM_INT);
		if ($stmt->execute()) {
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$errorInfo = $stmt->errorInfo();
			throw new Exception(sprintf('PDO Error %d: %s', $errorInfo[1], $errorInfo[2]));
		}
		return $rows;
	}

	public function checkRoll($roll, $userid, $password)
	{
		$stmt = $this->connection->prepare("SELECT if(LOCATE( :ROLL ,roll),1,0) as roll from user WHERE 1 = 1 and userid = :USER and password = :PASS ");
		$stmt->bindParam('ROLL', $roll);
		$stmt->bindParam('USER', $userid);
		$stmt->bindParam('PASS', $password);
		if ($stmt->execute()) {
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$errorInfo = $stmt->errorInfo();
			throw new Exception(sprintf('PDO Error %d: %s', $errorInfo[1], $errorInfo[2]));
		}
		if ($rows) {
			return $rows[0];
		} else {
			$row = array('roll' => 0);
			return $row;
		}

	}


	public function __destruct()
	{
		$this->connection = null;
	}


}

class Roles{
	public $functionname;
	public $modulname;
	public $role;
}


