<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldreportinfoService();
// $rs = $sv->count();
// $rs = $sv->getAllField_report_info();
// $rs = $sv->getField_report_infoAdvancedByreportID('RP1423107189799');
// var_dump($rs);
// exit();


class FieldreportinfoService {

	var $databasename = "fieldlogger";
	var $tablename = "field_report_info";

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
	public function getAllField_report_info() {

		$rs  = Capsule::select("SELECT * FROM $this->tablename ORDER BY reportNo DESC");	
		return $rs;
	}

	public function getAllField_report_infoAdvanced($type) {

		$rs  = Capsule::select("SELECT 
			report.*,
			project.infopro_name,
            project.infopro_clientID,
			list.slist_name,
            service.serviceID as sID
		
			FROM field_report_info as report
			LEFT JOIN field_infoproject as project ON project.infoproID = report.projectID
			LEFT JOIN field_infoservicelist as list ON list.slistID = report.serviceID
            LEFT JOIN field_infoservice as service ON service.service_name = list.slistID
            WHERE report_client = ?
			ORDER BY report.reportNo DESC",[$type]);		
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
	public function getField_report_infoByID($reportID) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename where reportID=?",[$reportID]);
		return $rs;
	}


	public function getField_report_infoAdvancedByreportID($reportID) {
		
		$rs  = Capsule::select("SELECT
            report.*,
			project.infopro_name,
            project.infopro_clientID,
			list.slist_name,
            service.serviceID as sID
		
			FROM field_report_info as report
			LEFT JOIN field_infoproject as project ON project.infoproID = report.projectID
			LEFT JOIN field_infoservicelist as list ON list.slistID = report.serviceID
            LEFT JOIN field_infoservice as service ON service.service_name = list.slistID
			WHERE report.reportID = ?
			ORDER BY report.reportNo DESC ",[$reportID]);
		return  $rs[0];
	}

	/**
	 * Returns the item corresponding to the value specified for the primary key.
	 *
	 * Add authorization or any logical checks for secure access to your data 
	 *
	 * 
	 * @return stdClass
	 */
	public function createField_report_info($item) {

		$rs  = Capsule::insert("INSERT INTO $this->tablename (reportID, projectID, serviceID, report_detail, report_startDate, report_endDate, report_locked, report_client, report_representative, report_ref, report_personnel) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->reportID, $item->projectID, $item->serviceID, $item->report_detail, $item->report_startDate, $item->report_endDate, $item->report_locked, $item->report_client, $item->report_representative, $item->report_ref, $item->report_personnel]);
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
	public function updateField_report_info($item) {

		$rs  = Capsule::update("UPDATE $this->tablename SET reportID=?, projectID=?, serviceID=?, report_detail=?, report_startDate=?, report_endDate=?, report_locked=?, report_client=?, report_representative=?, report_ref=?, report_personnel=? WHERE reportNo=?",[$item->reportID, $item->projectID, $item->serviceID, $item->report_detail, $item->report_startDate, $item->report_endDate, $item->report_locked, $item->report_client, $item->report_representative, $item->report_ref, $item->report_personnel, $item->reportNo]);		
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
	public function deleteField_report_info($itemID) {

		$rs  = Capsule::delete("DELETE FROM $this->tablename WHERE reportNo = ?",[$itemID]);
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
	public function getField_report_info_paged($startIndex, $numItems) {
		
		$rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
	}
	
}

?>
