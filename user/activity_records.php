<?php
session_start();
include("../includes/db_connection.php");
$id = $_GET['id'];

// Clear notification badges for Activity
mysqli_query($conn, "UPDATE transaction_logs SET IsRead = 1 WHERE OscaIDNo = '$id' AND Status = 'Present' AND ActivityID IS NOT NULL AND IsRead = 0");

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
            <span>Event & Meeting Attendance Records</span>
            <a href="profile.php?id=<?php echo $id; ?>" class="btn btn-light btn-sm fw-bold">Back to Profile</a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                
                <table class="table table-bordered table-hover align-middle" id="datatablesSimple" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Event Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $clem = mysqli_query($conn, "SELECT activities.ActivityName, 
                                                         transaction_logs.DateRecorded AS Date_Recorded, 
                                                         transaction_logs.TimeRecorded AS Time_Recorded, 
                                                         transaction_logs.Status 
                                                         FROM transaction_logs 
                                                         LEFT JOIN activities ON transaction_logs.ActivityID = activities.ActivityID 
                                                         WHERE transaction_logs.OscaIDNo = '$id' 
                                                         AND transaction_logs.ActivityID IS NOT NULL
                                                         AND (transaction_logs.ClaimType IS NULL OR transaction_logs.ClaimType = '')
                                                         ORDER BY transaction_logs.DateRecorded DESC, transaction_logs.TimeRecorded DESC");

                            if (!$clem) {
                                echo '<tr><td colspan="4" class="text-center text-danger">Error loading activity records</td></tr>';
                            } else {
                                $count = 0;
                                while($display = mysqli_fetch_array($clem)){
                                    $count++;
                        ?>
                        <tr>
                            <td><?php echo date('M d, Y', strtotime($display['Date_Recorded'])); ?></td>
                            <td><?php echo date("h:i A", strtotime($display['Time_Recorded'])); ?></td>
                            <td class="fw-bold"><?php echo ($display['ActivityName']) ? $display['ActivityName'] : 'N/A'; ?></td>
                            <td>
                                <?php
                                    $status = $display['Status'];
                                    if($status == 'Present') {
                                        echo '<span class="badge bg-success">PRESENT</span>';
                                    } else if($status == 'Absent') {
                                        echo '<span class="badge bg-danger">ABSENT</span>';
                                    } else {
                                        echo '<span class="badge bg-info text-dark">'.$status.'</span>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php 
                                }
                                if($count == 0) {
                                    echo '<tr><td colspan="4" class="text-center text-muted">No activity records found</td></tr>';
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
function checkNewAttendance() {
    var lastTime = localStorage.getItem('lastAttendanceTime_<?php echo $id; ?>') || '0000-00-00 00:00:00';
    $.ajax({
        url: 'check_new_attendance.php',
        type: 'POST',
        data: {id: '<?php echo $id; ?>', lastTime: lastTime},
        success: function(response) {
            var dataParts = response.split('|');
            if (dataParts[0] === 'true') {
                var message = dataParts[1];
                var newTime = dataParts[2];
                showNotification(message);
                localStorage.setItem('lastAttendanceTime_<?php echo $id; ?>', newTime);
                location.reload(); // Reload to update table
            }
        }
    });
}
setInterval(checkNewAttendance, 10000); // Check every 10 seconds
function showNotification(message) {
    alert(message); // Simple alert, can be replaced with toast
}
</script>
</body>
</html>