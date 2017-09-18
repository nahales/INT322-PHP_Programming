<?php
	ob_start();
	include "project.lib";    
		$dbConnect = connectionDB();
		$id = $_GET['id'];
		$newValue = ($_GET['del']=='n')? 'y' : 'n';
		mysqli_query($dbConnect, "UPDATE inventory SET deleted = '$newValue' where id = $id");
		mysqli_close($dbConnect);
		header("Location:view.php");
?>