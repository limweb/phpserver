<?php
require_once __DIR__.'/../database.php';
use Illuminate\Database\Capsule\Manager as Capsule;

// $sv = new FieldinfotoollistService();
// $rs = $sv->count();
// var_dump($rs);
// exit();

class FieldinfotoollistService {

    var $databasename = "fieldlogger";
    var $tablename = "field_infotoollist";

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
public function getAllField_infotoollist() {

    $rs  = Capsule::select("SELECT * FROM $this->tablename");		
    return $rs;
}

public function getAllField_infotoollistActive() {

    $rs  = Capsule::select("SELECT * FROM $this->tablename WHERE tool_active = '1' ORDER BY tool_name ASC");		
    return $rs;
}

/** get Type */
public function getAlltool_type() {

    $rs  = Capsule::select("SELECT 
        DISTINCT tool_type
        FROM  $this->tablename
        WHERE tool_type IS NOT NULL AND tool_type != ''
        ORDER BY tool_type ASC" );		
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
public function getField_infotoollistByID($itemID) {

    $rs  = Capsule::select("SELECT * FROM $this->tablename where toolNo=?",[$itemID]);
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
public function createField_infotoollist($item) {

    $rs  = Capsule::insert("INSERT INTO $this->tablename (toolID, tool_name, tool_type, tool_note, tool_sensor, tool_active, tool_1, tool_2, tool_3, tool_4, tool_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->toolID, $item->tool_name, $item->tool_type, $item->tool_note, $item->tool_sensor, $item->tool_active, $item->tool_1, $item->tool_2, $item->tool_3, $item->tool_4, $item->tool_5]);
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
public function updateField_infotoollist($item) {

    $rs  = Capsule::update("UPDATE $this->tablename SET tool_name=?, tool_type=?, tool_note=?, tool_sensor=?, tool_active=?, 
        tool_1=?, tool_2=?, tool_3=?, tool_4=?, tool_5=? WHERE toolNo=?",[$item->tool_name, $item->tool_type, $item->tool_note, $item->tool_sensor, $item->tool_active, $item->tool_1, $item->tool_2, $item->tool_3, $item->tool_4, $item->tool_5, $item->toolNo]);		
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
public function deleteField_infotoollist($itemID) {

    $rs  = Capsule::delete("DELETE FROM $this->tablename WHERE toolNo = ?",[$itemID]);
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
    return (int)  $rs[0]['COUNT'];
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
public function getField_infotoollist_paged($startIndex, $numItems) {
    $rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
    return $rs;
}


}

?>
