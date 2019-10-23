<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class Oficina extends DatabaseObject {
	
	protected static $tblName="office";
	protected static $tblFields = array('idoficina', 'name', 'contact', 'address', 'phone', 'description', 'status','created_by','modified_by','c_id','trash','city','estado','country');
	
	public $idoficina;
	public $name;
	public $contact;
	public $address;
	public $phone;
	public $description;
	public $status;
	public $created_by;
	public $modified_by;
	public $c_id;
	public $trash;
	public $city;
	public $estado;
	public $country;


	
	public $message=NULL;

	
	
 	// This will return  record by username in users table
	// Find user by username
	public static function findByProjectId($proj_id="") {
    global $database;
		$sql  = "SELECT * FROM office ";
		$sql .= "WHERE idoficina = '{$idoficina}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	// Find user by id
	public static function findByTitle($proj_title="") {
    global $database;
		$sql  = "SELECT * FROM office ";
		$sql .= "WHERE name = '{$name}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	
	
}
?>