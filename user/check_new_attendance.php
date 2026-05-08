<?php
include("../includes/db_connection.php");
$id = $_POST['id'];
$lastTime = $_POST['lastTime'];
$query = mysqli_query($conn, "SELECT transaction_logs.*, activities.ActivityName FROM transaction_logs LEFT JOIN activities ON transaction_logs.ActivityID = activities.ActivityID WHERE transaction_logs.OscaIDNo = '$id' AND CONCAT(transaction_logs.DateRecorded, ' ', transaction_logs.TimeRecorded) > '$lastTime' ORDER BY transaction_logs.DateRecorded DESC, transaction_logs.TimeRecorded DESC LIMIT 1");
if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_array($query);
    $activityName = $row['ActivityName'];
    echo json_encode([
        'new' => true,
        'message' => "You have successfully timed-in for $activityName at " . date("h:i A", strtotime($row['TimeRecorded'])),
        'newTime' => $row['DateRecorded'] . ' ' . $row['TimeRecorded']
    ]);
} else {
    echo json_encode(['new' => false]);
}
?>