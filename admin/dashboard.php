<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | SENIOR-CARE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>
<body class="d-flex bg-light">
    
    <!-- 1. LOAD THE SIDEBAR EXACTLY ONCE -->
    <?php include('includes/sidebar.php'); ?>

    <!-- 2. MAIN DASHBOARD CONTENT -->
    <div class="flex-grow-1 p-4">
        <h2 class="fw-bold" style="color: #1F4B2C;">Analytics Dashboard</h2>
        <hr>

        <?php
        // Fetch data for Citizen Status Pie Chart
        $statusQ = mysqli_query($conn, "SELECT CitezenStatus, COUNT(*) as count FROM seniors GROUP BY CitezenStatus");
        $active = 0; $inactive = 0;
        while($r = mysqli_fetch_assoc($statusQ)){
            if($r['CitezenStatus'] == 'active') $active = $r['count'];
            else $inactive = $r['count'];
        }

        // Fetch data for Age Group Bar Chart
        $ageQ = mysqli_query($conn, "
            SELECT 
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) BETWEEN 60 AND 65 THEN 1 ELSE 0 END) AS 'g1',
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) BETWEEN 66 AND 70 THEN 1 ELSE 0 END) AS 'g2',
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) BETWEEN 71 AND 75 THEN 1 ELSE 0 END) AS 'g3',
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, Birthday, CURDATE()) >= 76 THEN 1 ELSE 0 END) AS 'g4'
            FROM seniors
        ");
        $ages = mysqli_fetch_assoc($ageQ);

        // Fetch data for Monthly Attendance Line Chart
        $trendQ = mysqli_query($conn, "
            SELECT MONTHNAME(e.eventDate) as month, COUNT(a.AttendanceID) as count 
            FROM events e LEFT JOIN attendance a ON e.EventID = a.EventID 
            GROUP BY MONTH(e.eventDate) ORDER BY MONTH(e.eventDate)
        ");
        $months = []; $trendData =[];
        while($tr = mysqli_fetch_assoc($trendQ)){
            $months[] = $tr['month']; $trendData[] = $tr['count'];
        }
        ?>

        <div class="row g-4 mt-2">
            <!-- PIE CHART -->
            <div class="col-md-4">
                <div class="card shadow-sm h-100 border-0 rounded-4">
                    <div class="card-header bg-white fw-bold">Citizen Status Distribution</div>
                    <div class="card-body"><canvas id="pieChart"></canvas></div>
                </div>
            </div>
            
            <!-- BAR CHART -->
            <div class="col-md-8">
                <div class="card shadow-sm h-100 border-0 rounded-4">
                    <div class="card-header bg-white fw-bold">Age Group Demographics</div>
                    <div class="card-body"><canvas id="barChart"></canvas></div>
                </div>
            </div>
            
            <!-- LINE CHART -->
            <div class="col-md-12">
                <div class="card shadow-sm border-0 rounded-4 mb-4">
                    <div class="card-header bg-white fw-bold">Monthly Event Attendance Trend</div>
                    <div class="card-body" style="height: 300px;"><canvas id="lineChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. RENDER THE CHARTS -->
    <script>
        // Render Pie Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: { 
                labels:['Active', 'Inactive'], 
                datasets: [{ data:[<?php echo $active; ?>, <?php echo $inactive; ?>], backgroundColor: ['#198754', '#dc3545'] }] 
            }
        });

        // Render Bar Chart
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels:['60-65', '66-70', '71-75', '76+'],
                datasets: [{ label: 'Number of Seniors', data:[<?php echo $ages['g1'].','.$ages['g2'].','.$ages['g3'].','.$ages['g4']; ?>], backgroundColor: '#1F4B2C' }]
            }
        });

        // Render Line Chart
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets:[{ label: 'Total Attendance', data: <?php echo json_encode($trendData); ?>, borderColor: '#fd7e14', fill: true, backgroundColor: 'rgba(253, 126, 20, 0.2)' }]
            },
            options: { maintainAspectRatio: false }
        });
    </script>
</body>
</html>