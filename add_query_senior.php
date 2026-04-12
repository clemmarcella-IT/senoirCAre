<?php
	include("include.php");

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

		// 2. Ensure the uploads folder exists
		if(!is_dir('uploads')) { mkdir('uploads', 0777, true); }

		// 3. Handle Official Profile Picture
		$pic = $oscaID . "_profile.jpg";
		move_uploaded_file($_FILES["pic"]["tmp_name"], "uploads/" . $pic);

		// 4. Handle Three (3) Signature Pictures
		$s1 = $oscaID . "_sig1.jpg"; move_uploaded_file($_FILES["sig1"]["tmp_name"], "uploads/" . $s1);
		$s2 = $oscaID . "_sig2.jpg"; move_uploaded_file($_FILES["sig2"]["tmp_name"], "uploads/" . $s2);
		$s3 = $oscaID . "_sig3.jpg"; move_uploaded_file($_FILES["sig3"]["tmp_name"], "uploads/" . $s3);

		// 5. Handle Three (3) Thumbmark Pictures
		$t1 = $oscaID . "_thumb1.jpg"; move_uploaded_file($_FILES["thumb1"]["tmp_name"], "uploads/" . $t1);
		$t2 = $oscaID . "_thumb2.jpg"; move_uploaded_file($_FILES["thumb2"]["tmp_name"], "uploads/" . $t2);
		$t3 = $oscaID . "_thumb3.jpg"; move_uploaded_file($_FILES["thumb3"]["tmp_name"], "uploads/" . $t3);

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
			CitezenStatus, 
			SignaturePicture1, 
			SignaturePicture2, 
			SignaturePicture3, 
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
			'$pic', 
			'$oscaID', 
			'$status', 
			'$s1', 
			'$s2', 
			'$s3', 
			'$t1', 
			'$t2', 
			'$t3', 
			NOW()
		)");

		// 7. Redirect to the profile result page
		header("location:profile.php?id=" . $oscaID);
	}
?>