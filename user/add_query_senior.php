<?php
	include("../includes/db_connection.php");

	if(isset($_POST['oscaID'])){
		// 1. Collect Text Data (Variables match the register.php form)
		$oscaID = $_POST['oscaID']; // Preserves leading zeros (e.g., 00123)
		$fname  = $_POST['fname'];
		$mi     = $_POST['mi'];
		$lname  = $_POST['lname'];
		$sex    = $_POST['sex'];
		$purok  = $_POST['purok']; 
		$brgy   = "Kalawag 1";
		$bday   = $_POST['bday'];
		$status = $_POST['status'];

		// Check if this ID already exists
		$check = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$oscaID'");
		if (mysqli_fetch_array($check)) {
			echo "<script>alert('Error: OscaIDNo $oscaID already exists.'); window.location='register.php';</script>";
			exit;
		}

		// 2. Ensure the uploads folder exists in the root directory
		if(!is_dir('../uploads')) { mkdir('../uploads', 0777, true); }

		// 3. Handle Official Profile Picture
		$pic = $oscaID . "_profile.jpg";
		move_uploaded_file($_FILES["pic"]["tmp_name"], "../uploads/" . $pic);

		// 4. Handle One Signature Picture
		$s1 = $oscaID . "_sig.jpg";
		move_uploaded_file($_FILES["sig1"]["tmp_name"], "../uploads/" . $s1);

		// 5. Handle Single Thumbmark Picture
		$t1 = $oscaID . "_thumb1.jpg"; move_uploaded_file($_FILES["thumb1"]["tmp_name"], "../uploads/" . $t1);

		// 6. SQL Insert Query (Preserves 00 and uses NOW() for GenerateDate)
		mysqli_query($conn, "INSERT INTO seniors (
			OscaIDNo, 
			LastName, 
			FirstName, 
			MiddleName, 
			Sex, 
			Purok, 
			Barangay, 
			Birthday, 
			Picture, 
			QRCode, 
			CitizenStatus, 
			SignaturePicture, 
			thumbNailPicture, 
			GenerateDate,
			ApprovalStatus
		) VALUES (
			'$oscaID', 
			'$lname', 
			'$fname', 
			'$mi', 
			'$sex', 
			'$purok', 
			'$brgy', 
			'$bday', 
			'$pic', 
			'$oscaID', 
			'$status', 
			'$s1', 
			'$t1', 
			NOW(),
			'pending'
		)");

		// 7. Alert the user to wait for admin approval and redirect to login
		echo "<script>alert('Registration submitted successfully! Please wait for the admin approval before you can log in.'); window.location='login.php';</script>";
	}
?>