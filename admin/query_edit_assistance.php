<?php
include("../includes/db_connection.php");

$old_name = $_GET['old_name'];
$old_date = $_GET['old_date'];

$new_name = $_POST['aname'];
$new_date = $_POST['adate'];
$new_type = $_POST['atype'];

mysqli_query($conn, "UPDATE assistance SET 
    AssistanceName = '$new_name', 
    AssistanceDate = '$new_date', 
    TypeAssistance = '$new_type' 
    WHERE AssistanceName = '$old_name' AND AssistanceDate = '$old_date'");
?>
<script>
    window.alert('Assistance Record updated successfully!');
    window.location="assistance.php";
</script>