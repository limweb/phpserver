<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldreportinputService();
// $rs = $sv->count();
// $rs = $sv->getField_inputByID(2849);
// $rs = $sv->getField_inputByreportID('RP1419228686002');
// $rs = $sv->getField_input_paged(1,5);
// var_dump($rs);
// exit();

class FieldreportinputService {

	var $databasename = "fieldlogger";
	var $tablename = "field_report_input";

	// *
	//  * The constructor initializes the connection to database. Everytime a request is 
	//  * received by Zend AMF, an instance of the service class is created and then the
	//  * requested method is invoked.
	 
	public function __construct() {
	}

	/**
	 * Returns all the rows from the table.
	 *
	 * Add authroization or any logical checks for secure access to your data 
	 *
	 * @return array
	 */
	public function getAllField_input() {

		$rs  = Capsule::select("SELECT * FROM $this->tablename");		
		return $rs;
	}

	/**
	 * Returns the item corresponding to the value specified for the primary key.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getField_inputByID($itemID) {
		
		$rs  = Capsule::select( "SELECT * FROM $this->tablename WHERE id=?",[$itemID]);
		return $rs;
	}
    
    	public function getField_inputByreportID($reportID) {
		
    		$rs  =   (object) Capsule::select("SELECT * FROM $this->tablename WHERE fieldID=? ORDER BY id ASC",[$reportID]);
    		$rows = [];
    		foreach ($rs  as &$row ) {
    			$row = (object) $row;
			if($row->input_1 === ''  || $row->input_1 === null)  $row->input_1 = '0';
			if($row->input_2 === ''  || $row->input_2 === null)  $row->input_2 = '0';
			if($row->input_3 === ''  || $row->input_3 === null)  $row->input_3 = '0';
			if($row->input_4 === ''  || $row->input_4 === null)  $row->input_4 = '0';
			if($row->input_5 === ''  || $row->input_5 === null)  $row->input_5 = '0';
			if($row->input_6 === ''  || $row->input_6 === null)  $row->input_6 = '0';
			if($row->input_7 === ''  || $row->input_7 === null)  $row->input_7 = '0';
			if($row->input_8 === ''  || $row->input_8 === null)  $row->input_8 = '0';
			if($row->input_9 === ''  || $row->input_9 === null)  $row->input_9 = '0';
			if($row->input_10 === '' || $row->input_10 === null) $row->input_10 = '0';
			if($row->input_11 === '' || $row->input_11 === null) $row->input_11 = '0';
			if($row->input_12 === '' || $row->input_12 === null) $row->input_12 = '0';
			if($row->input_13 === '' || $row->input_13 === null) $row->input_13 = '0';
			if($row->input_14 === '' || $row->input_14 === null) $row->input_14 = '0';
			if($row->input_15 === '' || $row->input_15 === null) $row->input_15 = '0';
			if($row->input_16 === '' || $row->input_16 === null) $row->input_16 = '0';
			$rows[] =$row;
    		}           
    		return $rows;
	}

	/**
	 * Returns the item corresponding to the value specified for the primary key.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function createField_input($item) {

		$rs  = Capsule::insert("INSERT INTO $this->tablename (inputID, fieldID, input_status, input_discription, input_date, input_1, input_2, input_time, input_3, input_4, input_5, input_6, input_7, input_8, input_9, input_10, input_11, input_12, input_13, input_14, input_15, input_16) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->inputID, $item->fieldID, $item->input_status, $item->input_discription, $item->input_date, $item->input_time, $item->input_1, $item->input_2, $item->input_3, $item->input_4, $item->input_5, $item->input_6, $item->input_7, $item->input_8, $item->input_9, $item->input_10, $item->input_11, $item->input_12, $item->input_13, $item->input_14, $item->input_15, $item->input_16]);
		return $rs;
	}

	/**
	 * Updates the passed item in the table.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * @param stdClass $item
	 * @return void
	 */
	public function updateField_input($item) {
	
		$rs  = Capsule::update("UPDATE $this->tablename SET inputID=?, fieldID=?, input_status=?, input_discription=?, input_date=?, input_time=?, input_1, input_2, input_3=?, input_4=?, input_5=?, input_6=?, input_7=?, input_8=?, input_9=?, input_10=?, input_11=?, input_12=?, input_13=?, input_14=?, input_15=?, input_16=? WHERE id=?",[$item->inputID, $item->fieldID, $item->input_status, $item->input_discription, $item->input_date, $item->input_time, $item->input_1, $item->input_2, $item->input_3, $item->input_4, $item->input_5, $item->input_6, $item->input_7, $item->input_8, $item->input_9, $item->input_10, $item->input_11, $item->input_12, $item->input_13, $item->input_14, $item->input_15, $item->input_16, $item->id]);
		return $rs;
	}

	/**
	 * Deletes the item corresponding to the passed primary key value from 
	 * the table.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return void
	 */
	public function deleteField_input($itemID) {
				
		$rs  = Capsule::delete("DELETE FROM $this->tablename WHERE id = ?",[$itemID]);
		return $rs;
	}


	/**
	 * Returns the number of rows in the table.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 */
	public function count() {
		$rs  = Capsule::select("SELECT COUNT(*) AS COUNT FROM $this->tablename");
		return (int) $rs[0]['COUNT'];
	}


	/**
	 * Returns $numItems rows starting from the $startIndex row from the 
	 * table.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * 
	 * @return array
	 */
	public function getField_input_paged($startIndex, $numItems) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
	}
	
}

?>
