<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldreportreferenceService();
// $rs = $sv->getAllField_reference();
// $rs = $sv->getField_referenceByID(3);
// $rs = $sv->getField_referenceByreportID('PJ1415006933014');
// $rs = $sv->count();
// $rs = $sv->getField_reference_paged(1,10);
// var_dump($rs);
// exit();


class FieldreportreferenceService {

	var $databasename = "fieldlogger";
	var $tablename = "field_report_reference";
	var $connection;

	/**
	 * The constructor initializes the connection to database. Everytime a request is 
	 * received by Zend AMF, an instance of the service class is created and then the
	 * requested method is invoked.
	 */
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
	public function getAllField_reference() {
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
	public function getField_referenceByID($itemID) {
		$rs = Capsule::select("SELECT * FROM $this->tablename where refNo=?",[$itemID]);
		return $rs;
	}

	public function getField_referenceByreportID($reportID) {
		
		$rs = Capsule::select("SELECT * FROM $this->tablename where reportID=? ORDER BY refNo DESC",[$reportID]);
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
	public function createField_reference($item) {

		$rs = Capsule::insert("INSERT INTO $this->tablename (refID, reportID, ref_name, ref_by, ref_note, ref_eventDate, ref_1, ref_2, ref_3, ref_4, ref_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->refID, $item->reportID, $item->ref_name, $item->ref_by, $item->ref_note, $item->ref_eventDate, $item->ref_1, $item->ref_2, $item->ref_3, $item->ref_4, $item->ref_5]);
		return $rs->refID;
	}

	public function createField_referencePic($item, $pic) {
                //$date = date('ymdHis');
		$item->ref_name = "REF".$item->refID.$item->ref_name;  
		$byteArray = new Zend_Amf_Value_ByteArray($pic);
		$File = ".\upload_documents\\$item->ref_name";
		$Handle = fopen($File, 'w');
		fwrite($Handle, $byteArray->getData());
		fclose($Handle);
		$rs = Capsule::insert("INSERT INTO $this->tablename (refNo, refID, reportID, ref_name, ref_by, ref_note, ref_eventDate) VALUES (?, ?, ?, ?, ?, ?, ?)",[$item->refNo, $item->refID, $item->reportID, $item->ref_name, $item->ref_by, $item->ref_note, $item->ref_eventDate]);
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
	public function updateField_reference($item) {
		$rs = Capsule::update("UPDATE $this->tablename SET refID=?, reportID=?, ref_name=?, ref_by=?, ref_note=?, ref_eventDate=?, ref_1=?, ref_2=?, ref_3=?, ref_4=?, ref_5=? WHERE refNo=?",[$item->refID, $item->reportID, $item->ref_name, $item->ref_by, $item->ref_note, $item->ref_eventDate, $item->ref_1, $item->ref_2, $item->ref_3, $item->ref_4, $item->ref_5, $item->refNo]);
		return $rs;
	}

	/** Update multi column editor */
	public function updateField_referenceEditorColumn($item, $Column) {

		$rs =Capsule::update("UPDATE $this->tablename SET ".$Column."=? WHERE refNo=?",[$item->{$Column}, $item->refNo]);
		return $rs;
	}

	/** Update File Reference */    
	public function updateField_referencePic($item,$pic) {
	   //Delete Old File Picture in upload_images//
		$filepath = ".\upload_documents\\$item->ref_1";
		if(file_exists($filepath)){
			unlink($filepath);
		}
    	      //$date = date('ymdHis');
		$item->ref_name = $item->refID.$item->ref_name; 
		$byteArray = new Zend_Amf_Value_ByteArray($pic);
		$File = ".\upload_documents\\$item->ref_name";
		$Handle = fopen($File, 'w');
		fwrite($Handle, $byteArray->getData());
		fclose($Handle);

		$rs = Capsule::update("UPDATE $this->tablename SET ref_name=?, ref_eventDate=? WHERE refNo=?",[ $item->ref_name, $item->ref_eventDate, $item->refNo]);
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
	public function deleteField_reference($itemID,$itemFile) {
	    //Delete Old File Picture in upload_images//
		$filepath = ".\upload_documents\\$itemFile";
		if(file_exists($filepath)){
			unlink($filepath);
		}
		$rs = Capsule::delete("DELETE FROM $this->tablename WHERE refNo = ?",[$itemID]);
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
	public function getField_reference_paged($startIndex, $numItems) {
		$rs = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
	}
}

?>
