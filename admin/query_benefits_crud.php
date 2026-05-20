<?php 
include('includes/session.php'); 
include('../includes/db_connection.php');

if (isset($_POST['edit_claim'])) {
    $log_id = $_POST['log_id'];
    $amount = $_POST['amount'];
    $reason = $_POST['reason'];
    $date = $_POST['date'];
    mysqli_query($conn, "UPDATE transaction_logs SET Amount_Released='$amount', Reason='$reason', DateRecorded='$date' WHERE LogID='$log_id'");
    echo "<script>alert('Claim updated successfully!'); window.location='benefits.php';</script>";
    exit;
}

if (isset($_POST['delete_claim'])) {
    $log_id = $_POST['log_id'];
    mysqli_query($conn, "DELETE FROM transaction_logs WHERE LogID='$log_id'");
    echo "<script>alert('Claim deleted successfully!'); window.location='benefits.php';</script>";
    exit;
}


header('Location: benefits.php');
exit;
?>
