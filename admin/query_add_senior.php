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

    // Check if this ID already exists so we don't have duplicates
    $check = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$oscaID'");
    if (mysqli_fetch_array($check)) {
        echo "<script>alert('Error: OscaIDNo $oscaID already exists.'); window.location='register_senior.php';</script>";
        exit;
    }

    // Create uploads folder if it does not exist
    if(!is_dir('../uploads')) { mkdir('../uploads', 0777, true); }

    $target = "../uploads/";

    // 1. Upload Profile Picture
    $pic = $oscaID . "_profile.jpg";
    move_uploaded_file($_FILES["pic"]["tmp_name"], $target . $pic);

    // 2. Upload Signature
    $s1 = $oscaID . "_sig.jpg"; 
    move_uploaded_file($_FILES["sig1"]["tmp_name"], $target . $s1);

    // 3. Upload Thumbmarks
    $t1 = $oscaID . "_th1.jpg"; 
    move_uploaded_file($_FILES["thumb1"]["tmp_name"], $target . $t1);

    // FIRST INSERT: Personal Details goes into "seniors" table
    $query1 = "INSERT INTO seniors (OscaIDNo, LastName, FirstName, MiddleName, Sex, Purok, Barangay, Birthday, CitizenStatus, GenerateDate, ApprovalStatus) 
               VALUES ('$oscaID', '$lname', '$fname', '$mi', '$sex', '$purok', '$brgy', '$bday', '$status', NOW(), 'approved')";

    // If personal details saved successfully, proceed to save the images
    if(mysqli_query($conn, $query1)){
        
        // SECOND INSERT: Images go into "senior_documents" table
        $query2 = "INSERT INTO senior_documents (OscaIDNo, ProfilePicture, SignaturePicture, ThumbmarkPicture) 
                   VALUES ('$oscaID', '$pic', '$s1', '$t1')";
        mysqli_query($conn, $query2);

        echo "<script>alert('Senior Citizen Successfully Registered!'); window.location='profiling.php';</script>";
    } else {
        echo "<script>alert('Error: Registration failed!'); window.location='register_senior.php';</script>";
    }
}
?>