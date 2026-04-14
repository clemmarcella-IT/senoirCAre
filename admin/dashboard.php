<?php 
require_once('includes/session.php'); 

// --- FETCH SUMMARY STATS ---
$totalSeniors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM seniors"))['c'];
$activeEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM events"))['c'];
$healthVisits = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM healthrecords"))['c'];

// --- PIE CHART DATA ---
$statusQ = mysqli_query($conn, "SELECT CitezenStatus, COUNT(*) as count FROM seniors GROUP BY CitezenStatus");
$statusData = ['active' => 0, 'inactive' => 0];
while($row = mysqli_fetch_assoc($statusQ)){
    $statusData[$row['CitezenStatus']] = (int)$row['count'];
}

// --- BAR CHART DATA ---
$ageQ = mysqli_query($conn, "SELECT 
    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) BETWEEN 60 AND 65 THEN 1 ELSE 0 END) AS 'g1',
    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) BETWEEN 66 AND 70 THEN 1 ELSE 0 END) AS 'g2',
    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) BETWEEN 71 AND 75 THEN 1 ELSE 0 END) AS 'g3',
    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) >= 76 THEN 1 ELSE 0 END) AS 'g4' FROM seniors");
$ageRes = mysqli_fetch_assoc($ageQ);
$ageGroups = [(int)$ageRes['g1'], (int)$ageRes['g2'], (int)$ageRes['g3'], (int)$ageRes['g4']];

// --- AREA CHART DATA ---
$attendanceQ = mysqli_query($conn, "SELECT MONTH(attendanceTimeIn) as m, COUNT(*) as c FROM attendance WHERE YEAR(attendanceTimeIn) = YEAR(CURDATE()) GROUP BY MONTH(attendanceTimeIn)");
$monthlyAttendance = array_fill(0, 12, 0); 
while($row = mysqli_fetch_assoc($attendanceQ)){
    $monthlyAttendance[$row['m']-1] = (int)$row['c'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Dashboard Overview</h2>
            <!-- KIOSK BUTTON REMOVED -->
        </div>

        <!-- Quick Stats Summary -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card p-3 shadow-sm">
                    <h6>Total Seniors</h6>
                    <h3 class="fw-bold"><?php echo number_format($totalSeniors); ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card p-3 shadow-sm" style="border-left-color: #3498db;">
                    <h6>Active Events</h6>
                    <h3 class="fw-bold"><?php echo $activeEvents; ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card p-3 shadow-sm" style="border-left-color: #C3E956;">
                    <h6>Health Records</h6>
                    <h3 class="fw-bold"><?php echo $healthVisits; ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card p-3 shadow-sm" style="border-left-color: #e74c3c;">
                    <h6>Medical Alerts</h6>
                    <h3 class="fw-bold">04</h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-7 col-lg-7 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header py-3"><h6 class="m-0 font-weight-bold">Monthly Attendance Trend</h6></div>
                    <div class="card-body"><div class="chart-area"><canvas id="seniorAreaChart" width="100%" height="40"></canvas></div></div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header py-3"><h6 class="m-0 font-weight-bold">Age Group Distribution</h6></div>
                    <div class="card-body"><div class="chart-bar"><canvas id="seniorBarChart" width="100%" height="56"></canvas></div></div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header py-3"><h6 class="m-0 font-weight-bold">Citizen Status Ratio</h6></div>
                    <div class="card-body">
                        <div class="chart-pie pt-4 pb-2"><canvas id="seniorPieChart"></canvas></div>
                        <div class="mt-4 text-center small">
                            <span class="mr-2"><i class="fas fa-circle text-primary"></i> Active</span>
                            <span class="mr-2"><i class="fas fa-circle text-danger"></i> Inactive</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        var php_statusData = [<?php echo $statusData['active']; ?>, <?php echo $statusData['inactive']; ?>];
        var php_ageData = <?php echo json_encode($ageGroups); ?>;
        var php_attendanceData = <?php echo json_encode($monthlyAttendance); ?>;
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/senior-area-chart.js"></script>
    <script src="js/senior-bar-chart.js"></script>
    <script src="js/senior-pie-chart.js"></script>
</body>
</html>