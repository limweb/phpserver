<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldreportrepresentativeService();
// $rs = $sv->getAllField_representative();
// $rs = $sv->getField_representativeByID(2);
// $rs = $sv->getField_representativeByreportID('PJ1415006933014');
// $rs = $sv->count();
// $rs = $sv->getField_representative_paged(1,2);
// var_dump($rs);
// exit();


class FieldreportrepresentativeService {

	var $databasename = "fieldlogger";
	var $tablename = "field_report_representative";
	var $connection;

	public function __construct() {
		global $pdo;
		$this->connection = $pdo;
	}

	/**
	 * Returns all the rows from the table.
	 *
	 * Add authroization or any logical checks for secure access to your data 
	 *
	 * @return array
	 */
	public function getAllField_representative() {
		$rs = Capsule::select("SELECT * FROM $this->tablename");		
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
	public function getField_representativeByID($itemID) {
		
		$rs = Capsule::select("SELECT * FROM $this->tablename where repNo=?",[$itemID]);
		return $rs;
	}

	public function getField_representativeByreportID($reportID) {
		
		$rs = Capsule::select("SELECT * FROM $this->tablename WHERE reportID=? ORDER BY repNo DESC",[$reportID]);
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
	public function createField_representative($item) {

		$rs = Capsule::insert("INSERT INTO $this->tablename (repID, reportID, rep_name, rep_role, rep_from, rep_to, rep_eventDate, rep_1, rep_2, rep_3, rep_4, rep_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->repID, $item->reportID, $item->rep_name, $item->rep_role, $item->rep_from, $item->rep_to, $item->rep_eventDate, $item->rep_1, $item->rep_2, $item->rep_3, $item->rep_4, $item->rep_5]);
		$this->throwExceptionOnError();
		return $rs->repID;
	}

	/**
	 * Updates the passed item in the table.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * @param stdClass $item
	 * @return void
	 */
	public function updateField_representative($item) {

		$rs = Capsule::update("UPDATE $this->tablename SET repID=?, reportID=?, rep_name=?, rep_role=?, rep_from=?, rep_to=?, rep_eventDate=?, rep_1=?, rep_2=?, rep_3=?, rep_4=?, rep_5=? WHERE repNo=?",[$item->repID, $item->reportID, $item->rep_name, $item->rep_role, $item->rep_from, $item->rep_to, $item->rep_eventDate, $item->rep_1, $item->rep_2, $item->rep_3, $item->rep_4, $item->rep_5, $item->repNo]);		
		return $rs;
	}

	/** Update multi column editor */
	public function updateField_representativeEditorColumn($item, $Column) {

		$rs = Capsule::update("UPDATE $this->tablename SET ".$Column."=? WHERE repNo=?",[$item->{$Column}, $item->repNo]);
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
	public function deleteField_representative($itemID) {

		$rs = Capsule::delete("DELETE FROM $this->tablename WHERE repNo = ?",[$itemID]);
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
	public function getField_representative_paged($startIndex, $numItems) {
		
		$rs = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
	}
}

?>
