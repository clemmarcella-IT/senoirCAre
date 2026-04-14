<?php
	include("../includes/db_connection.php");
	$id = $_GET['id'];
	
	// Collect text data
	$fname  = $_POST['fname'];
	$mi     = $_POST['mi'];
	$lname  = $_POST['lname'];
	$sex    = $_POST['sex'];
	$bday   = $_POST['bday'];
	$purok  = $_POST['purok'];
	$status = $_POST['status'];

	// 1. Build the basic UPDATE query for text
	$updateQuery = "UPDATE seniors SET FirstName='$fname', MiddleName='$mi', LastName='$lname', Sex='$sex', Birthday='$bday', Purok='$purok', CitezenStatus='$status'";

	// 2. Check for newly uploaded files (Only update if a file was chosen)
	$targetDir = "../uploads/";

	// Profile Picture
	if($_FILES['pic']['name'] != '') {
		$picName = $id . "_profile_updated_" . time() . ".jpg";
		move_uploaded_file($_FILES['pic']['tmp_name'], $targetDir . $picName);
		$updateQuery .= ", Picture='$picName'";
	}

	// 3 Signatures
	for($i=1; $i<=3; $i++) {
		$sigKey = 'sig'.$i;
		if($_FILES[$sigKey]['name'] != '') {
			$sigName = $id . "_sig{$i}_updated_" . time() . ".jpg";
			move_uploaded_file($_FILES[$sigKey]['tmp_name'], $targetDir . $sigName);
			$updateQuery .= ", SignaturePicture{$i}='$sigName'";
		}
	}

	// 3 Thumbmarks
	for($i=1; $i<=3; $i++) {
		$thumbKey = 'thumb'.$i;
		if($_FILES[$thumbKey]['name'] != '') {
			$thumbName = $id . "_thumb{$i}_updated_" . time() . ".jpg";
			move_uploaded_file($_FILES[$thumbKey]['tmp_name'], $targetDir . $thumbName);
			$updateQuery .= ", thumbNailPicture{$i}='$thumbName'";
		}
	}

	// 3. Finalize and execute the query
	$updateQuery .= " WHERE OscaIDNo='$id'";
	mysqli_query($conn, $updateQuery);
	
	?>
		<script>
			window.alert('Senior Citizen Profile updated successfully!');
			window.location="profiling.php";
		</script>
	<?php
?>