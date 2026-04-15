<?php
	include("../includes/db_connection.php");
	
	// 1. Collect data from the Attendance Form
	$oscaID   = $_POST['oscaID'];
	$hname    = $_POST['hname'];
	$hdate    = $_POST['hdate'];
	$hpurpose = $_POST['hpurpose'];
	$htime    = $_POST['htime'];
	$status   = "present"; // Automatically set to present upon scan
	 
	// 2. CHECK FOR DUPLICATION (Constraint logic)
	// Checks if the Senior already has a record for this specific event name and date
	$check = mysqli_query($conn, "SELECT * FROM healthrecords WHERE OscaIDNo='$oscaID' AND HealthName='$hname' AND HealthDate='$hdate'");

	if(mysqli_num_rows($check) > 0) {
		// If duplicate is found, show error and go back
		?>
		<script>
			window.alert('ERROR: This Senior ID (<?php echo $oscaID; ?>) is already recorded for this event today!');
			window.history.back();
		</script>
		<?php
	} else {
		// 3. If no duplicate, INSERT into healthrecords
		mysqli_query($conn, "INSERT INTO healthrecords (OscaIDNo, HealthName, HealthDate, HealthPurpose, HealthAttendanceStatus, HealthTimeIn) 
        VALUES ('$oscaID', '$hname', '$hdate', '$hpurpose', '$status', '$htime')");
		
		?>
			<script>
				window.alert('Attendance recorded successfully for ID: <?php echo $oscaID; ?>');
				window.location="health_attendance.php?name=<?php echo urlencode($hname); ?>&date=<?php echo $hdate; ?>&purpose=<?php echo urlencode($hpurpose); ?>";
			</script>
		<?php
	}
?>