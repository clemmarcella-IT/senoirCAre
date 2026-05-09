<?php
include("../includes/db_connection.php");
$id = $_GET['id'];
$ename = $_POST['ename'];
$edate = $_POST['edate'];
$etime = $_POST['etime'];

mysqli_query($conn, "UPDATE activities SET ActivityName='$ename', ActivityDate='$edate', ActivityTimeStart='$etime' WHERE ActivityID='$id'");
?>
<script>
    window.alert('Activity updated successfully!');
    window.location="activity.php";
</script>