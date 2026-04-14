<div id="sidebar-overlay" onclick="toggleSidebar()"></div>
<header id="topbar">
    <button id="hamburger-btn" onclick="toggleSidebar()"><i class="fa-solid fa-bars"></i></button>
    <div class="brand">
        <img src="../care.png" alt="Logo" class="brand-img">
        SENIOR-CARE ADMIN
    </div>
</header>

<nav id="sidebar">
    <div class="nav flex-column">
        <a href="dashboard.php" class="nav-link"><i class="fa-solid fa-chart-pie"></i> <span>Dashboard</span></a>
        <a href="profiling.php" class="nav-link"><i class="fa-solid fa-user-pen"></i> <span>Senior Profile (CRUD)</span></a>
        <a href="health.php" class="nav-link"><i class="fa-solid fa-heart-pulse"></i> <span>Health Records</span></a>
        <a href="events.php" class="nav-link"><i class="fa-solid fa-calendar-check"></i> <span>Events Records</span></a>
        <a href="assistance.php" class="nav-link"><i class="fa-solid fa-hand-holding-heart"></i> <span>Assistance Records</span></a>
        <a href="pension.php" class="nav-link"><i class="fa-solid fa-wallet"></i> <span>Pension Records</span></a>
        <a href="reports.php" class="nav-link"><i class="fa-solid fa-file-invoice"></i> <span>Reports Generation</span></a>
        <a href="settings.php" class="nav-link mt-4 border-top pt-3"><i class="fa-solid fa-user-gear"></i> <span>Settings</span></a>
        <a href="logout.php" class="nav-link text-danger"><i class="fa-solid fa-power-off"></i> <span>Logout</span></a>
    </div>
</nav>