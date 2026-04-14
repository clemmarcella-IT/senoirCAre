<?php
	include('../includes/db_connection.php');
	
	$id=$_GET['id'];
	mysqli_query($conn,"delete from seniors where OscaIDNo='$id'");
	
	header('location:profiling.php');

?>