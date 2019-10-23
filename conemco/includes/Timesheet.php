<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.
require_once('database.php');

class Timesheet extends DatabaseObject {
	
	protected static $tblName="timesheet";
	protected static $tblFields = array('idtimesheet', 'idactivity', 'worked_hours', 'ended_date', 'user_note', 'trash','idproject','status','finish','c_id','created_by','modified_by');
	
	public $idtimesheet;
	public $idactivity;
	public $worked_hours;
	public $ended_date;
	public $user_note;
	public $trash;
	public $idproject;
	public $status;
	public $finish;
	public $c_id;
	public $created_by;
	public $modified_by;


	
	public $message=NULL;

	
	
 	// This will return  record by username in users table
	// Find user by username
	public static function findByProjectId($proj_id="") {
    global $database;
		$sql  = "SELECT * FROM timesheet ";
		$sql .= "WHERE idtimesheet = '{$idtimesheet}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	// Find user by id
	public static function findByTitle($proj_title="") {
    global $database;
		$sql  = "SELECT * FROM timesheet ";
		$sql .= "WHERE name = '{$name}' ";
		$sql .= "LIMIT 1";
		$result_array = self::findBySql($sql);  // $result_array is an object
		
		return !empty($result_array) ? array_shift($result_array) : false;
			
	}
	
	
}
?>