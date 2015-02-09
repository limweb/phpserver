<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldinfoserviceassetService();
// $rs = $sv->count();
// var_dump($rs);
// exit();

class FieldinfoserviceassetService {

	var $databasename = "fieldlogger";
	var $tablename = "field_infoservice_asset";

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
	public function getAllfield_infoservice_asset() {

		$rs  = Capsule::select("SELECT * FROM $this->tablename");		
		return $rs;
	}

	public function getAllfield_infoservice_assetByID($serviceID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename
			WHERE toolstring_serviceID=?",[$serviceID]);
		return $rs;
	}

	public function getAllfield_infoservice_assetByserviceID($serviceID) {
		
		$rs  = Capsule::select("SELECT *         FROM field_infoservice_asset as toolstring        LEFT JOIN field_infoasset asset ON asset.assetID = toolstring.toolstring_assetID     LEFT JOIN field_infotoollist tool ON tool.toolID = asset.asset_toolID         WHERE toolstring_serviceID=?        GROUP BY asset.asset_serialNo        ORDER BY toolstring.toolstring_1 ASC, toolstring.toolstringNo ASC",[$serviceID]);
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
	public function getfield_infoservice_assetByID($itemID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename where toolstringNo=?",[$itemID]);
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
	public function createfield_infoservice_asset($item) {

		$rs  = Capsule::insert("INSERT INTO $this->tablename (toolstring_serviceID, toolstring_assetID, toolstring_serialNo, toolstring_note, toolstring_1, toolstring_2, toolstring_3, toolstring_4, toolstring_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->toolstring_serviceID, $item->toolstring_assetID, $item->toolstring_serialNo, $item->toolstring_note, $item->toolstring_1, $item->toolstring_2, $item->toolstring_3, $item->toolstring_4, $item->toolstring_5]);
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
	public function updatefield_infoservice_asset($item) {

		$rs  = Capsule::update("UPDATE $this->tablename SET toolstring_serviceID=?, toolstring_assetID=?, toolstring_serialNo=?, toolstring_note=?, toolstring_1=?, toolstring_2=?, toolstring_3=?, toolstring_4=?, toolstring_5=? WHERE toolstringNo=?",[$item->toolstring_serviceID, $item->toolstring_assetID, $item->toolstring_serialNo, $item->toolstring_note, $item->toolstring_1, $item->toolstring_2, $item->toolstring_3, $item->toolstring_4, $item->toolstring_5, $item->toolstringNo]);		
		return $rs;
	}

	/** Update multi column editor */
	public function updatefield_infoservice_assetEditorColumn($item, $Column) {

		$rs  = Capsule::update("UPDATE $this->tablename SET ".$Column."=? WHERE toolstringNo =?",[$item->{$Column}, $item->toolstringNo]);
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
	public function deletefield_infoservice_asset($itemID) {

		$rs  = Capsule::select("DELETE FROM $this->tablename WHERE toolstringNo = ?",[$itemID]);
		return $rs;
	}

	public function deletefield_infoservice_assetByassetID($assetID) {

		$rs  = Capsule::select("DELETE FROM $this->tablename WHERE toolstring_assetID = ?",[$assetID]);
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
		return (int)  $rs[0]['COUNT'];
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
	public function getfield_infoservice_asset_paged($startIndex, $numItems) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
	}
	
}

?>
