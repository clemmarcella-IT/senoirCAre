<?php
include("includes/session.php");

if(isset($_POST['amount']) && isset($_POST['due_date'])){
    $amount = $_POST['amount'];
    $date   = $_POST['due_date'];

    $month = date("F", strtotime($date));
    $year = date("Y", strtotime($date));
    $contribution_name = "MonthlyDue_{$month}_{$year}";

    mysqli_query($conn, "INSERT INTO monthly_dues_master (Contribution_Name, Amount_Required, Due_Date) 
                         VALUES ('$contribution_name', '$amount', '$date')");

    echo "<script>alert('Monthly Dues added successfully! ($contribution_name)'); window.location='monthly_dues.php';</script>";
} else {
    echo "<script>window.location='monthly_dues.php';</script>";
}
?>
