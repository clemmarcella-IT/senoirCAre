<?php
include("includes/session.php");

if (isset($_POST['approve_btn'])) {
    $id = $_POST['approve_id'];

    $query = "UPDATE seniors SET ApprovalStatus = 'approved' WHERE OscaIDNo = '$id'";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Senior Citizen Approved Successfully!'); window.location='profiling.php';</script>";
    } else {
        echo "<script>alert('Error approving senior citizen.'); window.location='profiling.php';</script>";
    }
} else {
    header("location:profiling.php");
}
?>
