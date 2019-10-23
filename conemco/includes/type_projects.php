<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class Type extends DatabaseObject {
	
	protected static $tblName="project_types";
	protected static $tblFields = array('idtype', 'name', 'description', 'status', 'created_by', 'modified_by', 'trash','c_id');
	
	public $idtype;
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
		$sql  = "SELECT * FROM project_types ";
		$sql .= "WHERE idtype = '{$idtype}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	// Find user by id
	public static function findByTitle($proj_title="") {
    global $database;
		$sql  = "SELECT * FROM project_types ";
		$sql .= "WHERE name = '{$name}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	
	
}
?>