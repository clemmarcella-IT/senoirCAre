<?php
include("includes/session.php");

if (isset($_POST['reject_btn'])) {
    $id = $_POST['reject_id'];

    $query = "UPDATE seniors SET ApprovalStatus = 'rejected' WHERE OscaIDNo = '$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Senior Citizen Registration Rejected.'); window.location='profiling.php';</script>";
    } else {
        echo "<script>alert('Error rejecting senior citizen.'); window.location='profiling.php';</script>";
    }
} else {
    header("location:profiling.php");
}
?>
