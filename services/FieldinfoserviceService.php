<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldinfoserviceService();
// $rs = $sv->count();
// var_dump($rs);
// exit();

class FieldinfoserviceService {

	var $databasename = "fieldlogger";
	var $tablename = "field_infoservice";

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
	public function getAllField_infoservice() {

		$rs  = Capsule::select("SELECT * FROM $this->tablename");		
		return $rs;
	}
	
	public function getAllField_infoserviceAdvanced() {

		$rs  = Capsule::select("SELECT 
        * 
			FROM field_infoservice as service
			LEFT JOIN field_infoservicelist slist ON slist.slistID = service.service_name
			ORDER BY slist.slist_name");		
		return $rs;
	}
	
	public function getAllField_infoserviceActive() {

		$rs  = Capsule::select("SELECT * FROM $this->tablename WHERE service_active='1' ORDER BY service_name DESC");
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
	public function getField_infoserviceByID($itemID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename where serviceNo=?",[$itemID]);
		return $rs;
	}
	
	public function getField_infoservice_countslistID($slistID) {
		
		$rs  = Capsule::select("SELECT COUNT(service_name) AS cItem FROM $this->tablename WHERE service_name=?",[$slistID]);
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
	public function createField_infoservice($item) {

		$rs  = Capsule::insert("INSERT INTO $this->tablename (serviceID, service_name, service_note, service_sensor, service_active, service_1, service_2, service_3, service_4, service_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->serviceID, $item->service_name, $item->service_note, $item->service_sensor, $item->service_active, $item->service_1, $item->service_2, $item->service_3, $item->service_4, $item->service_5]);
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
	public function updateField_infoservice($item) {
		
		$rs  = Capsule::select("UPDATE $this->tablename SET serviceID=?, service_name=?, service_note=?, service_sensor=?, service_active=?, service_1=?, service_2=?, service_3=?, service_4=?, service_5=? WHERE serviceNo=?",[$item->serviceID, $item->service_name, $item->service_note, $item->service_sensor, $item->service_active, $item->service_1, $item->service_2, $item->service_3, $item->service_4, $item->service_5, $item->serviceNo]);		
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
	public function deleteField_infoservice($itemID) {
		
		$rs  = Capsule::delete("DELETE FROM $this->tablename WHERE serviceNo = ?",[$itemID]);
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
	public function getField_infoservice_paged($startIndex, $numItems) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
	}
	


	public function  getAllField_infoserviceLink($slistID){
 		$rs = Capsule::select("SELECT tool_1 FROM field_infoservice service LEFT JOIN field_infoservice_asset serass ON service.serviceID = serass.toolstring_serviceID LEFT JOIN field_infoasset asset ON serass.toolstring_assetID = asset.assetID LEFT JOIN field_infotoollist tool ON asset.asset_toolID = tool.toolID LEFT JOIN field_infoservicelist list ON service.service_name = list.slistID WHERE  list.slistID = ? ",[$slistID]);
		return (string) $rs[0]['tool_1'];
	}
    
   	public function  getAllField_infoserviceSensorRealtime($serviceID){
 		$rs = Capsule::select("SELECT 
        list.slist_name as serviceName,
        tool.tool_name as assetName, 
        asset.asset_serialNo as serialNo,
        assen.ts_sensorColor as sensorColor, 
        sensor.*
        FROM field_infoservice service
        LEFT JOIN field_infoservice_asset serass ON service.serviceID = serass.toolstring_serviceID
        LEFT JOIN field_infoasset asset ON serass.toolstring_assetID = assetID
        LEFT JOIN field_infotoollist tool ON asset.asset_toolID = tool.toolID
        LEFT JOIN field_infosensor sensor ON tool.toolID = sensor.toolID
        LEFT JOIN field_infoasset_sensor assen ON sensorID = assen.ts_sensorID
        
        LEFT JOIN field_infoservicelist list ON service.service_name = list.slistID
        WHERE service.serviceID = ?",[$serviceID]);
	   return $rs;
	}
}

?>
