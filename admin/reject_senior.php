<?php
include("includes/session.php");

if (isset($_POST['reject_btn'])) {
    $id = $_POST['reject_id'];

    // Instead of just marking them as 'rejected', we DELETE the record 
    // so they no longer appear in the profiling list.
    $query = "DELETE FROM seniors WHERE OscaIDNo = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Registration Rejected and Record Removed.'); window.location='profiling.php';</script>";
    } else {
        echo "<script>alert('Error rejecting senior citizen.'); window.location='profiling.php';</script>";
    }
} else {
    header("location:profiling.php");
}
?>