<?php
include("include.php");

if(isset($_POST['oscaID'])){
    $oscaID = $_POST['oscaID'];
    $fname = $_POST['fname'];
    $mi = $_POST['mi'];
    $lname = $_POST['lname'];
    $sex = $_POST['sex'];
    $purok = $_POST['purok']; 
    $brgy = "Kalawag 1";
    $bday = $_POST['bday'];
    $status = $_POST['status'];

  
    $pic = $oscaID . "_profile.jpg";
    move_uploaded_file($_FILES["pic"]["tmp_name"], "uploads/" . $pic);
   

  
    mysqli_query($conn, "INSERT INTO seniors (OscaIDNo, LastName, FirstName, MiddleName, Sex, Purok, Barangay, Birthday, Picture, QRCode, CitezenStatus, SignaturePicture1, SignaturePicture2, SignaturePicture3, thumbNailPicture1, thumbNailPicture2, thumbNailPicture3, GenerateDate) 
    VALUES ('$oscaID', '$lname', '$fname', '$mi', '$sex', '$purok', '$brgy', '$bday', '$pic', '$oscaID', '$status', '$s1', '$s2', '$s3', '$t1', '$t2', '$t3', NOW())");

    header("location:profile.php?id=" . $oscaID);
}
?>