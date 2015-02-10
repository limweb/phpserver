<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldrealtimehidlService();
// $rs = $sv->count();
// var_dump($rs);
// exit();

class FieldrealtimehidlService {

	var $databasename = "fieldlogger";
	var $tablename = "field_realtime_hidl";

	/**
	 * The constructor initializes the connection to database. Everytime a request is 
	 * received by Zend AMF, an instance of the service class is created and then the
	 * requested method is invoked.
	 */
	public function __construct() {
	}

	/**
	 * Returns all the rows from the table.
	 *
	 * Add authroization or any logical checks for secure access to your data 
	 *
	 * @return array
	 */
	public function getAllField_realtime_hidl() {

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
	public function getField_realtime_hidlByID($itemID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename where alarmNo=?",[$itemID]);
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
	public function createField_realtime_hidl($item) {

		$rs  = Capsule::insert("INSERT INTO $this->tablename (alarmID, alarm_reportID, alarm_sensorID, alarm_Halrm, alarm_Lalrm, alarm_Ialrm, alarm_Ialrm_persec, alarm_Dalrm_persec, alarm_1, alarm_2, alarm_3, alarm_4, alarm_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->alarmID, $item->alarm_reportID, $item->alarm_sensorID, $item->alarm_Halrm, $item->alarm_Lalrm, $item->alarm_Ialrm, $item->alarm_Ialrm_persec, $item->alarm_Dalrm_persec, $item->alarm_1, $item->alarm_2, $item->alarm_3, $item->alarm_4, $item->alarm_5]);
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
	public function updateField_realtime_hidl($item) {
	
		$rs  = Capsule::update("UPDATE $this->tablename SET alarmID=?, alarm_reportID=?, alarm_sensorID=?, alarm_Halrm=?, alarm_Lalrm=?, alarm_Ialrm=?, alarm_Ialrm_persec=?, alarm_Dalrm_persec=?, alarm_1=?, alarm_2=?, alarm_3=?, alarm_4=?, alarm_5=? WHERE alarmNo=?",[$item->alarmID, $item->alarm_reportID, $item->alarm_sensorID, $item->alarm_Halrm, $item->alarm_Lalrm, $item->alarm_Ialrm, $item->alarm_Ialrm_persec, $item->alarm_Dalrm_persec, $item->alarm_1, $item->alarm_2, $item->alarm_3, $item->alarm_4, $item->alarm_5, $item->alarmNo]);		
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
	public function deleteField_realtime_hidl($itemID) {
				
		$rs  = Capsule::delete("DELETE FROM $this->tablename WHERE alarmNo = ?",[$itemID]);
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
		return  (int) $rs[0]['COUNT'];
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
	public function getField_realtime_hidl_paged($startIndex, $numItems) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
	    	return $rs;
	}
	
}

?>
