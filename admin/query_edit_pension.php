<?php
include("../includes/db_connection.php");

$id = $_GET['id'];
$new_date = $_POST['pdate'];
$new_amount = $_POST['pamount'];

mysqli_query($conn, "UPDATE pension_master SET PayoutDate='$new_date', CashAmount='$new_amount' WHERE PensionMasterID='$id'");
?>


<script>
    window.alert('Pension Payout updated successfully!');
    window.location="pension.php";
</script>