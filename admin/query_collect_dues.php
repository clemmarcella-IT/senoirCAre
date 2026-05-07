<?php
include("includes/session.php");

if (isset($_POST['dues_id']) && isset($_POST['osca_id']) && isset($_POST['amount_paid'])) {
    $dues_id = $_POST['dues_id'];
    $osca_id = $_POST['osca_id'];
    $amount_paid = $_POST['amount_paid'];
    $amount_required = $_POST['amount_required'];

    $date_paid = date('Y-m-d');
    $time_paid = date('H:i:s');

    // Calculate total paid including this new payment
    $sum_q = mysqli_query($conn, "SELECT SUM(Amount_Paid) as total FROM dues_payments WHERE OscaIDNo = '$osca_id' AND DuesID = '$dues_id'");
    $sum_row = mysqli_fetch_array($sum_q);
    $total_previously_paid = $sum_row['total'] ? $sum_row['total'] : 0;
    
    $new_total = $total_previously_paid + $amount_paid;
    
    // Determine the status if the cumulative total equals or exceeds the requirement
    $status = ($new_total >= $amount_required) ? 'Paid' : 'Partial';

    // Insert manual payment record
    mysqli_query($conn, "INSERT INTO dues_payments (OscaIDNo, DuesID, Amount_Paid, Date_Paid, Time_Paid, Payment_Status) 
                         VALUES ('$osca_id', '$dues_id', '$amount_paid', '$date_paid', '$time_paid', '$status')");

    // Automatically ACTIVATE the Senior's Status upon payment
    mysqli_query($conn, "UPDATE seniors SET CitizenStatus = 'Active' WHERE OscaIDNo = '$osca_id'");

    echo "<script>alert('Payment recorded successfully! Status upgraded to Active.'); window.location='dues_collection.php?id=$dues_id';</script>";
} else {
    echo "<script>window.location='monthly_dues.php';</script>";
}
?>