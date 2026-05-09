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

// 2. Check if there's already a dues payment record for this senior/dues period
$existing_payment = mysqli_query($conn, "SELECT PaymentID, Amount_Paid FROM dues_payments WHERE OscaIDNo='$id' AND DuesID='$dues_id'");
$existing_record = mysqli_fetch_array($existing_payment);

// 3. Calculate new total
if ($existing_record) {
    // Update existing record
    $current_paid = $existing_record['Amount_Paid'];
    $new_total = $current_paid + $amount;
    $payment_status = ($new_total >= $amount_required) ? 'Paid' : 'Partial';
    
    // Update the existing dues payment record
    mysqli_query($conn, "UPDATE dues_payments SET 
                        Amount_Paid = '$new_total', 
                        Date_Paid = '$date', 
                        Time_Paid = '$time',
                        Payment_Status = '$payment_status' 
                        WHERE PaymentID = '{$existing_record['PaymentID']}'");
} else {
    // Insert new record
    $new_total = $amount;
    $payment_status = ($new_total >= $amount_required) ? 'Paid' : 'Partial';
    
    mysqli_query($conn, "INSERT INTO dues_payments (OscaIDNo, DuesID, Amount_Paid, Date_Paid, Time_Paid, Payment_Status) 
                         VALUES ('$id', '$dues_id', '$amount', '$date', '$time', '$payment_status')");
}

// Always insert into transaction_logs for notifications
mysqli_query($conn, "INSERT INTO transaction_logs (OscaIDNo, ClaimType, Amount_Released, DateRecorded, TimeRecorded, Status, Reason) 
                     VALUES ('$id', 'Dues Payment', '$amount', '$date', '$time', '$payment_status', 'Dues payment for DuesID $dues_id')");

// STEP C & 3: Activate or Deactivate strictly based on debt clearance
if ($new_total >= $amount_required) {
    mysqli_query($conn, "UPDATE seniors SET CitizenStatus = 'Active' WHERE OscaIDNo = '$id'");
    $msg = "Success! Debt cleared. The Senior is now ACTIVE.";
} else {
    mysqli_query($conn, "UPDATE seniors SET CitizenStatus = 'Inactive' WHERE OscaIDNo = '$id'");
    $balance = $amount_required - $new_total;
    $msg = "Partial payment logged. Remaining Balance: P$balance | Status remains INACTIVE.";
}

echo "<script>alert('$msg'); window.location='dues_collection.php?id=$dues_id';</script>";
?>