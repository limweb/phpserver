<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldinfouserService();
// $rs = $sv->count();
// var_dump($rs);
// exit();

class FieldinfouserService {

	var $databasename = "fieldlogger";
	var $tablename = "field_infouser";

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
	public function getAllField_infouser() {

		$rs  = Capsule::select("SELECT * FROM $this->tablename");
		return $rs;
	}
	/** get Role */
	public function getAlluser_role() {
		$rs  = Capsule::select("SELECT 
			DISTINCT infouser_role
			FROM  $this->tablename
			WHERE infouser_role IS NOT NULL AND infouser_role != ''
			ORDER BY infouser_role ASC" );		

		return $s;
	}


	/** get BusinessUnit */
	public function getAlluser_businessunit() {

		$rs  = Capsule::select("SELECT 
			DISTINCT infouser_businessUnit
			FROM  $this->tablename
			WHERE infouser_businessUnit IS NOT NULL AND infouser_businessUnit != ''
			ORDER BY infouser_businessUnit ASC" );		
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
	public function getField_infouserByID($itemID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename where infouserNo=?",[$itemID]);
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
	public function createField_infouser($item) {

		$rs  = Capsule::select("INSERT INTO $this->tablename (infouserID, infouser_login, infouser_password, infouser_confirmPass, infouser_firstname, infouser_lastname, infouser_role, 
			infouser_businessUnit, infouser_note, infouser_active, infouser_1, infouser_2, infouser_3, infouser_4, infouser_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->infouserID, $item->infouser_login, $item->infouser_password, $item->infouser_confirmPass, $item->infouser_firstname, $item->infouser_lastname, 
		$item->infouser_role, $item->infouser_businessUnit, $item->infouser_note, $item->infouser_active, $item->infouser_1, $item->infouser_2, $item->infouser_3, $item->infouser_4, $item->infouser_5]);
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
	public function updateField_infouser($item) {

		$rs  = Capsule::select("UPDATE $this->tablename SET infouserID=?, infouser_login=?, infouser_password=?, infouser_confirmPass=?, infouser_firstname=?, infouser_lastname=?, 
			infouser_role=?, infouser_businessUnit=?, infouser_note=?, infouser_active=?, infouser_1=?, infouser_2=?, infouser_3=?, infouser_4=?, infouser_5=? WHERE infouserNo=?",[$item->infouserID, $item->infouser_login, $item->infouser_password, $item->infouser_confirmPass, $item->infouser_firstname, $item->infouser_lastname, 
			$item->infouser_role, $item->infouser_businessUnit, $item->infouser_note, $item->infouser_active, $item->infouser_1, $item->infouser_2, $item->infouser_3, $item->infouser_4, $item->infouser_5, $item->infouserNo]);		
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
	public function deleteField_infouser($itemID) {

		$rs  = Capsule::select("DELETE FROM $this->tablename WHERE infouserNo = ?",[$itemID]);
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
	public function getField_infouser_paged($startIndex, $numItems) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[ $startIndex, $numItems]);
		return $rs;
	}

}

?>
