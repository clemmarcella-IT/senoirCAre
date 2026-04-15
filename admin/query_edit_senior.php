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

	// 3. Start building the SQL command (Text part)
	$sql = "UPDATE seniors SET 
			FirstName = '$fname', 
			MiddleName = '$mi', 
			LastName = '$lname', 
			Sex = '$sex', 
			Birthday = '$bday', 
			Purok = '$purok', 
			CitezenStatus = '$status'";

	// 4. Set where we want to save the photos
	$folder = "../uploads/";

	// 5. PROFILE PICTURE: Check if the admin chose a new file
	if($_FILES['pic']['name'] != "") {
		$picName = $id . "_updated_profile.jpg";
		move_uploaded_file($_FILES['pic']['tmp_name'], $folder . $picName);
		// Add this new filename to our SQL command
		$sql .= ", Picture = '$picName'";
	}

	// 6. SIGNATURES: Check all 3 signature boxes
	for($i=1; $i<=3; $i++) {
		$inputName = "sig" . $i; // sig1, sig2, sig3
		if($_FILES[$inputName]['name'] != "") {
			$fileName = $id . "_updated_sig" . $i . ".jpg";
			move_uploaded_file($_FILES[$inputName]['tmp_name'], $folder . $fileName);
			$sql .= ", SignaturePicture$i = '$fileName'";
		}
	}

	// 7. THUMBMARKS: Check all 3 thumbmark boxes
	for($i=1; $i<=3; $i++) {
		$inputName = "thumb" . $i; // thumb1, thumb2, thumb3
		if($_FILES[$inputName]['name'] != "") {
			$fileName = $id . "_updated_thumb" . $i . ".jpg";
			move_uploaded_file($_FILES[$inputName]['tmp_name'], $folder . $fileName);
			$sql .= ", thumbNailPicture$i = '$fileName'";
		}
	}

	// 8. Finish the SQL command by telling it which Senior to update
	$sql .= " WHERE OscaIDNo = '$id'";

	// 9. Run the command in the database
	mysqli_query($conn, $sql);
	
	// 10. Show a simple alert and go back to the list
	?>
		<script>
			window.alert('Senior Citizen Profile updated successfully!');
			window.location="profiling.php";
		</script>
	<?php
?>