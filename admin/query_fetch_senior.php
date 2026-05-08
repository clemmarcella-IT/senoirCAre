<?php
require_once('includes/db_connection.php');
header('Content-Type: application/json');

$oscaID = isset($_GET['oscaID']) ? mysqli_real_escape_string($conn, $_GET['oscaID']) : '';
if (!$oscaID) {
    echo json_encode(['success' => false]);
    exit;
}

$result = mysqli_query($conn, "SELECT FirstName, LastName FROM seniors WHERE OscaIDNo='$oscaID' LIMIT 1");
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = trim($row['FirstName'] . ' ' . $row['LastName']);
    echo json_encode(['success' => true, 'name' => $name]);
    exit;
}

echo json_encode(['success' => false]);
