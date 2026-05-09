<?php
session_start();
include("../includes/db_connection.php");
$id = $_GET['id'];

// Clear notification badges
mysqli_query($conn, "UPDATE transaction_logs SET IsRead = 1 WHERE OscaIDNo = '$id' AND ClaimType = 'Benefit Claim' AND IsRead = 0");

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
                
                <table class="table table-bordered table-hover align-middle" id="datatablesSimple" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Benefit Description</th>
                            <th>Amount Used</th> 
                            <th>Status</th>
                            <th>Specific Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $clem = mysqli_query($conn, "SELECT DateRecorded AS Date_Recorded, 
                                                                TimeRecorded AS Time_Recorded, 
                                                                Status, 
                                                                Reason, 
                                                                Amount_Released 
                                                         FROM transaction_logs 
                                                         WHERE OscaIDNo = '$id' 
                                                         AND ClaimType = 'Benefit Claim' 
                                                         ORDER BY DateRecorded DESC, TimeRecorded DESC");

                            if (!$clem) {
                                echo '<tr><td colspan="6" class="text-center text-danger">Error loading benefit claim records</td></tr>';
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
                            <td><?php echo date('M d, Y', strtotime($display['Date_Recorded'])); ?></td>
                            <td><?php echo $time_claimed; ?></td>
                            <td class="fw-bold">Benefit Claim</td>
                            
                            <td class="text-success fw-bold">
                                <?php echo ($display['Amount_Released'] > 0) ? "₱".number_format($display['Amount_Released'], 2) : "-"; ?>
                            </td>

                            <td>
                                <?php 
                                    if($display['Status'] == 'Claimed') {
                                        echo '<span class="badge bg-success">CLAIMED</span>';
                                    } else if($display['Status'] == 'Absent') {
                                        echo '<span class="badge bg-danger">ABSENT</span>';
                                    } else {
                                        echo '<span class="badge bg-primary">'.$display['Status'].'</span>';
                                    }
                                ?>
                            </td>
                            <td class="text-secondary small"><?php echo ($display['Reason'] != "" && $display['Reason'] != NULL) ? $display['Reason'] : "-"; ?></td>
                        </tr>
                        <?php 
                                }
                                if($count == 0) {
                                    echo '<tr><td colspan="6" class="text-center text-muted">No benefit claim records found</td></tr>';
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
<script src="js/datatables-simple-demo.js"></script>
</body>
</html>