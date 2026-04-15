<?php include('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Dashboard | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="sb-nav-fixed">
    <div id="sidebar-overlay"></div>
    <header id="topbar">
        <button id="hamburger-btn" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
        <div class="brand"><img src="../care.png" class="brand-img"> SENIOR-CARE</div>
    </header>

    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <h4 class="fw-bold mb-3">Dashboard Overview</h4>

        <!-- Row 1: Stat Cards -->
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="card stat-card border-green">
                    <?php include('../includes/db_connection.php');
                    $query = mysqli_query($conn, "SELECT count(*) FROM seniors");
                    while($row = mysqli_fetch_array($query)){ ?>
                    <h6>Total Seniors</h6><h3><?php echo number_format($row[0]); ?></h3><?php } ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border-blue">
                    <?php $query = mysqli_query($conn, "SELECT count(*) FROM events");
                    while($row = mysqli_fetch_array($query)){ ?>
                    <h6>Active Events</h6><h3><?php echo $row[0]; ?></h3><?php } ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border-lime">
                    <h6>Assistance Issued</h6><h3>85%</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border-red">
                    <?php $query = mysqli_query($conn, "SELECT count(*) FROM healthrecords");
                    while($row = mysqli_fetch_array($query)){ ?>
                    <h6>Medical Alerts</h6><h3>0<?php echo $row[0]; ?></h3><?php } ?>
                </div>
            </div>
        </div>

        <!-- Row 2: Attendance & Status -->
        <div class="row g-3 mb-3">
            <div class="col-lg-8">
                <div class="card chart-card">
                    <div class="chart-title">Monthly Attendance Trend</div>
                    <div style="height: 190px;"><canvas id="seniorAreaChart"></canvas></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card chart-card">
                    <div class="chart-title">Citizen Status Ratio</div>
                    <div style="height: 190px;"><canvas id="seniorPieChart"></canvas></div>
                </div>
            </div>
        </div>

        <!-- Row 3: Age Groups -->
        <div class="row g-3">
            <div class="col-lg-12">
                <div class="card chart-card" style="height: 220px;">
                    <div class="chart-title">Age Group Distribution (For Program Planning)</div>
                    <div style="height: 150px;"><canvas id="seniorBarChart"></canvas></div>
                </div>
            </div>
        </div>
    </main>

    <!-- Prepare Chart Data for JS -->
    <?php
        // Pie Data
        $stQ = mysqli_query($conn, "SELECT CitezenStatus, COUNT(*) FROM seniors GROUP BY CitezenStatus");
        $p_act = 0; $p_inact = 0;
        while($r = mysqli_fetch_array($stQ)){
            if($r[0] == 'active') $p_act = $r[1]; else $p_inact = $r[1];
        }
        // Bar Data (Ages)
        $ageQ = mysqli_query($conn, "SELECT 
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) BETWEEN 60 AND 65 THEN 1 ELSE 0 END),
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) BETWEEN 66 AND 70 THEN 1 ELSE 0 END),
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) BETWEEN 71 AND 75 THEN 1 ELSE 0 END),
            SUM(CASE WHEN TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) >= 76 THEN 1 ELSE 0 END) FROM seniors");
        $aRow = mysqli_fetch_array($ageQ);
        $bar_vals = [(int)$aRow[0], (int)$aRow[1], (int)$aRow[2], (int)$aRow[3]];
        // Area Data
        $attQ = mysqli_query($conn, "SELECT MONTH(events.eventDate), COUNT(*) FROM attendance JOIN events ON events.EventID = attendance.EventID GROUP BY MONTH(events.eventDate)");
        $area_vals = array_fill(0, 12, 0);
        while($r = mysqli_fetch_array($attQ)){ if($r[0] > 0) $area_vals[$r[0]-1] = (int)$r[1]; }
    ?>

    <script>
        var php_statusData = [<?php echo $p_act; ?>, <?php echo $p_inact; ?>];
        var php_ageData = <?php echo json_encode($bar_vals); ?>;
        var php_attendanceData = <?php echo json_encode($area_vals); ?>;
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/senior-area-chart.js"></script>
    <script src="js/senior-bar-chart.js"></script>
    <script src="js/senior-pie-chart.js"></script>
</body>
</html>