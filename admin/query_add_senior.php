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
    $pensionStatus = $_POST['pension_status'];

    $check = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$oscaID'");
    if (mysqli_fetch_array($check)) {
        echo "<script>alert('Error: ID already exists.'); window.location='register_senior.php';</script>";
        exit;
    }

    $target = "../uploads/";
    if(!is_dir($target)) { mkdir($target, 0777, true); }

    // Prepare File Names
    $pic = $oscaID . "_profile.jpg";
    $sig = $oscaID . "_sig.jpg";
    $thumb = $oscaID . "_thumb.jpg";

    // Upload Files
    move_uploaded_file($_FILES["pic"]["tmp_name"], $target . $pic);
    move_uploaded_file($_FILES["sig1"]["tmp_name"], $target . $sig);
    move_uploaded_file($_FILES["thumb1"]["tmp_name"], $target . $thumb);

    // DEBUGGED: Single INSERT into seniors table
    $query = "INSERT INTO seniors (OscaIDNo, LastName, FirstName, MiddleName, Sex, Purok, Barangay, Birthday, CitizenStatus, PensionerStatus, Picture, SignaturePicture, ThumbmarkPicture) 
              VALUES ('$oscaID', '$lname', '$fname', '$mi', '$sex', '$purok', '$brgy', '$bday', '$status', '$pensionStatus', '$pic', '$sig', '$thumb')";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Senior Citizen Successfully Registered!'); window.location='profiling.php';</script>";
    } else {
        echo "<script>alert('Database Error!'); window.location='register_senior.php';</script>";
    }
}
?>