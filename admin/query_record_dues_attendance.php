<?php
include("../includes/db_connection.php");
date_default_timezone_set('Asia/Manila');

$id = $_POST['oscaID'];
$dues_id = $_POST['dues_id'];
$amount = $_POST['amount'];
$date = date('Y-m-d');
$time = date('H:i:s');

// Restrict duplicates
$check = mysqli_query($conn, "SELECT * FROM dues_payments WHERE OscaIDNo='$id' AND DuesID='$dues_id'");
if(mysqli_fetch_array($check)) {
    echo "<script>alert('Duplicate: Dues already paid by this Senior.'); window.history.back();</script>";
} else {
    // Record payment/attendance
    mysqli_query($conn, "INSERT INTO dues_payments (OscaIDNo, DuesID, Amount_Paid, Date_Paid, Time_Paid, Payment_Status) 
                         VALUES ('$id', '$dues_id', '$amount', '$date', '$time', 'Paid')");
    
    // Automatically Activate the Senior Status
    mysqli_query($conn, "UPDATE seniors SET CitizenStatus = 'Active' WHERE OscaIDNo = '$id'");
    
    header("location:dues_attendance.php?id=$dues_id");
}
?>