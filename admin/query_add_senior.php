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

    // Check if this ID already exists
    $check = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$oscaID'");
    if (mysqli_fetch_array($check)) {
        echo "<script>alert('Error: OscaIDNo $oscaID already exists.'); window.location='register_senior.php';</script>";
        exit;
    }

    // Remove age calculation since it's dynamic now

    if(!is_dir('../uploads')) { mkdir('../uploads', 0777, true); }

    $target = "../uploads/";

    // 1. Profile Picture
    $pic = $oscaID . "_profile.jpg";
    move_uploaded_file($_FILES["pic"]["tmp_name"], $target . $pic);

    // 2. Signature
    $s1 = $oscaID."_sig.jpg"; move_uploaded_file($_FILES["sig1"]["tmp_name"], $target.$s1);

    // 3. Thumbmarks
    $t1 = $oscaID."_th1.jpg"; move_uploaded_file($_FILES["thumb1"]["tmp_name"], $target.$t1);

    // Insert
    $query = "INSERT INTO seniors (OscaIDNo, LastName, FirstName, MiddleName, Sex, Purok, Barangay, Birthday, Picture, QRCode, CitizenStatus, SignaturePicture, thumbNailPicture, GenerateDate, ApprovalStatus) 
              VALUES ('$oscaID', '$lname', '$fname', '$mi', '$sex', '$purok', '$brgy', '$bday', '$pic', '$oscaID', '$status', '$s1', '$t1', NOW(), 'approved')";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Senior Citizen Successfully Registered!'); window.location='profiling.php';</script>";
    } else {
        echo "<script>alert('Error: ID already exists!'); window.location='register_senior.php';</script>";
    }
}
?>