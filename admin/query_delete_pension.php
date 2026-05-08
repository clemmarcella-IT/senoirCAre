<?php
include("../includes/db_connection.php");

// Get the identifier from the URL
$id = $_GET['id'];

// Perform the deletion
mysqli_query($conn, "DELETE FROM pension_master WHERE PensionMasterID='$id'");
?>

<!-- Alert and Redirect -->
<script>
    window.alert('Pension Payout deleted successfully!');
    window.location="pension.php";
</script>