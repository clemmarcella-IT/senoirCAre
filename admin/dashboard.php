<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>SENIOR-CARE | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- 1. ADD: Mobile Overlay -->
    <div id="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- 2. ADD: Top Bar Navigation -->
  <header id="topbar">
    <button id="hamburger-btn" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </button>
    
    <!-- Reverted text to original, keeping your custom logo -->
    <div class="brand">
        <img src="care.png" alt="Senior Care Logo" class="brand-img">
        SENIOR-CARE
    </div>
</header>

    <!-- 3. UPDATE: Sidebar (Removed .brand div from inside here) -->
    <nav id="sidebar">
        <div class="nav flex-column">
            <a href="dashboard.html" class="nav-link"> <i class="fa-solid fa-chart-pie"></i> <span>Dashboard</span></a>
            <a href="profiling.html" class="nav-link"> <i class="fa-solid fa-users"></i> <span>Senior Profiling</span></a>
            <a href="health.html" class="nav-link"> <i class="fa-solid fa-heart-pulse"></i> <span>Health Records</span></a>
            <a href="assistance.html" class="nav-link"> <i class="fa-solid fa-hand-holding-heart"></i> <span>Assistance</span></a>
            <a href="events.html" class="nav-link"> <i class="fa-solid fa-calendar-check"></i> <span>Events & Log</span></a>
            <a href="reports.html" class="nav-link"> <i class="fa-solid fa-file-export"></i> <span>Reports</span></a>
        </div>
    </nav>
    <main id="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Dashboard Overview</h2>
        <button class="btn btn-outline-dark btn-sm" onclick="toggleKiosk()">Toggle Kiosk Mode</button>
    </div>

    <!-- Quick Stats Summary -->
    <div class="row mb-4">
        <div class="col-md-3"><div class="card stat-card p-3"><h6>Total Seniors</h6><h3>1,284</h3></div></div>
        <div class="col-md-3"><div class="card stat-card p-3" style="border-left-color: #3498db;"><h6>Active Events</h6><h3>12</h3></div></div>
        <div class="col-md-3"><div class="card stat-card p-3" style="border-left-color: #C3E956;"><h6>Assistance Issued</h6><h3>85%</h3></div></div>
        <div class="col-md-3"><div class="card stat-card p-3" style="border-left-color: #e74c3c;"><h6>Medical Alerts</h6><h3>04</h3></div></div>
    </div>

    <!-- Charts Row 1: Health & Assistance -->
    <div class="row">
        <!-- Line Graph -->
        <div class="col-md-7 mb-4">
            <div class="card p-4">
                <h5 class="mb-3">Health Trends: Monthly Medical Alerts</h5>
                <canvas id="healthLineChart"></canvas>
            </div>
        </div>
        <!-- Bar Chart -->
        <div class="col-md-5 mb-4">
            <div class="card p-4">
                <h5 class="mb-3">Assistance Distribution</h5>
                <canvas id="assistanceBarChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Charts Row 2: Demographics & Activities -->
    <div class="row">
        <!-- Pie Chart -->
        <div class="col-md-4 mb-4">
            <div class="card p-4">
                <h5 class="mb-3">Senior Demographics</h5>
                <canvas id="genderPieChart"></canvas>
            </div>
        </div>
        <!-- Horizontal Bar Chart -->
        <div class="col-md-8 mb-4">
            <div class="card p-4">
                <h5 class="mb-3">Program Participation Rate</h5>
                <canvas id="activitiesHBarChart"></canvas>
            </div>
        </div>
    </div>
</main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="scripts.js"></script>
    <script>
        new Chart(document.getElementById('barChart'), { type: 'bar', data: { labels: ['Jan', 'Feb', 'Mar', 'Apr'], datasets: [{ label: 'Assistance', data: [65, 59, 80, 81], backgroundColor: '#91EAAF' }] } });
        new Chart(document.getElementById('pieChart'), { type: 'pie', data: { labels: ['M', 'F'], datasets: [{ data: [45, 55], backgroundColor: ['#1F4B2C', '#C3E956'] }] } });
    </script>
</body>
</html>