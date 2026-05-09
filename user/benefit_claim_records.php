<?php
session_start();
include("../includes/db_connection.php");
$id = $_GET['id'];
mysqli_query($conn, "UPDATE transaction_logs SET IsRead=1 WHERE OscaIDNo='$id' AND ClaimType='Benefit Claim'");

$q_admin = mysqli_query($conn, "SELECT ContactNumber FROM admin_users WHERE AdminID=1");
$row_admin = mysqli_fetch_array($q_admin);
$admin_contact = $row_admin['ContactNumber'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Benefit Claims</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/userStyle.css">
</head>
<body>

<div class="navbar-custom no-print d-flex flex-column text-center" style="height: auto; padding: 15px 0;">
    <div>SENIOR-CARE PORTAL</div>
    <div style="font-size: 0.85rem; font-weight: normal; margin-top: 5px; opacity: 0.9;">Admin Contact: <?php echo $admin_contact; ?></div>
</div>

<div class="container py-4 main-container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center py-3">
            <span>Dues Benefit Claim Records</span>
            <a href="profile.php?id=<?php echo $id; ?>" class="btn btn-light btn-sm fw-bold">Back to Profile</a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                
                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Benefit Description</th>
                            <th>Amount Used</th>
                            <th>Status</th>
                            <th>Specific Details</th>
                        </tr>
                    </thead>
                    <?php
                    $clem = mysqli_query($conn, "SELECT DateRecorded, TimeRecorded, Status, Reason, Amount_Released FROM transaction_logs WHERE OscaIDNo = '$id' AND ClaimType = 'Benefit Claim' ORDER BY DateRecorded DESC, TimeRecorded DESC");
                    while($display = mysqli_fetch_array($clem)){
                    ?>
                    <tr>
                        <td><?php echo date('M d, Y', strtotime($display['DateRecorded'])); ?></td>
                        <td><?php echo date("h:i A", strtotime($display['TimeRecorded'])); ?></td>
                        <td>Benefit Claim</td>
                        <td><?php echo ($display['Amount_Released'] > 0) ? "₱".number_format($display['Amount_Released'], 2) : "-"; ?></td>
                        <td>
                            <?php
                            if($display['Status'] == 'Claimed'){
                                echo '<span class="badge bg-success">CLAIMED</span>';
                            } else if($display['Status'] == 'Absent'){
                                echo '<span class="badge bg-danger">ABSENT</span>';
                            } else {
                                echo '<span class="badge bg-primary">'.$display['Status'].'</span>';
                            }
                            ?>
                        </td>
                        <td><?php echo ($display['Reason'] != "" && $display['Reason'] != NULL) ? $display['Reason'] : "-"; ?></td>
                    </tr>
                    <?php } ?>
                </table>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
</body>
</html>