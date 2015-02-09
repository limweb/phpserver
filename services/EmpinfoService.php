<?php

/**
 *  README for sample service
 *
 *  This generated sample service contains functions that illustrate typical service operations.
 *  Use these functions as a starting point for creating your own service implementation. Modify the 
 *  function signatures, references to the database, and implementation according to your needs. 
 *  Delete the functions that you do not use.
 *
 *  Save your changes and return to Flash Builder. In Flash Builder Data/Services View, refresh 
 *  the service. Then drag service operations onto user interface components in Design View. For 
 *  example, drag the getAllItems() operation onto a DataGrid.
 *  
 *  This code is for prototyping only.
 *  
 *  Authenticate the user prior to allowing them to call these methods. You can find more 
 *  information at http://www.adobe.com/go/flex_security
 *
 */
class EmpinfoService {

	var $username = "root";
	var $password = "";
	var $server = "localhost";
	var $port = "3306";
	var $databasename = "empmodule";
	var $tablename = "emp_info";

	var $connection;

	/**
	 * The constructor initializes the connection to database. Everytime a request is 
	 * received by Zend AMF, an instance of the service class is created and then the
	 * requested method is invoked.
	 */
	public function __construct() {
	  	$this->connection = mysqli_connect(
	  							$this->server,  
	  							$this->username,  
	  							$this->password, 
	  							$this->databasename,
	  							$this->port
	  						);

		$this->throwExceptionOnError($this->connection);
	}

	/**
	 * Returns all the rows from the table.
	 *
	 * Add authroization or any logical checks for secure access to your data 
	 *
	 * @return array
	 */
public function getAllEmp_info() {

		$stmt = mysqli_prepare($this->connection, "SELECT 
        *,
        CONCAT(empmodule.emp_info.emp_firstname,' ',empmodule.emp_info.emp_lastname) as Emname
        FROM empmodule.emp_info
        ORDER BY empmodule.emp_info.emp_firstname ASC");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->No, $row->empID, $row->adminID, $row->emp_firstname, $row->emp_lastname, $row->emp_jobfunction, $row->emp_category, $row->emp_company, 
        $row->emp_busiunit, $row->emp_subbusiunit, $row->emp_reportedto, $row->emp_note, $row->emp_empid, $row->emp_passnum, $row->emp_birthdate, $row->emp_gender, $row->emp_national, 
        $row->emp_address1, $row->emp_address2, $row->emp_country, $row->emp_state, $row->emp_city, $row->emp_postcode, $row->emp_phone, $row->emp_email, $row->emp_emername, 
        $row->emp_emerrelation, $row->emp_emerphone, $row->emp_nokname, $row->emp_nokrelation, $row->emp_nokphone, $row->emp_nokaddress1, $row->emp_nokaddress2, $row->emp_nokcountry, 
        $row->emp_nokstate, $row->emp_nokcity, $row->emp_nokpostcode, $row->emp_status, $row->emp_photo, $row->emp_1, $row->emp_2, $row->emp_3, $row->emp_4, $row->emp_5, $row->emp_6, 
        $row->emp_7, $row->emp_8, $row->emp_9, $row->emp_10, $row->Ename);
		
	    while (mysqli_stmt_fetch($stmt)) {
	       $row->emp_firstname = $row->emp_firstname.' '.$row->emp_lastname;
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->No, $row->empID, $row->adminID, $row->emp_firstname, $row->emp_lastname, $row->emp_jobfunction, $row->emp_category, $row->emp_company, 
          $row->emp_busiunit, $row->emp_subbusiunit, $row->emp_reportedto, $row->emp_note, $row->emp_empid, $row->emp_passnum, $row->emp_birthdate, $row->emp_gender, $row->emp_national, 
          $row->emp_address1, $row->emp_address2, $row->emp_country, $row->emp_state, $row->emp_city, $row->emp_postcode, $row->emp_phone, $row->emp_email, $row->emp_emername, 
          $row->emp_emerrelation, $row->emp_emerphone, $row->emp_nokname, $row->emp_nokrelation, $row->emp_nokphone, $row->emp_nokaddress1, $row->emp_nokaddress2, $row->emp_nokcountry, 
          $row->emp_nokstate, $row->emp_nokcity, $row->emp_nokpostcode, $row->emp_status, $row->emp_photo, $row->emp_1, $row->emp_2, $row->emp_3, $row->emp_4, $row->emp_5, $row->emp_6, 
          $row->emp_7, $row->emp_8, $row->emp_9, $row->emp_10, $row->Ename);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}
    
    public function getEmp_infoByEmail($email){
	$stmt = mysqli_prepare($this->connection, "
    SELECT emp.*,
    CONCAT(emp.emp_firstname,' ',emp.emp_lastname) as Ename,
    uti1.utilityName as company,
    uti2.utilityName as business
    
    FROM empmodule.emp_info as emp
    LEFT JOIN utilitymodule.utility_details uti1 ON emp.emp_company = uti1.UtilityDetailID
	LEFT JOIN utilitymodule.utility_details uti2 ON emp.emp_busiunit = uti2.UtilityDetailID
    WHERE emp.emp_email = ?");
	$this->throwExceptionOnError();
	
	mysqli_stmt_bind_param($stmt, 's', $email);		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		mysqli_stmt_bind_result($stmt, $row->No, $row->empID, $row->adminID, $row->emp_firstname, $row->emp_lastname, $row->emp_jobfunction, $row->emp_category, $row->emp_company, 
        $row->emp_busiunit, $row->emp_subbusiunit, $row->emp_reportedto, $row->emp_note, $row->emp_empid, $row->emp_passnum, $row->emp_birthdate, $row->emp_gender, $row->emp_national, 
        $row->emp_address1, $row->emp_address2, $row->emp_country, $row->emp_state, $row->emp_city, $row->emp_postcode, $row->emp_phone, $row->emp_email, $row->emp_emername, $row->emp_emerrelation, 
        $row->emp_emerphone, $row->emp_nokname, $row->emp_nokrelation, $row->emp_nokphone, $row->emp_nokaddress1, $row->emp_nokaddress2, $row->emp_nokcountry, $row->emp_nokstate, $row->emp_nokcity, 
        $row->emp_nokpostcode, $row->emp_status, $row->emp_photo, $row->emp_1, $row->emp_2, $row->emp_3, $row->emp_4, $row->emp_5, $row->emp_6, $row->emp_7, $row->emp_8, $row->emp_9, $row->emp_10,
        $row->Ename, $row->company, $row->business);
		
		if(mysqli_stmt_fetch($stmt)) {
	      return $row;
		} else {
	      return null;
		}
	}
    
	public function getAllNameandTel() {

		$stmt = mysqli_prepare($this->connection, "SELECT * FROM $this->tablename ORDER BY emp_firstname ASC");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->No, $row->empID, $row->adminID, $row->emp_firstname, $row->emp_lastname, $row->emp_jobfunction, $row->emp_category, $row->emp_company, $row->emp_busiunit, $row->emp_subbusiunit, $row->emp_reportedto, $row->emp_note, $row->emp_empid, $row->emp_passnum, $row->emp_birthdate, $row->emp_gender, $row->emp_national, $row->emp_address1, $row->emp_address2, $row->emp_country, $row->emp_state, $row->emp_city, $row->emp_postcode, $row->emp_phone, $row->emp_email, $row->emp_emername, $row->emp_emerrelation, $row->emp_emerphone, $row->emp_nokname, $row->emp_nokrelation, $row->emp_nokphone, $row->emp_nokaddress1, $row->emp_nokaddress2, $row->emp_nokcountry, $row->emp_nokstate, $row->emp_nokcity, $row->emp_nokpostcode, $row->emp_status, $row->emp_photo, $row->emp_1, $row->emp_2, $row->emp_3, $row->emp_4, $row->emp_5, $row->emp_6, $row->emp_7, $row->emp_8, $row->emp_9, $row->emp_10);
		
	    while (mysqli_stmt_fetch($stmt)) {
	       if($row->emp_firstname !== ""){
	          $row->emp_10 = $row->emp_firstname." ".$row->emp_lastname."  "."  Tel :  ".$row->emp_phone; 
	       }
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->No, $row->empID, $row->adminID, $row->emp_firstname, $row->emp_lastname, $row->emp_jobfunction, $row->emp_category, $row->emp_company, $row->emp_busiunit, $row->emp_subbusiunit, $row->emp_reportedto, $row->emp_note, $row->emp_empid, $row->emp_passnum, $row->emp_birthdate, $row->emp_gender, $row->emp_national, $row->emp_address1, $row->emp_address2, $row->emp_country, $row->emp_state, $row->emp_city, $row->emp_postcode, $row->emp_phone, $row->emp_email, $row->emp_emername, $row->emp_emerrelation, $row->emp_emerphone, $row->emp_nokname, $row->emp_nokrelation, $row->emp_nokphone, $row->emp_nokaddress1, $row->emp_nokaddress2, $row->emp_nokcountry, $row->emp_nokstate, $row->emp_nokcity, $row->emp_nokpostcode, $row->emp_status, $row->emp_photo, $row->emp_1, $row->emp_2, $row->emp_3, $row->emp_4, $row->emp_5, $row->emp_6, $row->emp_7, $row->emp_8, $row->emp_9, $row->emp_10);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}
    
    	public function getAllName() {

		$stmt = mysqli_prepare($this->connection, "
        SELECT empID,
        CONCAT(emp_firstname,'  ',emp_lastname) as Ename
        FROM $this->tablename");		
		$this->throwExceptionOnError();
		
		mysqli_stmt_execute($stmt);
		$this->throwExceptionOnError();
		
		$rows = array();
		
		mysqli_stmt_bind_result($stmt, $row->empID, $row->Ename);
		
	    while (mysqli_stmt_fetch($stmt)) {
     	 
	      $rows[] = $row;
	      $row = new stdClass();
	      mysqli_stmt_bind_result($stmt, $row->empID, $row->Ename);
	    }
		
		mysqli_stmt_free_result($stmt);
	    mysqli_close($this->connection);
	
	    return $rows;
	}
    


	private function throwExceptionOnError($link = null) {
		if($link == null) {
			$link = $this->connection;
		}
		if(mysqli_error($link)) {
			$msg = mysqli_errno($link) . ": " . mysqli_error($link);
			throw new Exception('MySQL Error - '. $msg);
		}		
	}
}

?>
