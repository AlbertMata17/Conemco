<?php

// Connexion à la base de données
ob_start(); 
include("../includes/lib-initialize.php");
$id=$session->userId; //id of the current logged in user 
$user = User::findById((int)$id); //take the record of current user in an object array 	
$username=$user->firstName;;
$email=$user->email;;
// $account_stat=$user->status;
$user->regDate;
//echo $_POST['title'];
if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']) && isset($_POST['color'])){
	
	$title = $_POST['title'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$color = $_POST['color'];

	$sql = "INSERT INTO events(title, start, end, color,c_id,created_by,modified_by) values ('$title', '$start', '$end', '$color','$id','$username','$username')";
	//$req = $bdd->prepare($sql);
	//$req->execute();
	
	echo $sql;
	
	$query = mysqli_query($connect, $sql);
	if ($query == false) {
	 print_r($bdd->errorInfo());
	 die ('Erreur prepare');
	}
	

}
header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>
