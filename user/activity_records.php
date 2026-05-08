<?php
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
                            $clem = mysqli_query($conn, "SELECT activities.ActivityName, transaction_logs.DateRecorded, transaction_logs.TimeRecorded, transaction_logs.Status 
                                                         FROM transaction_logs 
                                                         LEFT JOIN activities ON transaction_logs.ActivityID = activities.ActivityID 
                                                         WHERE transaction_logs.OscaIDNo = '$id' 
                                                         ORDER BY transaction_logs.DateRecorded DESC");

                            while($display = mysqli_fetch_array($clem)){
                        ?>
                        <tr>
                            <td><?php echo $display['DateRecorded']; ?></td>
                            <td><?php echo date("h:i A", strtotime($display['TimeRecorded'])); ?></td>
                            <td class="fw-bold"><?php echo $display['ActivityName']; ?></td>
                            <td><span class="badge bg-info text-dark"><?php echo $display['Status']; ?></span></td>
                        </tr>
                        <?php
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
            var data = JSON.parse(response);
            if (data.new) {
                showNotification(data.message);
                localStorage.setItem('lastAttendanceTime_<?php echo $id; ?>', data.newTime);
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