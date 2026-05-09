<?php
include("../includes/db_connection.php");

$oscaID = $_POST['oscaID'];
$pid = $_POST['pid'];
$new_control = $_POST['new_control'];
$new_reason = $_POST['new_reason'];

<<<<<<< HEAD
// We store the reason inside "PensionAttendanceStatus" instead of overwriting the Session Name (PensionReason)
if ($new_reason != "") {
    $status = $new_reason;
} else {
    $status = 'Unclaimed';
=======
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
>>>>>>> newrevisesystem
}
?>

<<<<<<< HEAD
// 1. Check if the senior already has a record for this event
$check_sql = "SELECT * FROM pension WHERE OscaIDNo = '$id' AND PensionReason = '$preason' AND PensionDate = '$pdate'";
$check_res = mysqli_query($conn, $check_sql);
$row = mysqli_fetch_array($check_res);

if ($row) {
    // Check if they already claimed. Prevent un-claiming them if admin only typed a control number
    if ($row['PensionAttendanceStatus'] == 'Claimed' || $row['PensionAttendanceStatus'] == 'claimed') {
        if ($new_reason != "") {
            $final_status = $new_reason; 
        } else {
            $final_status = 'Claimed'; 
        }
    } else {
        $final_status = $status; 
    }

    // UPDATE RECORD
    $update_sql = "UPDATE pension SET ControlNo = '$new_control', PensionAttendanceStatus = '$final_status' WHERE OscaIDNo = '$id' AND PensionReason = '$preason' AND PensionDate = '$pdate'";
    mysqli_query($conn, $update_sql);

} else {
    // 2. If no record yet, grab the event's generic Cash Amount to prepare for an INSERT
    $amount_sql = "SELECT PensionCashAmount FROM pension WHERE PensionReason = '$preason' AND PensionDate = '$pdate' AND OscaIDNo IS NULL";
    $amount_res = mysqli_query($conn, $amount_sql);
    $amount_row = mysqli_fetch_array($amount_res);
    
    $amount = 0;
    if ($amount_row) {
        $amount = $amount_row['PensionCashAmount'];
    }

    // INSERT NEW RECORD because they are completely "Unclaimed" with no DB trace
    $insert_sql = "INSERT INTO pension (OscaIDNo, PensionReason, PensionDate, PensionCashAmount, ControlNo, PensionAttendanceStatus) VALUES ('$id', '$preason', '$pdate', '$amount', '$new_control', '$status')";
    mysqli_query($conn, $insert_sql);
}

header("location:pension_attendance.php?reason=$preason&date=$pdate");
?>
=======
<!-- Alert and Redirect -->
<script>
    window.alert('Pension payout record updated successfully!');
    window.location="pension_attendance.php?id=<?php echo $pid; ?>";
</script>
>>>>>>> newrevisesystem
