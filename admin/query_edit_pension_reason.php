<?php
include("../includes/db_connection.php");

$oscaID = $_POST['oscaID'];
$pid = $_POST['pid'];
$new_control = $_POST['new_control'];
$new_reason = $_POST['new_reason'];

$existing = mysqli_query($conn, "SELECT * FROM transaction_logs WHERE OscaIDNo='$oscaID' AND PensionMasterID='$pid' AND ClaimType='Pension Claim'");
$existingRecord = mysqli_fetch_array($existing);
if ($existingRecord) {
    mysqli_query($conn, "UPDATE transaction_logs SET ControlNo='$new_control', Reason='$new_reason' WHERE OscaIDNo='$oscaID' AND PensionMasterID='$pid' AND ClaimType='Pension Claim'");
} else {
    $date = date('Y-m-d');
    $time = date('H:i:s');
    mysqli_query($conn, "INSERT INTO transaction_logs (OscaIDNo, PensionMasterID, ClaimType, DateRecorded, TimeRecorded, Status, ControlNo, Reason) 
        VALUES ('$oscaID', '$pid', 'Pension Claim', '$date', '$time', 'Unclaimed', '$new_control', '$new_reason')");
}
?>


<script>
    window.alert('Pension payout record updated successfully!');
    window.location="pension_attendance.php?id=<?php echo $pid; ?>";
</script>
