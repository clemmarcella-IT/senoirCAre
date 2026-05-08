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
                    <?php $query = mysqli_query($conn, "SELECT count(*) FROM seniors WHERE PensionerStatus='Pensioner'");
                    while($row = mysqli_fetch_array($query)){ ?>
                    <h6>Total Pensioners</h6><h3><?php echo $row[0]; ?></h3><?php } ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border-lime">
                    <?php 
                    $dues_query = mysqli_query($conn, "SELECT SUM(Amount_Paid) AS total_dues FROM dues_payments WHERE Payment_Status='Paid'");
                    $dues_row = mysqli_fetch_array($dues_query);
                    $total_dues = $dues_row['total_dues'] ? $dues_row['total_dues'] : 0;
                    ?>
                    <h6>Total Monthly Dues</h6><h3>₱<?php echo number_format($total_dues, 2); ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border-orange">
                    <?php 
                    $benefits_query = mysqli_query($conn, "SELECT SUM(Amount_Released) AS total_benefits FROM transaction_logs WHERE ClaimType='Benefit Claim' AND Status='Claimed'");
                    $benefits_row = mysqli_fetch_array($benefits_query);
                    $total_benefits = $benefits_row['total_benefits'] ? $benefits_row['total_benefits'] : 0;
                    ?>
                    <h6>Total Claim Benefits</h6><h3>₱<?php echo number_format($total_benefits, 2); ?></h3>
                </div>
            </div>
        </div>

        <!-- Row 2: Attendance & Status -->
        <div class="row g-3 mb-3">
            <div class="col-lg-8">
                <div class="card chart-card">
                    <div class="chart-title">Monthly Attendance Trend</div>
                    <div style="height: 150px;"><canvas id="seniorAreaChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card chart-card">
                    <div class="chart-title">Citizen Status Ratio</div>
                    <div style="height: 150px;"><canvas id="seniorPieChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>

        <!-- Row 3: Monthly Dues Collection -->
        <div class="row g-3 mb-5">
            <div class="col-lg-12">
                <div class="card chart-card" style="height: 260px;">
                    <div class="chart-title">Monthly Dues Collection Trend</div>
                    <div style="height: 160px;"><canvas id="seniorBarChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>
        <br>
    </main>

    <!-- Prepare Chart Data for JS -->
    <?php
        // Count Active Citizens
        $active_query = mysqli_query($conn, "SELECT COUNT(*) FROM seniors WHERE CitizenStatus = 'active'");
        $active_row = mysqli_fetch_array($active_query);
        $p_act = $active_row[0];
        
        // Count Inactive Citizens
        $inactive_query = mysqli_query($conn, "SELECT COUNT(*) FROM seniors WHERE CitizenStatus = 'inactive'");
        $inactive_row = mysqli_fetch_array($inactive_query);
        $p_inact = $inactive_row[0];
        
        // Monthly Dues Collection by Month
        $dues_collection_query = mysqli_query($conn, "SELECT Date_Paid, Amount_Paid FROM dues_payments WHERE Payment_Status='Paid'");
        $bar_vals = array_fill(0, 12, 0);
        
        while($dues_row = mysqli_fetch_array($dues_collection_query)){
            $date_paid = $dues_row['Date_Paid'];
            $month = substr($date_paid, 5, 2);
            $month_index = (int)$month - 1;
            $bar_vals[$month_index] += $dues_row['Amount_Paid'];
        }
        
        // Count Attendance by Month
        $attendance_query = mysqli_query($conn, "SELECT DateRecorded FROM transaction_logs WHERE ActivityID IS NOT NULL");
        $area_vals = array_fill(0, 12, 0);
        
        while($attendance_row = mysqli_fetch_array($attendance_query)){
            $event_date = $attendance_row['DateRecorded'];
            $month = substr($event_date, 5, 2);
            $month_index = (int)$month - 1;
            $area_vals[$month_index]++;
        }
    ?>

    <script>
        var php_statusData = [<?php echo $p_act; ?>, <?php echo $p_inact; ?>];
        var php_duesData = <?php echo json_encode($bar_vals); ?>;
        var php_attendanceData = <?php echo json_encode($area_vals); ?>;
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/senior-area-chart.js"></script>
    <script src="js/senior-bar-chart.js"></script>
    <script src="js/senior-pie-chart.js"></script>
</body>
</html>