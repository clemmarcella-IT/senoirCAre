<?php
include("includes/session.php");

if(isset($_POST['cname'])){
    $name   = $_POST['cname'];
    $amount = $_POST['amount'];
    $date   = $_POST['due_date'];

    mysqli_query($conn, "INSERT INTO monthly_dues_master (Contribution_Name, Amount_Required, Due_Date) 
                         VALUES ('$name', '$amount', '$date')");

    echo "<script>alert('Monthly Dues added successfully!'); window.location='monthly_dues.php';</script>";
} else {
    echo "<script>window.location='monthly_dues.php';</script>";
}
?>
