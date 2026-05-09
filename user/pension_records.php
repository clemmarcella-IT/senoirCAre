<?php
session_start();
include("../includes/db_connection.php");
$id = $_GET['id'];
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
                    <tbody>
                        <?php
                            $clem = mysqli_query($conn, "SELECT transaction_logs.DateRecorded AS Date_Recorded, transaction_logs.TimeRecorded AS Time_Recorded, transaction_logs.Status, transaction_logs.ControlNo, transaction_logs.Reason, pension_master.CashAmount 
                                                         FROM transaction_logs 
                                                         LEFT JOIN pension_master ON transaction_logs.PensionMasterID = pension_master.PensionMasterID 
                                                         WHERE transaction_logs.OscaIDNo = '$id' 
                                                         AND transaction_logs.ClaimType = 'Pension Claim' 
                                                         ORDER BY transaction_logs.DateRecorded DESC, transaction_logs.TimeRecorded DESC");

                            if (!$clem) {
                                echo '<tr><td colspan="6" class="text-center text-danger">Error loading pension records</td></tr>';
                            } else {
                                $count = 0;
                                while($display = mysqli_fetch_array($clem)){
                                    $count++;
                                    if($display['Time_Recorded'] != NULL && $display['Time_Recorded'] != '') {
                                        $time_claimed = date("h:i A", strtotime($display['Time_Recorded']));
                                    } else {
                                        $time_claimed = '--:--';
                                    }
                        ?>
                        <tr>
                            <td class="fw-bold text-secondary"><?php echo date('M d, Y', strtotime($display['Date_Recorded'])); ?></td>
                            <td><?php echo $time_claimed; ?></td>
                            <td class="text-success fw-bold">₱<?php echo ($display['CashAmount']) ? number_format($display['CashAmount'], 2) : '0.00'; ?></td>
                            <td class="text-primary fw-bold"><?php echo ($display['ControlNo'] != NULL) ? $display['ControlNo'] : '-'; ?></td>
                            <td>
                                <?php 
                                    if($display['Status'] == 'Claimed') {
                                        echo '<span class="badge bg-success">Claimed</span>';
                                    } else if($display['Status'] == 'Absent') {
                                        echo '<span class="badge bg-danger">Absent</span>';
                                    } else {
                                        echo '<span class="badge bg-warning text-dark">Unclaimed</span>';
                                    }
                                ?>
                            </td>
                            <td class="text-danger fw-bold"><?php echo ($display['Reason'] != NULL) ? $display['Reason'] : '-'; ?></td>
                        </tr>
                        <?php 
                                }
                                if($count == 0) {
                                    echo '<tr><td colspan="6" class="text-center text-muted">No pension claim records found</td></tr>';
                                }
                            }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<!-- USING YOUR NEW JS FILE -->
<script src="js/datatables-simple-demo.js"></script>
</body>
</html>