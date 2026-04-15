<?php
	include("../includes/db_connection.php");
	
	// Get the identifiers from the URL (GET method)
	$name = $_GET['name'];
	$date = $_GET['date'];
	
	// Delete all rows that belong to this specific event name and date
	mysqli_query($conn, "DELETE FROM healthrecords WHERE HealthName='$name' AND HealthDate='$date'");
	
	// Redirect back to the main list
	header('location:health.php');
?>