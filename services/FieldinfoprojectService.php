<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldinfoprojectService();
// $rs = $sv->count();
// var_dump($rs);
// exit();

class FieldinfoprojectService {
	var $databasename = "fieldlogger";
	var $tablename = "field_infoproject";

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
	public function getAllField_infoproject() {

		$rs  = Capsule::select("SELECT * FROM $this->tablename");		
		return $rs;
	}

	public function getAllField_infoprojectActive() {

		$rs  = Capsule::select("SELECT * FROM $this->tablename WHERE infopro_active = '1' ORDER BY infopro_name ASC");		
		return $rs;
	}

	public function getAllField_infoprojectAdvanced() {

		$rs  = Capsule::select(" SELECT         project.*,         client.*         FROM field_infoproject as project        LEFT JOIN field_infoclient as client ON client.infoclientID = project.infopro_clientID         ORDER BY project.infoproNo ASC");		
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
	public function getField_infoprojectByID($itemID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename where infoproNo=?",[$itemIDs]);
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
	public function createField_infoproject($item) {

		$rs  = Capsule::insert("INSERT INTO $this->tablename (infoproID, infopro_name, infopro_businessUnit, infopro_clientID, infopro_detail, infopro_active, infopro_1, infopro_2, infopro_3, infopro_4, infopro_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->infoproID, $item->infopro_name, $item->infopro_businessUnit, $item->infopro_clientID, $item->infopro_detail, $item->infopro_active, $item->infopro_1, $item->infopro_2, $item->infopro_3, $item->infopro_4, $item->infopro_5]);
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
	public function updateField_infoproject($item) {

		$rs  = Capsule::update("UPDATE $this->tablename SET infopro_name=?, infopro_businessUnit=?, infopro_clientID=?, infopro_detail=?, infopro_active=?, infopro_1=?, infopro_2=?, infopro_3=?, infopro_4=?, infopro_5=? WHERE infoproNo=?",[ $item->infopro_name, $item->infopro_businessUnit, $item->infopro_clientID, $item->infopro_detail, $item->infopro_active, $item->infopro_1, $item->infopro_2, $item->infopro_3, $item->infopro_4, $item->infopro_5, $item->infoproNo]);		
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
	public function deleteField_infoproject($itemID) {

		$rs  = Capsule::delete("DELETE FROM $this->tablename WHERE infoproNo = ?",[$itemID]);
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
	public function getField_infoproject_paged($startIndex, $numItems) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
	}
	
}

?>
