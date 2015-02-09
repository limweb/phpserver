<?php 
require_once 'Pdoconfig.php';

/**
 * @author Thongchai Lim  *  林生海
 *	Tel:0816477729  0866018771
 *	Email/MSN:limweb@hotmail.com,thongchai@servit.co.th
 *	GoogleTalk:lim.thongchai@gmail.com
 *	Social Network Name: “limweb” Skype/HI5/Twitter/Facebook
 *  @copyright 2013 TH/BKK
 **/
// $sv = new ReportsService();
// $sv->test();

class ReportsService {

	private $queryLogger = null;
	private $connection = null;
	var $tbname = "Reports";

	public function __construct()
	{
		global $option;
		Pdoconfig::setup();
		$this->connection = Pdoconfig::$dbh;
		$this->queryLogger = Pdoconfig::$queryLogger;
	}


	/**
	 * @return array
	 */
	public function getCertifiedbyEmpid($empid,$userid=NULL) {
		try {
			$array = array(':empid'=>$empid);
			$rows = R::getAll("SELECT u.Tid, u.Tparent, u.T1, u.T2, u.T3, u.empID, u.upnewID, u.upnew_task, u.upnew_type, u.upnew_issueddate, u.upnew_expiradate, u.upnew_file, 
            u.upnew_size, u.upnew_status, u.upnew_detail, u.upnew_1, IF ( u.upnew_2, 'Certified', 'UnCertified' ) AS upnew_2, u.upnew_3, u.upnew_4, u.upnew_5, u.upnew_6, u.upnew_7, 
            u.upnew_8, u.upnew_9, u.upnew_10 FROM emp_uploadnew AS u INNER JOIN emp_info AS i ON i.empID = u.empID WHERE 1 = 1 AND ( i.empID = : empid OR i.emp_email = : empid ) 
            AND u.upnew_type = 'Certifications' ORDER BY u.upnew_issueddate DESC",$array);
			$rows = Pdoconfig::prepareForAMF($rows, array(0 =>'emp_uploadnew'));
// 							$log = new Systemlog();
// 							$log->logs = 'get all Reports'; 
// 							$log->query = json_encode(Pdoconfig::getLog()); 
// 							//$log->query = $stmt->queryString;
// 							$log->types = 'SEARCH';
// 							$log->userid =  $userid;
// 							$log->tbname = $this->tbname;
// 							$log->module =  __METHOD__;
// 							$log->parametor = json_encode(func_get_args());
// 							Pdoconfig::$logsrv->insertlog($log,$userid);
			return $rows;

// 			$rows = Pdoconfig::getAll($this->tbname,null,null,'Reports');
// 			return $rows;
		} catch (Exception $e) {
			throw  new Exception($e->getMessage());
		}
	}

	
		/**
		 * @return array SELECT * FROM `emp_info` WHERE empID='EM130311094510';
		 */
		public function getEmployeeInfo($empid,$userid=NULL) {
			try {
				$sql = '$sql = SELECT * FROM emp_info WHERE  emp_email = :empid OR empID = :empid ';
				$array = array(':empid'=>$empid);
				$rows = R::getAll($sql,$array);
				$rows = Pdoconfig::prepareForAMF($rows, array(0 => 'emp_info'));
// 								$log = new Systemlog();
// 								$log->logs = 'get all '. $this->tbname; 
// 								$log->query = json_encode(Pdoconfig::getLog()); 
// 								//$log->query = $stmt->queryString;
// 								$log->types = 'SEARCH';
// 								$log->userid =  $userid;
// 								$log->tbname = $this->tbname;
// 								$log->module =  __METHOD__;
// 								$log->parametor = json_encode(func_get_args());
// 								Pdoconfig::$logsrv->insertlog($log,$userid);
				
				return $rows[0];
	
	// 			$rows = Pdoconfig::getAll($this->tbname,null,null,'type');
	// 			return $rows;
			} catch (Exception $e) {
				throw  new Exception($e->getMessage());
			}
		}
	
		
		
		
	public function getAddress($empid) {
		$sql = 'SELECT empmodule.emp_info.empID, dt.UtilityName, dt.UtilityDetails AS companyname, dt1.UtilityDetails AS address 
        FROM empmodule.emp_info INNER JOIN utilitymodule.utility_details AS dt ON empmodule.emp_info.emp_company = dt.UtilityDetailID, 
        utilitymodule.utility_details AS dt1 WHERE 1 = 1 AND (empmodule.emp_info.emp_email = :empid OR empmodule.emp_info.empID = :empid)  
        AND dt1.UtilityName = \'Address:\' AND dt1.UtilityAbbrev LIKE CONCAT(dt.UtilityName, \'%\')';
		$array = array(':empid'=>$empid);
		$row = R::getRow($sql,$array);
		$row = Pdoconfig::prepareForAMF($row, array(0 => 'stdClass'));
		// 								$log = new Systemlog();
		// 								$log->logs = 'get all '. $this->tbname;
		// 								$log->query = json_encode(Pdoconfig::getLog());
		// 								//$log->query = $stmt->queryString;
		// 								$log->types = 'SEARCH';
		// 								$log->userid =  $userid;
		// 								$log->tbname = $this->tbname;
		// 								$log->module =  __METHOD__;
		// 								$log->parametor = json_encode(func_get_args());
		// 								Pdoconfig::$logsrv->insertlog($log,$userid);
		
		return $row;	
	}

	/**
	 *
	 * @param int $itemID
	 * @return object
	 */
	public function getReportsByID($itemID,$userid=NULL) {
		try {
			$row = R::load($this->tbname, $itemID);
			$row = Pdoconfig::prepareForAMF($row->export(), array(0 => $this->tbname));
							$log = new Systemlog();
							$log->logs = 'get Reports by id'; 
							$log->query = json_encode(Pdoconfig::getLog()); 
							//$log->query = $stmt->queryString;
							$log->types = 'SEARCH';
							$log->userid =  $userid;
							$log->tbname = $this->tbname;
							$log->module =  __METHOD__;
							$log->parametor = json_encode(func_get_args());
							Pdoconfig::$logsrv->insertlog($log,$userid);
			return $row;
		} catch (Exception $e) {
			throw  new Exception($e->getMessage());
		}
	}

	/**
	 *
	 * @param int $itemID
	 * @return int
	 */
	public function deleteReports($itemID,$userid=NULL) {
		try {
			$rs = R::load($this->tbname, $itemID);
			if($rs->id){
				$row = R::trash($rs);
							$log = new Systemlog();
							$log->logs = 'deletel Reports'; 
							$log->query = json_encode(Pdoconfig::getLog()); 
							//$log->query = $stmt->queryString;
							$log->types = 'DEL';
							$log->userid =  $userid;
							$log->tbname = $this->tbname;
							$log->module =  __METHOD__;
							$log->parametor = json_encode(func_get_args());
							Pdoconfig::$logsrv->insertlog($log,$userid);
				
				return $itemID;
			} else {
				throw new Exception('No Data for Delete');
			}
		} catch (Exception $e) {
			throw  new Exception($e->getMessage());
		}
	}
	/**
	 *
	 * @param object $item Reports
	 * @return int
	 */
	public function createReports($item,$userid = NULL) {
		try {
			$arrCol = Pdoconfig::getColumnFromTable($this->tbname);
			$item = Pdoconfig::assignItem2Column($arrCol,$item);
		  //$item = json_decode (json_encode ($item), FALSE);
			$item = (object) $item;
			$item->id = 0;
			$item->create_by = $userid;
			$item->modify_by = $userid;
			$item->create_date = date('Y-m-d H:i:s');
			$item->modify_date = date('Y-m-d H:i:s');
			$bean = R::dispense($this->tbname);
			$bean->import($item);
			$id = R::store($bean);
			if($id){
							$log = new Systemlog();
							$log->logs = 'insert Reports'; 
							$log->query = json_encode(Pdoconfig::getLog()); 
							//$log->query = $stmt->queryString;
							$log->types = 'NEW';
							$log->userid =  $userid;
							$log->tbname = $this->tbname;
							$log->module =  __METHOD__;
							$log->parametor = json_encode(func_get_args());
							Pdoconfig::$logsrv->insertlog($log,$userid);
			
				return $id;
			} else {
				throw new Exception("Can't Insert Item");
			}
		} catch (Exception $e) {
			throw  new Exception($e->getMessage());
		}
	}

	/**
	 *
	 * @param object $item Reports
	 * @return int
	 */
	public function updateReports($item,$userid=NULL) {
		try {
			$arrCol = Pdoconfig::getColumnFromTable($this->tbname);
			$item = Pdoconfig::assignItem2Column($arrCol,$item);
		  //$item = json_decode (json_encode ($item), FALSE);
			$item = (object) $item;
			$item->modify_date = date('Y-m-d H:i:s');
			$item->modify_by = $userid;
			$bean = R::load($this->tbname,$item->id);
			if($bean->id){
				$bean->import($item);
				$id = R::store($bean);
				if($id){
							$log = new Systemlog();
							$log->logs = 'update Reports'; 
							$log->query = json_encode(Pdoconfig::getLog()); 
							//$log->query = $stmt->queryString;
							$log->types = 'UPDATE';
							$log->userid =  $userid;
							$log->tbname = $this->tbname;
							$log->module =  __METHOD__;
							$log->parametor = json_encode(func_get_args());
							Pdoconfig::$logsrv->insertlog($log,$userid);
				
					return $id;
				} else {
					throw new Exception("Can't Update Item");
				}
			} else {
				throw new Exception('No record for Update');
			}
		} catch (Exception $e) {
			throw  new Exception($e->getMessage());
		}
	}

	/**
	 * @return int
	 */
	public function count($userid=NULL) {
		$count = R::count($this->tbname);
		return $count;
	}

	/**
	 * @param int $startIndex
	 * @param int $numItems
	 * @return array
	 */
	public function getReports_paged($startIndex, $numItems,$userid=NULL) {
		try {
			$rows = R::find($this->tbname,' LIMIT ? , ? ',array($startIndex,$numItems));
			$rows = Pdoconfig::prepareForAMF(R::exportAll($rows),array(0 => $this->tbname) );
							$log = new Systemlog();
							$log->logs = 'get  Reports by page'; 
							$log->query = json_encode(Pdoconfig::getLog()); 
							//$log->query = $stmt->queryString;
							$log->types = 'SEARCH';
							$log->userid =  $userid;
							$log->tbname = $this->tbname;
							$log->module =  __METHOD__;
							$log->parametor = json_encode(func_get_args());
							Pdoconfig::$logsrv->insertlog($log,$userid);
			
			return $rows;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}


	private function echoError($errorInfo) {
		throw new Exception('MySQL Error ' . $errorInfo[2], $errorInfo[1]);
	}

	public function  __destruct(){
		$this->connection = null;
		R::close();
	}
	
	public function test($format=null) {
// 		$rs = $this->getCertifiedbyEmpid('EM130311094510');
		$rs = $this->getEmployeeInfo('EM130311094510');
		
	if($format){
			if($format == 'json'){
				header("Content-type: text/json; charset=utf-8");
	  	   		echo json_encode($rs);
			} else if($format == 'xml'){
				header("Content-type: text/xml; charset=utf-8");
				$js = json_encode($rs);
				$arjs = json_decode($js,true);
				echo Pdoconfig::arrayToXml($arjs,'<XML></XML>');
			}
		} else {
			var_dump($rs);
		}
	}
}?>