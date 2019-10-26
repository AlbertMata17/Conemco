<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class Customer extends DatabaseObject {
	
	protected static $tblName="customers";
	protected static $tblFields = array('idcustomer', 'name', 'description', 'phone', 'email', 'address', 'status','created_by','modified_by','idcompany','idtype','reference','c_id','country','city','trash','Job_Title','Professional_Affiliations','State_Region','Gender','Industry','Sector','Division','Field_of_Study','Preferred_Language','Buyer_Persona');
	
	public $idcustomer;
	public $name;
	public $description;
	public $phone;
	public $email;
	public $address;
	public $status;
	public $created_by;
	public $modified_by;
	public $idcompany;
	public $idtype;
	public $reference;
	public $c_id;
	public $country;
	public $city;
	public $trash;
	public $Job_Title;
	public $Professional_Affiliations;
	public $State_Region;
	public $Gender;
	public $Industry;
	public $Sector;
	public $Division;
	public $Field_of_Study;
	public $Preferred_Language;
	public $Buyer_Persona;

	
	public $message=NULL;

	
	
 	// This will return  record by username in users table
	// Find user by username
	public static function findByProjectId($proj_id="") {
    global $database;
		$sql  = "SELECT * FROM customers ";
		$sql .= "WHERE idcustomer = '{$idcustomer}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	// Find user by id
	public static function findByTitle($proj_title="") {
    global $database;
		$sql  = "SELECT * FROM customers ";
		$sql .= "WHERE name = '{$name}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	
	
}
?>