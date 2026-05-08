<?php
require_once('includes/session.php');

$oscaID = isset($_POST['oscaID']) ? mysqli_real_escape_string($conn, $_POST['oscaID']) : '';
$reason = isset($_POST['reason']) ? mysqli_real_escape_string($conn, $_POST['reason']) : '';
$amount = isset($_POST['amount']) ? mysqli_real_escape_string($conn, $_POST['amount']) : '';
$date = isset($_POST['date']) ? mysqli_real_escape_string($conn, $_POST['date']) : date('Y-m-d');
$time = date('H:i:s');

if (!$oscaID || !$reason || !$amount) {
    echo "<script>alert('Please scan a valid QR code and complete all fields.'); window.history.back();</script>";
    exit;
}

$checkSenior = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo='$oscaID'");
if (mysqli_num_rows($checkSenior) == 0) {
    echo "<script>alert('Senior record not found. Please verify the scanned QR code.'); window.history.back();</script>";
    exit;
}

if (!is_numeric($amount) || floatval($amount) <= 0) {
    echo "<script>alert('Please enter a valid amount greater than zero.'); window.history.back();</script>";
    exit;
}

// Check available funds: Total Dues Income - Total Benefits Released
$totalIncomeQuery = mysqli_query($conn, "SELECT SUM(Amount_Paid) AS total_income FROM dues_payments WHERE Payment_Status = 'Paid'");
$totalIncomeRow = mysqli_fetch_array($totalIncomeQuery);
$totalIncome = $totalIncomeRow['total_income'] ? floatval($totalIncomeRow['total_income']) : 0;

$totalBenefitsQuery = mysqli_query($conn, "SELECT SUM(Amount_Released) AS total_benefits FROM transaction_logs WHERE ClaimType = 'Benefit Claim' AND Status = 'Claimed'");
$totalBenefitsRow = mysqli_fetch_array($totalBenefitsQuery);
$totalBenefits = $totalBenefitsRow['total_benefits'] ? floatval($totalBenefitsRow['total_benefits']) : 0;

$availableFunds = $totalIncome - $totalBenefits;

if ($availableFunds <= 0) {
    echo "<script>alert('No funds available for benefit claims. Total income: ₱" . number_format($totalIncome, 2) . ", Total benefits released: ₱" . number_format($totalBenefits, 2) . ".'); window.history.back();</script>";
    exit;
}

if ($amountValue > $availableFunds) {
    echo "<script>alert('Insufficient funds. Available balance: ₱" . number_format($availableFunds, 2) . ". Please reduce the claim amount.'); window.history.back();</script>";
    exit;
}

$amountValue = number_format((float)$amount, 2, '.', '');

$insert = mysqli_query($conn, "INSERT INTO transaction_logs (OscaIDNo, ClaimType, Amount_Released, DateRecorded, TimeRecorded, Status, Reason) VALUES ('$oscaID', 'Benefit Claim', '$amountValue', '$date', '$time', 'Claimed', '$reason')");

if ($insert) {
    echo "<script>alert('Notification: Benefit for $reason in the amount of ₱$amountValue was released on $date.'); window.location='benefits.php';</script>";
} else {
    echo "<script>alert('Error saving benefit claim. Please try again.'); window.history.back();</script>";
}
