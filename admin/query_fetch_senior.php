<?php
require_once('../includes/db_connection.php');
header('Content-Type: text/plain');

$oscaID = $_GET['oscaID'];
$dues_id = isset($_GET['dues_id']) ? $_GET['dues_id'] : '';

if ($oscaID == "") {
    echo "false";
    exit;
}

$result = mysqli_query($conn, "SELECT FirstName, LastName FROM seniors WHERE OscaIDNo='$oscaID' LIMIT 1");
$row = mysqli_fetch_array($result);
if ($row) {
    $name = $row['FirstName'] . ' ' . $row['LastName'];
    
    if ($dues_id != '') {
        $q_dues = mysqli_query($conn, "SELECT Amount_Required FROM monthly_dues_master WHERE DuesID='$dues_id'");
        $dues_info = mysqli_fetch_array($q_dues);
        $amount_req = $dues_info['Amount_Required'];
        
        $q_paid = mysqli_query($conn, "SELECT SUM(Amount_Paid) as total FROM dues_payments WHERE OscaIDNo='$oscaID' AND DuesID='$dues_id'");
        $paid_info = mysqli_fetch_array($q_paid);
        $total_paid = $paid_info['total'] ? $paid_info['total'] : 0;
        
        if ($total_paid >= $amount_req) {
            echo "fully_paid|" . $name;
            exit;
        }
    }
    
    echo "true|" . $name;
    exit;
}

echo "false";
?>
