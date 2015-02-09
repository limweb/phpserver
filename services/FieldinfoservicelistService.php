<?php
    require_once __DIR__.'/../database.php';
    use Illuminate\Database\Capsule\Manager as Capsule;

    // $sv = new FieldinfoservicelistService();
    // $rs = $sv->count();
    // $rs = $sv->getAllField_infoservicelist();
    // var_dump($rs);
    // exit();

    class FieldinfoservicelistService {

    	var $databasename = "fieldlogger";
    	var $tablename = "field_infoservicelist";

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
    	public function getAllField_infoservicelist() {
                        // consolelog("get all field info service list");
         $rs  = Capsule::select(" select * FROM $this->tablename ORDER BY slistNo DESC ");
                        // consolelog($rs);		
         return $rs;
     }

     public function getAllField_infoservicelistActive() {

      $rs  = Capsule::select("SELECT * FROM $this->tablename WHERE slist_active = '1' ORDER BY slist_name DESC");		
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
    	public function getField_infoservicelistByID($itemID) {
    		
            $rs = Capsule::select("SELECT * FROM $this->tablename where slistNo = ? ",[$itemID]);
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
    	public function createField_infoservicelist($item) {
          Capsule:: enableQueryLog();
          consolelog('insert infoservice list');
          consolelog($item);
          $rs  = Capsule::insert("INSERT INTO $this->tablename (slistID, slist_name, slist_note, slist_active, slist_showDefault, slist_1, slist_2, slist_3, slist_4, slist_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",[$item->slistID, $item->slist_name, $item->slist_note, $item->slist_active, $item->slist_showDefault, $item->slist_1, $item->slist_2, $item->slist_3, $item->slist_4, $item->slist_5]);
          $qry = Capsule::getQueryLog();
          consolelog($qry);
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
    	public function updateField_infoservicelist($item) {

    		$rs  = Capsule::update("UPDATE $this->tablename SET slistID=?, slist_name=?, slist_note=?, slist_active=?, slist_showDefault=?, slist_1=?, slist_2=?, slist_3=?, slist_4=?, slist_5=? WHERE slistNo=?",[$item->slistID, $item->slist_name, $item->slist_note, $item->slist_active, $item->slist_showDefault, $item->slist_1, $item->slist_2, $item->slist_3, $item->slist_4, $item->slist_5, $item->slistNo]);		
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
    	public function deleteField_infoservicelist($itemID) {

    		$rs  = Capsule::delete("DELETE FROM $this->tablename WHERE slistNo = ?",[$itemID]);
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
    	public function getField_infoservicelist_paged($startIndex, $numItems) {
    		
    		$rs  = Capsule::select("SELECT * FROM $this->tablename LIMIT ?, ?",[$startIndex, $numItems]);
         return $rs;
     }

 }

 ?>
