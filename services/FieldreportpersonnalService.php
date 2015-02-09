<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldreportpersonnalService();
// $rs = $sv->count();
// var_dump($rs);
// exit();

class FieldreportpersonnalService {

	var $databasename = "fieldlogger";
	var $tablename = "field_report_personnal";
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
	public function getAllField_personnal() {

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
	public function getField_personnalByID($itemID) {
		
		$$rs  = Capsule::select("SELECT * FROM $this->tablename where personNo=?",[$itemID]);
		return $rs;
	}

	public function getField_personnalByreportID($reportID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename WHERE reportID=? ORDER BY personNo DESC",[ $reportID]);
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
	public function createField_personnal($item) {

		$rs  = Capsule::insert("INSERT INTO $this->tablename (personID, reportID, person_leader, person_name, person_lastname, person_role, person_eventDate, person_1, person_2, person_3, person_4, person_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->personID, $item->reportID, $item->person_leader, $item->person_name, $item->person_lastname, $item->person_role, $item->person_eventDate, $item->person_1, $item->person_2, $item->person_3, $item->person_4, $item->person_5]);
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
	public function updateField_personnal($item) {

		$rs  = Capsule::update("UPDATE $this->tablename SET personID=?, reportID=?, person_leader=?, person_name=?, person_lastname=?, person_role=?, person_eventDate=?, person_1=?, person_2=?, person_3=?, person_4=?, person_5=? WHERE personNo=?",[$item->personID, $item->reportID, $item->person_leader, $item->person_name, $item->person_lastname, $item->person_role, $item->person_eventDate, $item->person_1, $item->person_2, $item->person_3, $item->person_4, $item->person_5, $item->personNo]);	
		return $rs;
	}
	/** Update multi column editor */
	public function updateField_personnalEditorColumn($item, $Column) {

		$rs  = Capsule::update("UPDATE $this->tablename SET ".$Column."=? WHERE personNo=?",[$item->{$Column}, $item->personNo]);
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
	public function deleteField_personnal($itemID) {

		$rs  = Capsule::delete("DELETE FROM $this->tablename WHERE personNo = ?",[$itemID]);
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
	public function getField_personnal_paged($startIndex, $numItems) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
	}
	
}

?>
