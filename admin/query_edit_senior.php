<?php
	include("../includes/db_connection.php");

	// 1. Get the ID of the senior we are editing from the URL
	$id = $_GET['id'];
	
	// 2. Collect all the text information from the form
	$fname  = $_POST['fname'];
	$mi     = $_POST['mi'];
	$lname  = $_POST['lname'];
	$sex    = $_POST['sex'];
	$bday   = $_POST['bday'];
	$purok  = $_POST['purok'];
	$status = $_POST['status'];

	// Removed Age calculation as Age is dynamic now

	// 3. Start building the SQL command (Text part)
	$sql = "UPDATE seniors SET 
			FirstName = '$fname', 
			MiddleName = '$mi', 
			LastName = '$lname', 
			Sex = '$sex', 
			Birthday = '$bday', 
			Purok = '$purok', 
			CitizenStatus = '$status' WHERE OscaIDNo = '$id'";

	// 4. Run the command in the database
	mysqli_query($conn, $sql);
	
	// 5. Show a simple alert and go back to the list
	?>
		<script>
			window.alert('Senior Citizen Profile updated successfully!');
			window.location="profiling.php";
		</script>
	<?php
?>