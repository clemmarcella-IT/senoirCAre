<?php
include("../includes/db_connection.php");
$id = $_POST['id'];
$lastTime = $_POST['lastTime'];
$last_date = substr($lastTime, 0, 10);
$last_time = substr($lastTime, 11);
$query = mysqli_query($conn, "SELECT transaction_logs.*, activities.ActivityName FROM transaction_logs LEFT JOIN activities ON transaction_logs.ActivityID = activities.ActivityID WHERE transaction_logs.OscaIDNo = '$id' AND (transaction_logs.DateRecorded > '$last_date' OR (transaction_logs.DateRecorded = '$last_date' AND IFNULL(transaction_logs.TimeRecorded, '00:00:00') > '$last_time')) ORDER BY transaction_logs.DateRecorded DESC, transaction_logs.TimeRecorded DESC LIMIT 1");

$row = mysqli_fetch_array($query);
if ($row) {
    $activityName = $row['ActivityName'];
    $formattedTime = date("h:i A", strtotime($row['TimeRecorded']));
    $newTime = $row['DateRecorded'] . ' ' . $row['TimeRecorded'];
    echo "true|You have successfully timed-in for $activityName at " . $formattedTime . "|" . $newTime;
} else {
    echo "false";
}
?>