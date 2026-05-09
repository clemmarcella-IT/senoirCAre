<?php
require_once('../includes/db_connection.php');
header('Content-Type: text/plain');

$oscaID = $_GET['oscaID'];
if ($oscaID == "") {
    echo "false";
    exit;
}

$result = mysqli_query($conn, "SELECT FirstName, LastName FROM seniors WHERE OscaIDNo='$oscaID' LIMIT 1");
$row = mysqli_fetch_array($result);
if ($row) {
    $name = $row['FirstName'] . ' ' . $row['LastName'];
    echo "true|" . $name;
    exit;
}

echo "false";
?>
