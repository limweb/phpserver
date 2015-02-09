<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldinfosensorService();
// $rs = $sv->count();
// var_dump($rs);
// exit();

class FieldinfosensorService {

	var $databasename = "fieldlogger";
	var $tablename = "field_infosensor";

	var $connection;

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
	public function getAllField_infosensor() {

		$rs  = Capsule::select("SELECT * FROM $this->tablename");		
		return $rs;
	}

	/** get Unit */
	public function getAllsensor_unit() {

		$rs  = Capsule::select("SELECT 
			DISTINCT sensor_unit
			FROM  $this->tablename
			WHERE sensor_unit IS NOT NULL AND sensor_unit != ''
			ORDER BY sensor_unit ASC" );		
		return $rs;
	}
	public function getField_infosensorByToolID($toolID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename WHERE toolID = ? ORDER BY sensorNo DESC",[$toolID]);
		return $rs;
	}
	
	public function getField_infosensorListByToolID($toolID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename WHERE toolID = ? ORDER BY sensorNo DESC",[$toolID]);
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
	public function getField_infosensorByID($itemID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename where sensorNo=?",[$itemID]);
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
	public function createField_infosensor($item) {

		$rs  = Capsule::insert("INSERT INTO $this->tablename (sensorID, toolID, sensor_name, sensor_type, sensor_unit, sensor_gain_a, sensor_offset_b, sensor_min, sensor_max, sensor_note, sensor_1, sensor_2, sensor_3, sensor_4, sensor_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->sensorID, $item->toolID, $item->sensor_name, $item->sensor_type, $item->sensor_unit, $item->sensor_gain_a, $item->sensor_offset_b, $item->sensor_min, $item->sensor_max, $item->sensor_note, $item->sensor_1, $item->sensor_2, $item->sensor_3, $item->sensor_4, $item->sensor_5]);
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
	public function updateField_infosensor($item) {
		
		$rs  = Capsule::update("UPDATE $this->tablename SET sensor_name=?, sensor_type=?, sensor_unit=?, sensor_gain_a=?, sensor_offset_b=?, sensor_min=?, 
			sensor_max=?, sensor_note=?, sensor_1=?, sensor_2=?, sensor_3=?, sensor_4=?, sensor_5=? WHERE sensorNo=?",[$item->sensor_name, $item->sensor_type, $item->sensor_unit, $item->sensor_gain_a, $item->sensor_offset_b, $item->sensor_min, $item->sensor_max, $item->sensor_note, $item->sensor_1, $item->sensor_2, $item->sensor_3, $item->sensor_4, $item->sensor_5, $item->sensorNo]);		
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
	public function deleteField_infosensor($itemID) {
		
		$rs  = Capsule::delete("DELETE FROM $this->tablename WHERE sensorNo = ?",[$itemID]);
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
	public function getField_infosensor_paged($startIndex, $numItems) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
	}
	
}

?>
