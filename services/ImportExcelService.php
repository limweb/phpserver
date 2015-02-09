<?php 
require_once 'Pdoconfig.php';


/**  
 * @author Thongchai Lim  *  ???   
 *	Tel:0816477729  0866018771  
 *	Email/MSN:limweb@hotmail.com,thongchai@servit.co.th  
 *	GoogleTalk:lim.thongchai@gmail.com  
 *	Social Network Name: “limweb” Skype/HI5/Twitter/Facebook  
 *  @copyright 2013 TH/BKK 
**/  

class ImportExcelService {   

private $connection = null;
var $tbname = "field_report_input";

public function __construct()
	{ 
	global $option;
	$this->connection = new PDO( 
		"mysql:host=" . Pdoconfig::$server . "; port=" . Pdoconfig::$port . "; dbname=" . Pdoconfig::$databasename, 
		Pdoconfig::$username, 
		Pdoconfig::$password, 
		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") 
	);  
}

public function getAllField_report_input() { 
	$stmt = $this->connection->prepare("SELECT * FROM $this->tbname");
	if($stmt->execute()) {
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); 
   $rows = Pdoconfig::prepareForAMF($rows,array(0 => 'ImportExcelService'));
	} else {
	$errorInfo = $stmt->errorInfo();
	$this->echoError($errorInfo); 
	}
	return $rows; 
 } 


public function getField_report_inputByID($itemID) {
   $stmt = $this->connection->prepare("select * from $this->tbname where id= :ID ");
$stmt->bindParam('ID',$itemID);
if($stmt->execute()) {
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rows = Pdoconfig::prepareForAMF($rows,array(0 => 'ImportExcelService'));
} else {
  	$errorInfo = $stmt->errorInfo();
	$this->echoError($errorInfo); 
	}
	return $rows; 
}

public function deleteField_report_input($itemID) { 
$stmt = $this->connection->prepare("delete from $this->tbname where  id = ?  ");
$stmt->bindParam(1,$itemID);
if($stmt->execute()) {
$row = $stmt->rowCount();
} else {
  	$errorInfo = $stmt->errorInfo();
	$this->echoError($errorInfo); 
	}
// return $row; 
}

public function createField_report_input($item) { 
$stmt = $this->connection->prepare("insert into $this->tbname(id,inputID,fieldID,input_status,input_discription,input_date,input_time,input_1,input_2,input_3,input_4,input_5,input_6,input_7,input_8,input_9,input_10,input_11,input_12,input_13,input_14,input_15,input_16) values (:id, :inputID, :fieldID, :input_status, :input_discription, :input_date, :input_time, :input_1, :input_2, :input_3, :input_4, :input_5, :input_6, :input_7, :input_8, :input_9, :input_10, :input_11, :input_12, :input_13, :input_14, :input_15, :input_16)"); 
$stmt->bindParam('id',$item->id);
$stmt->bindParam('inputID',$item->inputID);
$stmt->bindParam('fieldID',$item->fieldID);
$stmt->bindParam('input_status',$item->input_status);
$stmt->bindParam('input_discription',$item->input_discription);
$stmt->bindParam('input_date',$item->input_date);
$stmt->bindParam('input_time',$item->input_time);
$stmt->bindParam('input_1',$item->input_1);
$stmt->bindParam('input_2',$item->input_2);
$stmt->bindParam('input_3',$item->input_3);
$stmt->bindParam('input_4',$item->input_4);
$stmt->bindParam('input_5',$item->input_5);
$stmt->bindParam('input_6',$item->input_6);
$stmt->bindParam('input_7',$item->input_7);
$stmt->bindParam('input_8',$item->input_8);
$stmt->bindParam('input_9',$item->input_9);
$stmt->bindParam('input_10',$item->input_10);
$stmt->bindParam('input_11',$item->input_11);
$stmt->bindParam('input_12',$item->input_12);
$stmt->bindParam('input_13',$item->input_13);
$stmt->bindParam('input_14',$item->input_14);
$stmt->bindParam('input_15',$item->input_15);
$stmt->bindParam('input_16',$item->input_16);
if($stmt->execute()) { 
	 $autoid = $this->connection->lastInsertId(); 
} else { 
	 	$errorInfo = $stmt->errorInfo(); 
	 	$this->echoError($errorInfo); 
 } 
 return $autoid; 
 }

public function updateField_report_input($item) { 
$stmt = $this->connection->prepare("UPDATE $this->tbname SET id= :id , inputID= :inputID , fieldID= :fieldID , input_status= :input_status , input_discription= :input_discription , input_date= :input_date, input_time= :input_time, input_1= :input_1 , input_2= :input_2 , input_3= :input_3 , input_4= :input_4 , input_5= :input_5 , input_6= :input_6 , input_7= :input_7 , input_8= :input_8 , input_9= :input_9 , input_10= :input_10 , input_11= :input_11 , input_12= :input_12 , input_13= :input_13 , input_14= :input_14 , input_15= :input_15 , input_16= :input_16 where id= :id");
$stmt->bindParam('id',$item->id);
$stmt->bindParam('inputID',$item->inputID);
$stmt->bindParam('fieldID',$item->fieldID);
$stmt->bindParam('input_status',$item->input_status);
$stmt->bindParam('input_discription',$item->input_discription);
$stmt->bindParam('input_date',$item->input_date);
$stmt->bindParam('input_time',$item->input_time);
$stmt->bindParam('input_1',$item->input_1);
$stmt->bindParam('input_2',$item->input_2);
$stmt->bindParam('input_3',$item->input_3);
$stmt->bindParam('input_4',$item->input_4);
$stmt->bindParam('input_5',$item->input_5);
$stmt->bindParam('input_6',$item->input_6);
$stmt->bindParam('input_7',$item->input_7);
$stmt->bindParam('input_8',$item->input_8);
$stmt->bindParam('input_9',$item->input_9);
$stmt->bindParam('input_10',$item->input_10);
$stmt->bindParam('input_11',$item->input_11);
$stmt->bindParam('input_12',$item->input_12);
$stmt->bindParam('input_13',$item->input_13);
$stmt->bindParam('input_14',$item->input_14);
$stmt->bindParam('input_15',$item->input_15);
$stmt->bindParam('input_16',$item->input_16);
if($stmt->execute()) { 
	 $row = $stmt->rowCount(); 
} else { 
	 $errorInfo = $stmt->errorInfo(); 
	 $this->echoError($errorInfo); 
 } 
 //return $row; 
 }

public function count() { 
$stmt = $this->connection->prepare("select count(*) AS COUNT from $this->tbname ");
if($stmt->execute()) { 
	 $count = $stmt->fetch();
} else { 
	 $errorInfo = $stmt->errorInfo(); 
	 $this->echoError($errorInfo); 
 } 
 return $count['COUNT']; 
 }

public function getField_report_input_paged($startIndex, $numItems) {
$stmt = $this->connection->prepare("SELECT * FROM $this->tbname LIMIT ?, ?");
$stmt->bindParam(1,$startIndex,PDO::PARAM_INT);
$stmt->bindParam(2,$numItems,PDO::PARAM_INT);
	if($stmt->execute()) {
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC); 
	$rows = Pdoconfig::prepareForAMF($rows,array(0 => 'ImportExcelService'));
	} else {
	 $errorInfo = $stmt->errorInfo();
	 $this->echoError($errorInfo); 
	}
	return $rows; 
 } 

// INSERT INTO `fieldlogger`.`Field_report_input` (`id`, `inputID`, `fieldID`, `input_status`, `input_discription`, `input_1`, `input_2`, `input_3`, `input_4`, `input_5`, `input_6`, `input_7`, `input_8`, `input_9`, `input_10`, `input_11`, `input_12`, `input_13`, `input_14`, `input_15`, `input_16`) VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
public function createField_report_inputByImportExcel($arrlist) {

          $this->connection->beginTransaction();
          $this->connection->query('SET foreign_key_checks = 0;');
          $stmt = $this->connection->prepare("insert into Field_report_input (`id`, `inputID`, `fieldID`, `input_status`, `input_discription`, `input_date`, `input_time`, `input_1`, `input_2`, `input_3`, `input_4`, `input_5`, `input_6`, `input_7`, `input_8`, `input_9`, `input_10`, `input_11`, `input_12`, `input_13`, `input_14`, `input_15`, `input_16`) 
          values (:id, :inputID, :fieldID, :input_status, :input_discription, :input_date, :input_time, :input_1, :input_2, :input_3, :input_4, :input_5, :input_6, :input_7, :input_8, :input_9, :input_10, :input_11, :input_12, :input_13, :input_14, :input_15, :input_16)"); 
          $i = 0; $j = 0;
          foreach($arrlist as $item){
          	     if(! empty($item->inputID) ){
		$stmt->bindParam('id',$item->id);
        $stmt->bindParam('inputID',$item->inputID);
        $stmt->bindParam('fieldID',$item->fieldID);
        $stmt->bindParam('input_status',$item->input_status);
        $stmt->bindParam('input_discription',$item->input_discription);
        $stmt->bindParam('input_date',$item->input_date);
        $stmt->bindParam('input_time',$item->input_time);
        $stmt->bindParam('input_1',$item->input_1);
        $stmt->bindParam('input_2',$item->input_2);
        $stmt->bindParam('input_3',$item->input_3);
        $stmt->bindParam('input_4',$item->input_4);
        $stmt->bindParam('input_5',$item->input_5);
        $stmt->bindParam('input_6',$item->input_6);
        $stmt->bindParam('input_7',$item->input_7);
        $stmt->bindParam('input_8',$item->input_8);
        $stmt->bindParam('input_9',$item->input_9);
        $stmt->bindParam('input_10',$item->input_10);
        $stmt->bindParam('input_11',$item->input_11);
        $stmt->bindParam('input_12',$item->input_12);
        $stmt->bindParam('input_13',$item->input_13);
        $stmt->bindParam('input_14',$item->input_14);
        $stmt->bindParam('input_15',$item->input_15);
        $stmt->bindParam('input_16',$item->input_16);
	                       $stmt->execute();
	                       $j++;
	            }
                $i++;
            }
        $this->connection->query('SET foreign_key_checks = 1;');
        $this->connection->commit();
        return  $i .':'.$j;
}


private function echoError($errorInfo) { 
 	throw new Exception('MySQL Error ' . $errorInfo[2], $errorInfo[1]); 
} 

public function  __destruct(){
$this->connection = null; 
	} 


 } 


class Field_report_input{ 
	 
	public $id;
	public $inputID;
	public $fieldID;
	public $input_status;
	public $input_discription;
	public $input_date;
	public $input_time;
	public $input_1;
	public $input_2;
	public $input_3;
	public $input_4;
	public $input_5;
	public $input_6;
	public $input_7;
	public $input_8;
	public $input_9;
	public $input_10;
	public $input_11;
	public $input_12;
	public $input_13;
	public $input_14;
	public $input_15;
	public $input_16;
	
} 
 
