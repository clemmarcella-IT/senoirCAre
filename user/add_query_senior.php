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

// 2. INSERT into seniors table including image file names
        $query1 = "INSERT INTO seniors (OscaIDNo, LastName, FirstName, MiddleName, Sex, Purok, Barangay, Birthday, CitizenStatus, ApprovalStatus, GenerateDate, Picture, SignaturePicture, ThumbmarkPicture) 
                   VALUES ('$oscaID', '$lname', '$fname', '$mi', '$sex', '$purok', '$brgy', '$bday', '$status', 'pending', NOW(), '$pic', '$s1', '$t1')";
        
        if (mysqli_query($conn, $query1)) {
            echo "<script>alert('Registration submitted! Waiting for approval or Contact the Admin the number is in the Dashboard.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Error: Registration failed!'); window.location='register.php';</script>";
        }
	}
?>