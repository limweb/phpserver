<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldtoolstringService();
// $rs = $sv->getAllField_toolstring();
// $rs = $sv->getAllField_toolstringAdvancedByServiceID('001');
// $rs = $sv->getField_toolstringByID(1); 
// $rs = $sv->count();
// $rs = $sv->getField_toolstring_paged(0,1);
// var_dump($rs);
// exit();

class FieldtoolstringService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = "3306";
	var $databasename = "fieldlogger";
	var $tablename = "field_toolstring";

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
	public function getAllField_toolstring() {
		$rs =  Capsule::select("SELECT * FROM field_toolstring");
		return $rs;
	}
    
    	public function getAllField_toolstringAdvancedByServiceID($serviceID) {

		$rs =  Capsule::select("SELECT   toolstring.*,   tool.*    FROM field_toolstring as toolstring    LEFT JOIN  field_infotoollist as tool ON  tool.toolID = toolstring.toolString_assetID   WHERE toolstring.toolString_serviceID = :serviceid  ORDER BY toolstring.toolStringNo DESC",['serviceid'=>$serviceID]);
	    	return $rs;
	}
    
	public function getField_toolstringByID($itemID) {
		$rs =  Capsule::select("SELECT * FROM $this->tablename where toolStringNo=?",[$itemID]);
		return $rs;
	}

	public function createField_toolstring($item) {
		$rs =  Capsule::insert("INSERT INTO $this->tablename (toolStringID, toolString_serviceID, toolString_assetID, toolString_serialNo, toolString_sensor, toolString_note, toolString_1, toolString_2, toolString_3, toolString_4, toolString_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->toolStringID, $item->toolString_serviceID, $item->toolString_assetID, $item->toolString_serialNo, $item->toolString_sensor, $item->toolString_note, $item->toolString_1, $item->toolString_2, $item->toolString_3, $item->toolString_4, $item->toolString_5]);
		return $rs->id;
	}

	public function updateField_toolstring($item) {
	
		$rs =  Capsule::update("UPDATE $this->tablename SET toolStringID=?, toolString_serviceID=?, toolString_assetID=?, toolString_serialNo=?, toolString_sensor=?, toolString_note=?, toolString_1=?, toolString_2=?, toolString_3=?, toolString_4=?, toolString_5=? WHERE toolStringNo=?",[$item->toolStringID, $item->toolString_serviceID, $item->toolString_assetID, $item->toolString_serialNo, $item->toolString_sensor, $item->toolString_note, $item->toolString_1, $item->toolString_2, $item->toolString_3, $item->toolString_4, $item->toolString_5, $item->toolStringNo]);		
		return $rs;
	}
    
    	public function updateField_toolstringEditorColumn($item, $Column) {
        
        		$rs =  Capsule::update("UPDATE $this->tablename SET ".$Column."=? WHERE toolStringID=?",[$item->{$Column}, $item->toolStringID]);
        		return $rs;
           }

	public function deleteField_toolstring($itemID) {
				
		$rs = Capsule::delete("DELETE FROM $this->tablename WHERE toolStringNo = ?",[ $itemID]);
		return $rs;
	}



	public function count() {
		$rs  = Capsule::select("SELECT COUNT(*) AS COUNT FROM $this->tablename");
		return  (int) $rs[0]['COUNT'];
	}


	public function getField_toolstring_paged($startIndex, $numItems) {
		
		$rs = Capsule::select("SELECT * FROM  $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
		return $rs;
	}
}

?>
