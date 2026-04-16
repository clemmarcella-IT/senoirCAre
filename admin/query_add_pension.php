<?php
include("../includes/db_connection.php");

$date = $_POST['pdate'];
$amount = $_POST['pamount'];

// Use the date string as the Reason so it identifies this specific session
$reason = $date; 

mysqli_query($conn, "INSERT INTO pension (PensionReason, PensionDate, PensionCashAmount, PensionEventStatus) 
VALUES ('$reason', '$date', '$amount', 'Active')");
?>
<script>
    window.alert('Pension Payout Session created successfully!');
    window.location="pension.php";
</script>