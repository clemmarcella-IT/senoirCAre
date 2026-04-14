<?php
include("includes/session.php");

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

    if(!is_dir('../uploads')) { mkdir('../uploads', 0777, true); }

    $target = "../uploads/";

    // 1. Profile Picture
    $pic = $oscaID . "_profile.jpg";
    move_uploaded_file($_FILES["pic"]["tmp_name"], $target . $pic);

    // 2. Signatures
    $s1 = $oscaID."_sig1.jpg"; move_uploaded_file($_FILES["sig1"]["tmp_name"], $target.$s1);
    $s2 = $oscaID."_sig2.jpg"; move_uploaded_file($_FILES["sig2"]["tmp_name"], $target.$s2);
    $s3 = $oscaID."_sig3.jpg"; move_uploaded_file($_FILES["sig3"]["tmp_name"], $target.$s3);

    // 3. Thumbmarks
    $t1 = $oscaID."_th1.jpg"; move_uploaded_file($_FILES["thumb1"]["tmp_name"], $target.$t1);
    $t2 = $oscaID."_th2.jpg"; move_uploaded_file($_FILES["thumb2"]["tmp_name"], $target.$t2);
    $t3 = $oscaID."_th3.jpg"; move_uploaded_file($_FILES["thumb3"]["tmp_name"], $target.$t3);

    // Insert
    $query = "INSERT INTO seniors (OscaIDNo, LastName, FirstName, MiddleName, Sex, Purok, Barangay, Birthday, Picture, QRCode, CitezenStatus, SignaturePicture1, SignaturePicture2, SignaturePicture3, thumbNailPicture1, thumbNailPicture2, thumbNailPicture3, GenerateDate) 
              VALUES ('$oscaID', '$lname', '$fname', '$mi', '$sex', '$purok', '$brgy', '$bday', '$pic', '$oscaID', '$status', '$s1', '$s2', '$s3', '$t1', '$t2', '$t3', NOW())";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Senior Citizen Successfully Registered!'); window.location='profiling.php';</script>";
    } else {
        echo "<script>alert('Error: ID already exists!'); window.location='register_senior.php';</script>";
    }
}
?>