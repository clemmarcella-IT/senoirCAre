<?php
include("includes/session.php");
mysqli_query($conn, "UPDATE transaction_logs SET IsRead=1 WHERE OscaIDNo='$id' AND ClaimType='Pension Claim'");
// Get Admin Contact
$q_admin = mysqli_query($conn, "SELECT ContactNumber FROM admin_users WHERE AdminID=1");
$row_admin = mysqli_fetch_array($q_admin);
$admin_contact = $row_admin['ContactNumber'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pension Records</title>
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
        <div class="card-header bg-success text-white fw-bold d-flex justify-content-between align-items-center py-3">
            <span>Pension Claim Records</span>
            <a href="profile.php?id=<?php echo $id; ?>" class="btn btn-light btn-sm fw-bold">Back to Profile</a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                
                <table class="table table-bordered table-hover align-middle" id="datatablesSimple" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Time Claimed</th>
                            <th>Cash Amount</th>
                            <th>Control No.</th>
                            <th>Status</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <?php
                        $clem = mysqli_query($conn, "SELECT DateRecorded, TimeRecorded, Status, ControlNo, Reason, CashAmount FROM transaction_logs LEFT JOIN pension_master ON transaction_logs.PensionMasterID = pension_master.PensionMasterID WHERE transaction_logs.OscaIDNo = '$id' AND transaction_logs.ClaimType = 'Pension Claim' ORDER BY DateRecorded DESC, TimeRecorded DESC");
                        while($display = mysqli_fetch_array($clem)){
                    ?>
                    <tr>
                        <td><?php echo date('M d, Y', strtotime($display['DateRecorded'])); ?></td>
                        <td><?php echo date("h:i A", strtotime($display['TimeRecorded'])); ?></td>
                        <td><?php echo ($display['CashAmount']) ? number_format($display['CashAmount'], 2) : '0.00'; ?></td>
                        <td><?php echo ($display['ControlNo'] != NULL) ? $display['ControlNo'] : '-'; ?></td>
                        <td>
                            <?php
                            if($display['Status'] == 'Claimed'){
                                echo '<span class="badge bg-success">Claimed</span>';
                            } else if($display['Status'] == 'Absent'){
                                echo '<span class="badge bg-danger">Absent</span>';
                            } else {
                                echo '<span class="badge bg-warning text-dark">Unclaimed</span>';
                            }
                            ?>
                        </td>
                        <td><?php echo ($display['Reason'] != NULL) ? $display['Reason'] : '-'; ?></td>
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