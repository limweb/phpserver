<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldinfoassetService();
// $rs = $sv->count();
// var_dump($rs);
// exit();

class FieldinfoassetService {

	var $databasename = "fieldlogger";
	var $tablename = "field_infoasset";
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
	public function getAllField_infoasset() {

		$rs =  Capsule::select("SELECT * FROM $this->tablename");		
		return $rs;	    
	}

	public function getAllField_infoassetActive() {

		$rs =  Capsule::select("
			SELECT asset.*, tool.*	FROM field_infoasset as asset LEFT JOIN field_infotoollist as tool ON tool.toolID = asset.asset_toolID	WHERE asset.asset_active = '1' GROUP BY asset_toolID ORDER BY asset.assetNo DESC");		
		return $rs;
	}

	public function getAllField_infoassetSerialNumberByToolID($toolID) {
		$rs =  Capsule::select("
			SELECT  * FROM field_infoasset WHERE asset_active = '1' AND asset_toolID = ? ORDER BY assetNo DESC",[$toolID]);	
		return $rs;
	}

	public function getAllField_infoassetAdvanced() {
		$rs =  Capsule::select("
			SELECT asset.*, tool.*	FROM field_infoasset as asset 	LEFT JOIN field_infotoollist as tool ON tool.toolID = asset.asset_toolID	ORDER BY asset.assetNo DESC");
		return $rs;
	}

	public function getAllField_infoassetListAdvanced() {

		$rs =  Capsule::select("	SELECT asset.*, tool.*	FROM field_infoasset as asset	LEFT JOIN field_infotoollist as tool ON tool.toolID = asset.asset_toolID  ORDER BY tool.tool_name ASC");		
		return $rs;
	}

	/** get Status */
	public function getAllasset_status() {

		$rs =  Capsule::select("SELECT DISTINCT asset_status FROM  $this->tablename WHERE asset_status IS NOT NULL AND asset_status != ''	 ORDER BY asset_status ASC" );		
		return $rs;
	}

	/** get Located */
	public function getAllasset_located() {

		$rs =  Capsule::select( "SELECT DISTINCT asset_located FROM  $this->tablename WHERE asset_located IS NOT NULL AND asset_located != '' ORDER BY asset_located ASC" );
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
	public function getField_infoassetByID($itemID) {
		
		$rs =  Capsule::select( "SELECT * FROM $this->tablename where assetNo=?",[$itemID]);
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
	public function createField_infoasset($item) {
		consolelog("insert info asset");
		$rs =  Capsule::insert("INSERT INTO $this->tablename (assetID, asset_toolID, asset_serialNo, asset_status, asset_located, asset_note, asset_active, asset_ref, asset_1, asset_2, asset_3, asset_4, asset_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->assetID, $item->asset_toolID, $item->asset_serialNo, $item->asset_status, $item->asset_located, $item->asset_note, $item->asset_active, $item->asset_ref, $item->asset_1, $item->asset_2, $item->asset_3, $item->asset_4, $item->asset_5]);
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
	public function updateField_infoasset($item) {

		$rs =  Capsule::update("UPDATE $this->tablename SET assetID=?, asset_toolID=?, asset_serialNo=?, asset_status=?, asset_located=?, asset_note=?, asset_active=?, asset_ref=?, asset_1=?, asset_2=?, asset_3=?, asset_4=?, asset_5=? WHERE assetNo=?",[$item->assetID, $item->asset_toolID, $item->asset_serialNo, $item->asset_status, $item->asset_located, $item->asset_note, $item->asset_active, $item->asset_ref, $item->asset_1, $item->asset_2, $item->asset_3, $item->asset_4, $item->asset_5, $item->assetNo]);		
		return $rs;
	}

	/** Update multi column editor */
	public function updateField_infoassetEditorColumn($item, $Column) {

		$rs =  Capsule::update( "UPDATE $this->tablename SET ".$Column."=? WHERE refNo=?",[$item->{$Column}, $item->refNo]);
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
	public function deleteField_infoasset($itemID) {

		$rs =  Capsule::delete("DELETE FROM $this->tablename WHERE assetNo = ?",[$itemID]);
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
		$rs =  Capsule::select("SELECT COUNT(*) AS COUNT FROM $this->tablename");
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
	public function getField_infoasset_paged($startIndex, $numItems) {
		$rs =  Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
		}
	}

	?>
