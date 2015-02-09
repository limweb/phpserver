<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldinfoassetsensorService();
// $rs = $sv->count();
// var_dump($rs);
// exit();

class FieldinfoassetsensorService {

	var $databasename = "fieldlogger";
	var $tablename = "field_infoasset_sensor";
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
	public function getAllfield_infoasset_sensor() {

		$rs = Capsule::select("SELECT * FROM $this->tablename");		
		return $rs;
	}

	public function getAllfield_infoasset_sensorByassetID($assetID) {

		$rs = Capsule::select("SELECT  * FROM field_infoasset_sensor as toolstring LEFT JOIN field_infosensor sensor ON sensor.sensorID = toolstring.ts_sensorID LEFT JOIN field_infoasset asset ON asset.assetID = toolstring.ts_assetID LEFT JOIN field_infotoollist tool ON asset.asset_toolID = tool.toolID	WHERE ts_assetID = ?	ORDER BY toolstring.tsNo ASC",[$assetID]);
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
	public function getfield_infoasset_sensorByID($itemID) {
		
		$rs = Capsule::select("SELECT * FROM $this->tablename where tsNo=?",[ $itemID]);
		return $rs;
	}

	public function countByServiceserviceID($serviceID) {
		$rs = Capsule::select("SELECT serviceID, COUNT(sensorID) AS countTool FROM field_infoasset_sensor WHERE serviceID = ?",[$serviceID]);
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
	public function createfield_infoasset_sensor($item) {
		consolelog('insert info asset sensor');
		$rs = Capsule::insert("INSERT INTO $this->tablename (ts_assetID, ts_sensorID, ts_sensorColor, ts_1, ts_2, ts_3, ts_4, ts_5) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)",[$item->ts_assetID, $item->ts_sensorID, $item->ts_sensorColor, $item->ts_1, $item->ts_2, $item->ts_3, $item->ts_4, $item->ts_5]);
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
	public function updatefield_infoasset_sensor($item) {

		$rs = Capsule::update("UPDATE $this->tablename SET ts_assetID=?, ts_sensorID=?, ts_sensorColor=?, ts_1=?, ts_2=?, ts_3=?, ts_4=?, ts_5=? WHERE tsNo=?",[$item->ts_assetID, $item->ts_sensorID, $item->ts_sensorColor, $item->ts_1, $item->ts_2, $item->ts_3, $item->ts_4, $item->ts_5, $item->tsNo]);
		return $rs;
	}

	/** Update multi column editor */
	public function updatefield_infoasset_sensorEditorColumn($item, $Column) {

		$rs = Capsule::update("UPDATE $this->tablename SET ".$Column."=? WHERE ts_assetID =? AND ts_sensorID =?",[$item->{$Column}, $item->ts_assetID, $item->ts_sensorID]);
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
	public function deletefield_infoasset_sensor($tsNo) {

		$rs = Capsule::delete("DELETE FROM $this->tablename WHERE tsNo = ?",[$tsNo]);
		return $rs;
	}

	public function deletefield_infoasset_sensorByassetID($assetID) {

		$rs = Capsule::delete("DELETE FROM $this->tablename WHERE ts_assetID = ?",[$assetID]);
		return $rs;
	}

	public function deletefield_infoasset_sensorByCheckbox($assetID,$sensorID) {

		$rs = Capsule::delete("DELETE FROM $this->tablename WHERE ts_assetID = ? AND ts_sensorID = ?",[$assetID, $sensorID]);
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
		$rs = Capsule::select("SELECT COUNT(*) AS COUNT FROM $this->tablename");
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
	public function getfield_infoasset_sensor_paged($startIndex, $numItems) {
		$rs = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
	}
	
}

?>
