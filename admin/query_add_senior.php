<?php
include("includes/session.php");

if(isset($_POST['oscaID'])){
    $oscaID = mysqli_real_escape_string($conn, $_POST['oscaID']); 
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

    if(!is_dir('../uploads')) { mkdir('../uploads', 0777, true); }

    $target = "../uploads/";

    // 1. Profile Picture
    $pic = $oscaID . "_profile.jpg";
    move_uploaded_file($_FILES["pic"]["tmp_name"], $target . $pic);

    // 2. Signature
    $s1 = $oscaID."_sig.jpg"; move_uploaded_file($_FILES["sig1"]["tmp_name"], $target.$s1);

    // 3. Thumbmarks
    $t1 = $oscaID."_th1.jpg"; move_uploaded_file($_FILES["thumb1"]["tmp_name"], $target.$t1);
    $t2 = $oscaID."_th2.jpg"; move_uploaded_file($_FILES["thumb2"]["tmp_name"], $target.$t2);
    $t3 = $oscaID."_th3.jpg"; move_uploaded_file($_FILES["thumb3"]["tmp_name"], $target.$t3);

    // Insert
    $query = "INSERT INTO seniors (OscaIDNo, LastName, FirstName, MiddleName, Sex, Purok, Barangay, Birthday, Age, Picture, QRCode, CitizenStatus, SignaturePicture, thumbNailPicture1, thumbNailPicture2, thumbNailPicture3, GenerateDate) 
              VALUES ('$oscaID', '$lname', '$fname', '$mi', '$sex', '$purok', '$brgy', '$bday', '$age', '$pic', '$oscaID', '$status', '$s1', '$t1', '$t2', '$t3', NOW())";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Senior Citizen Successfully Registered!'); window.location='profiling.php';</script>";
    } else {
        echo "<script>alert('Error: ID already exists!'); window.location='register_senior.php';</script>";
    }
}
?>