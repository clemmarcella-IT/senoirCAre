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
                    <h6>Total Events</h6><h3><?php echo $row[0]; ?></h3><?php } ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border-lime">
                    <?php $query = mysqli_query($conn, "SELECT count(*) FROM assistance");
                    while($row = mysqli_fetch_array($query)){ ?>
                    <h6>Total Assistance</h6><h3><?php echo $row[0]; ?></h3><?php } ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card border-red">
                    <?php $query = mysqli_query($conn, "SELECT count(*) FROM healthrecords");
                    while($row = mysqli_fetch_array($query)){ ?>
                    <h6>Total Medical Event</h6><h3><?php echo $row[0]; ?></h3><?php } ?>
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

        <!-- Row 3: Age Groups -->
        <div class="row g-3 mb-5">
            <div class="col-lg-12">
                <div class="card chart-card" style="height: 260px;">
                    <div class="chart-title">Age Group Distribution (For Program Planning)</div>
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
        
        // Count Seniors by Age Group
        $seniors_query = mysqli_query($conn, "SELECT Birthday FROM seniors");
        $age_60_65 = 0;
        $age_66_70 = 0;
        $age_71_75 = 0;
        $age_76_plus = 0;
        
        while($senior_row = mysqli_fetch_array($seniors_query)){
            $birth_year = substr($senior_row['Birthday'], 0, 4);
            $current_year = date('Y');
            $age = $current_year - $birth_year;
            
            if($age >= 60 && $age <= 65) {
                $age_60_65++;
            }
            elseif($age >= 66 && $age <= 70) {
                $age_66_70++;
            }
            elseif($age >= 71 && $age <= 75) {
                $age_71_75++;
            }
            elseif($age >= 76) {
                $age_76_plus++;
            }
        }
        
        $bar_vals = [$age_60_65, $age_66_70, $age_71_75, $age_76_plus];
        
        // Count Attendance by Month
        $attendance_query = mysqli_query($conn, "SELECT eventDate FROM events JOIN attendance ON attendance.EventID = events.EventID");
        $area_vals = array_fill(0, 12, 0);
        
        while($attendance_row = mysqli_fetch_array($attendance_query)){
            $event_date = $attendance_row['eventDate'];
            $month = substr($event_date, 5, 2);
            $month_index = (int)$month - 1;
            $area_vals[$month_index]++;
        }
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