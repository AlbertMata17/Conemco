<?php
ob_start(); 
include("../includes/lib-initialize.php");
include("../templates/admin-header.php");

$sql = "SELECT id, title, start, end, color FROM events ";
$events=mysqli_query($connect, $sql);

// $req = $bdd->prepare($sql);
// $req->execute();

// $events = $req->fetchAll();

?>
