<?php
include("../includes/db_connection.php");


$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM pension_master WHERE PensionMasterID='$id'");
?>


<script>
    window.alert('Pension Payout deleted successfully!');
    window.location="pension.php";
</script>