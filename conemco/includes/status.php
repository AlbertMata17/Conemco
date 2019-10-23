<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class Status extends DatabaseObject {
	
	protected static $tblName="project_status";
	protected static $tblFields = array('idstatus', 'name', 'description', 'status', 'created_by', 'modified_by', 'trash','c_id');
	
	public $idstatus;
	public $name;
	public $description;
	public $status;
	public $created_by;
	public $modified_by;
	public $trash;
	public $c_id;

	
	public $message=NULL;

	
	
 	// This will return  record by username in users table
	// Find user by username
	public static function findByProjectId($proj_id="") {
    global $database;
		$sql  = "SELECT * FROM project_status ";
		$sql .= "WHERE idstatus = '{$idstatus}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	// Find user by id
	public static function findByTitle($proj_title="") {
    global $database;
		$sql  = "SELECT * FROM project_status ";
		$sql .= "WHERE name = '{$name}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	
	
}
?>