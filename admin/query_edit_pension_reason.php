<?php
include("../includes/db_connection.php");

$oscaID = $_POST['oscaID'];
$pid = $_POST['pid'];
$new_control = $_POST['new_control'];
$new_reason = $_POST['new_reason'];

$existing = mysqli_query($conn, "SELECT * FROM transaction_logs WHERE OscaIDNo='$oscaID' AND PensionMasterID='$pid' AND ClaimType='Pension Claim'");
$existingRecord = mysqli_fetch_array($existing);
if ($existingRecord) {
    mysqli_query($conn, "UPDATE transaction_logs SET ControlNo='$new_control', Reason='$new_reason', Status='Claimed' WHERE OscaIDNo='$oscaID' AND PensionMasterID='$pid' AND ClaimType='Pension Claim'");
} else {
    $amount_q = mysqli_query($conn, "SELECT CashAmount FROM pension_master WHERE PensionMasterID='$pid'");
    $amount_row = mysqli_fetch_array($amount_q);
    $amount = $amount_row ? $amount_row['CashAmount'] : 0;
    $date = date('Y-m-d');
    $time = date('H:i:s');
    mysqli_query($conn, "INSERT INTO transaction_logs (OscaIDNo, PensionMasterID, ClaimType, Amount_Released, DateRecorded, TimeRecorded, Status, ControlNo, Reason) 
        VALUES ('$oscaID', '$pid', 'Pension Claim', '$amount', '$date', '$time', 'Claimed', '$new_control', '$new_reason')");
}
?>

<!-- Alert and Redirect -->
<script>
    window.alert('Pension payout record updated successfully!');
    window.location="pension_attendance.php?id=<?php echo $pid; ?>";
</script>
