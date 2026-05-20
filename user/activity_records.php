<?php
include("includes/session.php");
mysqli_query($conn, "UPDATE transaction_logs SET IsRead=1 WHERE OscaIDNo='$id' AND (ClaimType IS NULL OR ClaimType='') AND ActivityID IS NOT NULL");
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
    <title>Event Activities</title>
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
        <div class="card-header bg-info text-white fw-bold d-flex justify-content-between align-items-center py-3">
            <span>Event & Activities Attendance Records</span>
            <a href="profile.php?id=<?php echo $id; ?>" class="btn btn-light btn-sm fw-bold">Back to Profile</a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                
                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Event Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <?php
                    $clem = mysqli_query($conn, "SELECT ActivityName, DateRecorded, TimeRecorded, Status FROM transaction_logs LEFT JOIN activities ON transaction_logs.ActivityID = activities.ActivityID WHERE transaction_logs.OscaIDNo = '$id' AND transaction_logs.ActivityID IS NOT NULL AND (transaction_logs.ClaimType IS NULL OR transaction_logs.ClaimType = '') ORDER BY DateRecorded DESC, TimeRecorded DESC");
                    while($display = mysqli_fetch_array($clem)){
                    ?>
                    <tr>
                        <td><?php echo date('M d, Y', strtotime($display['DateRecorded'])); ?></td>
                        <td><?php echo $display['TimeRecorded'] ? date("h:i A", strtotime($display['TimeRecorded'])) : '--:--'; ?></td>
                        <td><?php echo $display['ActivityName']; ?></td>
                        <td>
                            <?php
                            if($display['Status'] == 'Present'){
                                echo '<span class="badge bg-success">PRESENT</span>';
                            } else if($display['Status'] == 'Absent'){
                                echo '<span class="badge bg-danger">ABSENT</span>';
                            } else {
                                echo '<span class="badge bg-info text-dark">'.$display['Status'].'</span>';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
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