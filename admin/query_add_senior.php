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

    // Check if ID already exists
    $check = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$oscaID'");
    if (mysqli_fetch_array($check)) {
        echo "<script>alert('Error: OscaIDNo $oscaID already exists.'); window.location='register_senior.php';</script>";
        exit;
    }

    // Insert into seniors table (matches the actual DB columns)
    $query = "INSERT INTO seniors (OscaIDNo, LastName, FirstName, MiddleName, Sex, Purok, Barangay, Birthday, CitizenStatus, PensionerStatus) 
              VALUES ('$oscaID', '$lname', '$fname', '$mi', '$sex', '$purok', '$brgy', '$bday', '$status', '$pensionStatus')";

    if(mysqli_query($conn, $query)){
        echo "<script>alert('Senior Citizen Successfully Registered!'); window.location='profiling.php';</script>";
    } else {
        echo "<script>alert('Database Error: Could not register senior.'); window.location='register_senior.php';</script>";
    }
}
?>