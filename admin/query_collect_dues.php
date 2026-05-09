<?php
include("includes/session.php");

if (isset($_POST['dues_id']) && isset($_POST['osca_id']) && isset($_POST['amount_paid'])) {
    $dues_id = $_POST['dues_id'];
    $osca_id = $_POST['osca_id'];
    $amount_paid = $_POST['amount_paid'];
    $amount_required = $_POST['amount_required'];

    $date_paid = date('Y-m-d');

    // Calculate total paid including this new payment
    $sum_q = mysqli_query($conn, "SELECT SUM(Amount_Paid) as total FROM dues_payments WHERE OscaIDNo = '$osca_id' AND DuesID = '$dues_id'");
    $sum_row = mysqli_fetch_array($sum_q);
    $total_previously_paid = $sum_row['total'] ? $sum_row['total'] : 0;
    
    $new_total = $total_previously_paid + $amount_paid;
    
    // Check if the new total exceeds the required amount
    if ($new_total > $amount_required) {
        $excess = $new_total - $amount_required;
        echo "<script>alert('Overpayment detected. The required amount is ₱" . number_format($amount_required, 2) . ". Previously paid: ₱" . number_format($total_previously_paid, 2) . ". This payment would exceed by ₱" . number_format($excess, 2) . ". Please adjust the amount.'); window.history.back();</script>";
        exit;
    }
    
    // Determine the status if the cumulative total equals or exceeds the requirement
    $status = ($new_total >= $amount_required) ? 'Paid' : 'Partial';

    // Insert manual payment record
    mysqli_query($conn, "INSERT INTO dues_payments (OscaIDNo, DuesID, Amount_Paid, Date_Paid, Payment_Status) 
                         VALUES ('$osca_id', '$dues_id', '$amount_paid', '$date_paid', '$status')");

    // Automatically ACTIVATE the Senior's Status only if fully paid
    if ($new_total >= $amount_required) {
        mysqli_query($conn, "UPDATE seniors SET CitizenStatus = 'Active' WHERE OscaIDNo = '$osca_id'");
        $msg = 'Payment recorded successfully! Status upgraded to Active.';
    } else {
        $msg = 'Partial payment recorded successfully. Remaining balance: ₱' . number_format($amount_required - $new_total, 2);
    }

    echo "<script>alert('$msg'); window.location='dues_collection.php?id=$dues_id';</script>";
} else {
    echo "<script>window.location='monthly_dues.php';</script>";
}
?>