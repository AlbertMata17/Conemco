<?php

ob_start(); 
include("../includes/lib-initialize.php");
if (isset($_POST['delete']) && isset($_POST['id'])){
	
	
	$id = $_POST['id'];
	
	$sql = "DELETE FROM events WHERE id = $id";
	$query =  mysqli_query($connect, $sql);
	if ($query == false) {
	 print_r($query->errorInfo());
	 die ('Erreur prepare');
	}
	
	
}elseif (isset($_POST['title']) && isset($_POST['color']) && isset($_POST['id'])){
	
	$id = $_POST['id'];
	$title = $_POST['title'];
	$color = $_POST['color'];
	
	$sql = "UPDATE events SET  title = '$title', color = '$color' WHERE id = $id ";

	
	$query =  mysqli_query($connect, $sql);
	if ($query == false) {
	 print_r($query->errorInfo());
	 die ('Erreur prepare');
	}

}
header('Location: calendario.php');

	
?>
