<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldinfoservicelistassetdefaultService();
// $rs = $sv->count();
// var_dump($rs);
// exit();

class FieldinfoservicelistassetdefaultService {

	var $databasename = "fieldlogger";
	var $tablename = "field_infoservicelist_assetdefault";

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
	public function getAllField_infoservicelist_assetdefault() {

		$rs  = Capsule::select("SELECT * FROM $this->tablename");		
		return $s;
	}


	public function getField_infoservicelist_assetdefaultByslistID($slistID) {
		
		$rs  = Capsule::select("SELECT     *      FROM field_infoservicelist_assetdefault as adefault       LEFT JOIN field_infotoollist tool ON adefault.adefault_toolID = tool.toolID        WHERE adefault_slistID = ?   ORDER BY adefault.adefaultNo DESC",[$slistID]);
		return $s;
	}
	/**
	 * Returns the item corresponding to the value specified for the primary key.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function getField_infoservicelist_assetdefaultByID($itemID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename where adefaultNo=?",[$itemID]);
		return $s;
	}

	/**
	 * Returns the item corresponding to the value specified for the primary key.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function createField_infoservicelist_assetdefault($item) {

		$rs  = Capsule::insert("INSERT INTO $this->tablename (adefaultID, adefault_slistID, adefault_toolID, adefault_serialNo, adefault_1, adefault_2, adefault_3, adefault_4, adefault_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->adefaultID, $item->adefault_slistID, $item->adefault_toolID, $item->adefault_serialNo, $item->adefault_1, $item->adefault_2, $item->adefault_3, $item->adefault_4, $item->adefault_5]);
		return $s;
	}

	/**
	 * Updates the passed item in the table.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * @param stdClass $item
	 * @return void
	 */
	public function updateField_infoservicelist_assetdefault($item) {

		$rs  = Capsule::update("UPDATE $this->tablename SET adefaultID=?, adefault_slistID=?, adefault_toolID=?, adefault_serialNo=?, adefault_1=?, adefault_2=?, adefault_3=?, adefault_4=?, adefault_5=? WHERE adefaultNo=?",[$item->adefaultID, $item->adefault_slistID, $item->adefault_toolID, $item->adefault_serialNo, $item->adefault_1, $item->adefault_2, $item->adefault_3, $item->adefault_4, $item->adefault_5, $item->adefaultNo]);		
		return $s;
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
	public function deleteField_infoservicelist_assetdefault($itemID) {

		$rs  = Capsule::delete("DELETE FROM $this->tablename WHERE adefaultNo = ?",[$itemID]);
		return $s;
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
	public function getField_infoservicelist_assetdefault_paged($startIndex, $numItems) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $s;
	}
	
	
}

?>
