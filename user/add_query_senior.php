<?php
	include("../includes/db_connection.php");

	if(isset($_POST['oscaID'])){
		// 1. Collect Text Data (Variables match the register.php form)
		$oscaID = mysqli_real_escape_string($conn, $_POST['oscaID']); // Preserves leading zeros (e.g., 00123)
		$fname  = mysqli_real_escape_string($conn, $_POST['fname']);
		$mi     = mysqli_real_escape_string($conn, $_POST['mi']);
		$lname  = mysqli_real_escape_string($conn, $_POST['lname']);
		$sex    = mysqli_real_escape_string($conn, $_POST['sex']);
		$purok  = mysqli_real_escape_string($conn, $_POST['purok']); 
		$brgy   = "Kalawag 1";
		$bday   = mysqli_real_escape_string($conn, $_POST['bday']);
		$status = mysqli_real_escape_string($conn, $_POST['status']);

		// Calculate Age
		$birthDate = new DateTime($bday);
		$today = new DateTime();
		$age = $today->diff($birthDate)->y;

		// 2. Ensure the uploads folder exists in the root directory
		if(!is_dir('../uploads')) { mkdir('../uploads', 0777, true); }

		// 3. Handle Official Profile Picture
		$pic = $oscaID . "_profile.jpg";
		move_uploaded_file($_FILES["pic"]["tmp_name"], "../uploads/" . $pic);

		// 4. Handle One Signature Picture
		$s1 = $oscaID . "_sig.jpg";
		move_uploaded_file($_FILES["sig1"]["tmp_name"], "../uploads/" . $s1);

		// 5. Handle Three (3) Thumbmark Pictures
		$t1 = $oscaID . "_thumb1.jpg"; move_uploaded_file($_FILES["thumb1"]["tmp_name"], "../uploads/" . $t1);
		$t2 = $oscaID . "_thumb2.jpg"; move_uploaded_file($_FILES["thumb2"]["tmp_name"], "../uploads/" . $t2);
		$t3 = $oscaID . "_thumb3.jpg"; move_uploaded_file($_FILES["thumb3"]["tmp_name"], "../uploads/" . $t3);

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
			Age, 
			Picture, 
			QRCode, 
			CitizenStatus, 
			SignaturePicture, 
			thumbNailPicture1, 
			thumbNailPicture2, 
			thumbNailPicture3, 
			GenerateDate
		) VALUES (
			'$oscaID', 
			'$lname', 
			'$fname', 
			'$mi', 
			'$sex', 
			'$purok', 
			'$brgy', 
			'$bday', 
			'$age', 
			'$pic', 
			'$oscaID', 
			'$status', 
			'$s1', 
			'$t1', 
			'$t2', 
			'$t3', 
			NOW()
		)");

		// 7. Redirect to the profile result page
		header("location:profile.php?id=" . $oscaID);
	}
?>