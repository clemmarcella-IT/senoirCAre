<?php
	include("../includes/db_connection.php");
	
	$oscaID   = $_POST['oscaID'];
	$hname    = $_POST['hname']; // e.g. "Morning Session"
	$hdate    = $_POST['hdate'];
	$hpurpose = $_POST['hpurpose'];
	$htime    = $_POST['htime'];
	$status   = "present"; 
	 
	// THE FIX: Check if ID exists for THIS SPECIFIC EVENT NAME on THIS DATE
	$check = mysqli_query($conn, "SELECT * FROM healthrecords 
                                  WHERE OscaIDNo='$oscaID' 
                                  AND HealthName='$hname' 
                                  AND HealthDate='$hdate'");

	if(mysqli_num_rows($check) > 0) {
		?>
		<script>
			window.alert('DUPLICATE: Senior ID <?php echo $oscaID; ?> already scanned for "<?php echo $hname; ?>" today.');
			window.history.back();
		</script>
		<?php
        exit(); 
	} else {
		// Proceed to save
		mysqli_query($conn, "INSERT INTO healthrecords (OscaIDNo, HealthName, HealthDate, HealthPurpose, HealthAttendanceStatus, HealthTimeIn, HealthEventStatus) 
                VALUES ('$oscaID', '$hname', '$hdate', '$hpurpose', '$status', '$htime', 'Active')");
        
        ?>
            <script>
                window.alert('Attendance saved for <?php echo $hname; ?>');
                window.location="health_attendance.php?name=<?php echo urlencode($hname); ?>&date=<?php echo $hdate; ?>&purpose=<?php echo urlencode($hpurpose); ?>";
            </script>
        <?php
	}
?>