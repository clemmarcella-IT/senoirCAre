<?php
include("../includes/db_connection.php");

$date = $_POST['pdate'];
$amount = $_POST['pamount'];

$result = mysqli_query($conn, "INSERT INTO pension_master (PayoutDate, CashAmount) VALUES ('$date', '$amount')");
if (!$result) {
    echo "<script>alert('Error adding pension payout!'); window.location='pension.php';</script>";
    exit;
}
?>
<script>
    window.alert('Pension Payout created successfully!');
    window.location="pension.php";
</script>