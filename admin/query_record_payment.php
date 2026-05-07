<?php
include("../includes/db_connection.php");
date_default_timezone_set('Asia/Manila');

$id = $_POST['oscaID'];
$dues_id = $_POST['dues_id'];
$amount = $_POST['amount'];
$date = date('Y-m-d');
$time = date('H:i:s');

// 1. Get the standard Amount_Required
$check_req = mysqli_query($conn, "SELECT Amount_Required FROM monthly_dues_master WHERE DuesID='$dues_id'");
$amount_required = mysqli_fetch_array($check_req)['Amount_Required'];

// 2. Cumulative Check: Get existing payments before today's entry
$check_paid = mysqli_query($conn, "SELECT SUM(Amount_Paid) as total_paid FROM dues_payments WHERE OscaIDNo='$id' AND DuesID='$dues_id'");
$previous_paid = mysqli_fetch_array($check_paid)['total_paid'] ?? 0;

// 3. Add the new installment
$new_total = $previous_paid + $amount;

// STEP A & B: Determine Payment Status
$payment_status = ($new_total >= $amount_required) ? 'Paid' : 'Partial';

// Record the transaction
mysqli_query($conn, "INSERT INTO dues_payments (OscaIDNo, DuesID, Amount_Paid, Date_Paid, Time_Paid, Payment_Status) 
                     VALUES ('$id', '$dues_id', '$amount', '$date', '$time', '$payment_status')");

// STEP C & 3: Activate or Deactivate strictly based on debt clearance
if ($new_total >= $amount_required) {
    mysqli_query($conn, "UPDATE seniors SET CitizenStatus = 'Active' WHERE OscaIDNo = '$id'");
    $msg = "Success! Debt cleared. The Senior is now ACTIVE.";
} else {
    mysqli_query($conn, "UPDATE seniors SET CitizenStatus = 'Inactive' WHERE OscaIDNo = '$id'");
    $balance = $amount_required - $new_total;
    $msg = "Partial payment logged. Remaining Balance: P" . number_format($balance, 2) . " | Status remains INACTIVE.";
}

echo "<script>alert('$msg'); window.location='dues_collection.php?id=$dues_id';</script>";
?>