<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldinfoclientService();
// $rs = $sv->count();
// var_dump($rs);
// exit();

class FieldinfoclientService {

	var $databasename = "fieldlogger";
	var $tablename = "field_infoclient";
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
	public function getAllField_infoclient() {

		$rs  = Capsule::select("SELECT * FROM $this->tablename");		
		return $rs;
	}

	public function getAllField_infoclientActive() {
		$rs  = Capsule::select("SELECT * FROM $this->tablename WHERE infoclient_active = '1'");		
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
	public function getField_infoclientByID($clientID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename where infoclientID=?",[$clientID]);
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
	public function createField_infoclient($item) {

		$rs  = Capsule::insert("INSERT INTO $this->tablename (infoclientID, infoclient_firstname, infoclient_lastname, infoclient_company, infoclient_address1, 
			infoclient_address2, infoclient_city, infoclient_state, infoclient_postalcode, infoclient_telephone, infoclient_email, infoclient_note, infoclient_active,
			infoclient_1, infoclient_2, infoclient_3, infoclient_4, infoclient_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->infoclientID, $item->infoclient_firstname, $item->infoclient_lastname, $item->infoclient_company, $item->infoclient_address1, 
		$item->infoclient_address2, $item->infoclient_city, $item->infoclient_state, $item->infoclient_postalcode, $item->infoclient_telephone, $item->infoclient_email, $item->infoclient_note, 
		$item->infoclient_active, $item->infoclient_1, $item->infoclient_2, $item->infoclient_3, $item->infoclient_4, $item->infoclient_5]);
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
	public function updateField_infoclient($item) {

		$rs  = Capsule::update("UPDATE $this->tablename SET infoclient_firstname=?, infoclient_lastname=?, infoclient_company=?, infoclient_address1=?, 
			infoclient_address2=?, infoclient_city=?, infoclient_state=?, infoclient_postalcode=?, infoclient_telephone=?, infoclient_email=?, infoclient_note=?, infoclient_active=?,
			infoclient_1=?, infoclient_2=?, infoclient_3=?, infoclient_4=?, infoclient_5=? WHERE infoclientNo=?",[$item->infoclient_firstname, $item->infoclient_lastname, $item->infoclient_company, $item->infoclient_address1, 
			$item->infoclient_address2, $item->infoclient_city, $item->infoclient_state, $item->infoclient_postalcode, $item->infoclient_telephone, $item->infoclient_email, $item->infoclient_note,
			$item->infoclient_active, $item->infoclient_1, $item->infoclient_2, $item->infoclient_3, $item->infoclient_4, $item->infoclient_5, $item->infoclientNo]);
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
	public function deleteField_infoclient($itemID) {

		$rs  = Capsule::delete("DELETE FROM $this->tablename WHERE infoclientNo = ?",[$itemID]);
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
		$rs  = Capsule::select( "SELECT COUNT(*) AS COUNT FROM $this->tablename");
		return $rs[0]['COUNT'];
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
	public function getField_infoclient_paged($startIndex, $numItems) {
		$rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
	}
}

?>
