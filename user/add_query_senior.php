<?php
	include("../includes/db_connection.php");

	if(isset($_POST['oscaID'])){
		$oscaID = $_POST['oscaID']; 
		$fname  = $_POST['fname'];
		$mi     = $_POST['mi'];
		$lname  = $_POST['lname'];
		$sex    = $_POST['sex'];
		$purok  = $_POST['purok']; 
		$brgy   = "Kalawag 1";
		$bday   = $_POST['bday'];
		$status = $_POST['status'];

		$check = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$oscaID'");
		if (mysqli_fetch_array($check)) {
			echo "<script>alert('Error: ID exists.'); window.location='register.php';</script>";
			exit;
		}

		if(!is_dir('../uploads')) { mkdir('../uploads', 0777, true); }
		$target = "../uploads/";

		// 1. Handle File Names
		$pic = $oscaID . "_profile.jpg";
		$s1 = $oscaID . "_sig.jpg";
		$t1 = $oscaID . "_thumb1.jpg";

		move_uploaded_file($_FILES["pic"]["tmp_name"], $target . $pic);
		move_uploaded_file($_FILES["sig1"]["tmp_name"], $target . $s1);
		move_uploaded_file($_FILES["thumb1"]["tmp_name"], $target . $t1);

		// 2. INSERT into seniors table (Only personal info)
		$query1 = "INSERT INTO seniors (OscaIDNo, LastName, FirstName, MiddleName, Sex, Purok, Barangay, Birthday, CitizenStatus, ApprovalStatus, GenerateDate) 
		           VALUES ('$oscaID', '$lname', '$fname', '$mi', '$sex', '$purok', '$brgy', '$bday', '$status', 'pending', NOW())";
		
		mysqli_query($conn, $query1);

		// 3. INSERT into senior_documents table (The 1:1 relationship)
		$query2 = "INSERT INTO senior_documents (OscaIDNo, ProfilePicture, SignaturePicture, ThumbmarkPicture) 
		           VALUES ('$oscaID', '$pic', '$s1', '$t1')";
		
		mysqli_query($conn, $query2);

		echo "<script>alert('Registration submitted! Waiting for approval.'); window.location='login.php';</script>";
	}
?>