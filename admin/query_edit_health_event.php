<?php
	include("../includes/db_connection.php");
    
    // Get the original identifiers to find the correct group of records
	$old_name = $_GET['old_name'];
	$old_date = $_GET['old_date'];
	
    // Get the new information from the POST form
	$hname = $_POST['new_name'];
	$hdate = $_POST['new_date'];
	$hpurpose = $_POST['new_purpose'];

	mysqli_query($conn, "UPDATE healthrecords set HealthName='$hname', HealthDate='$hdate', HealthPurpose='$hpurpose' WHERE HealthName='$old_name' AND HealthDate='$old_date'");
	
	?>
		<script>
			window.alert('Health Activity updated successfully!');
			window.location="health.php";
		</script>
	<?php
?>