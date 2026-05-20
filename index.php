<?php
// Main landing page for the entire system
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Welcome | SENIOR-CARE</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="vendor/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="user/css/userStyle.css">
    <style>
        .hero-section {
            background-color: var(--forest-deep);
            color: white;
            padding: 80px 20px;
            text-align: center;
            border-radius: 0 0 30px 30px;
            box-shadow: 0 10px 30px rgba(31, 75, 44, 0.2);
            margin-bottom: 40px;
        }
        .hero-title {
            font-weight: 800;
            font-size: 2.2rem;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }
        .hero-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 800px;
            margin: 0 auto 30px auto;
        }
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            height: 100%;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            text-align: center;
            border-top: 4px solid var(--accent-mint);
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            font-size: 2.5rem;
            color: var(--olive-dark);
            margin-bottom: 15px;
        }
        .feature-title {
            font-weight: 700;
            color: var(--forest-deep);
            margin-bottom: 10px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="hero-section">
        <div class="container">
            <h1 class="hero-title">SENIOR-CARE</h1>
            <p class="hero-subtitle">Senior Citizen Engagement, Assistance, and Records Management System</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="user/login.php" class="btn btn-light btn-lg fw-bold px-4 text-success rounded-pill shadow-sm">
                    <i class="fa fa-user-circle me-2"></i> User Portal Login
                </a>
                <a href="admin/login.php" class="btn btn-outline-light btn-lg fw-bold px-4 rounded-pill">
                    <i class="fa fa-user-shield me-2"></i> Admin Access
                </a>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="text-center mb-5">
            <h3 class="fw-bold" style="color: var(--forest-deep);">System Features</h3>
            <div style="width: 60px; height: 4px; background: var(--accent-mint); margin: 10px auto;"></div>
        </div>

        <div class="row g-4">
            <!-- Feature 1 -->
            <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                    <i class="fa fa-id-card feature-icon"></i>
                    <h5 class="feature-title">Senior citizen profiling</h5>
                    <p class="text-muted small mb-0">Complete digital records with QR codes to make processing fast and easy.</p>
                </div>
            </div>
            <!-- Feature 2 -->
            <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                    <i class="fa fa-hand-holding-medical feature-icon"></i>
                    <h5 class="feature-title">Benefits and assistance tracking</h5>
                    <p class="text-muted small mb-0">A transparent digital trail of pensions and medical assistance, ensuring every senior gets their fair share of support.</p>
                </div>
            </div>
            <!-- Feature 3 -->
            <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                    <i class="fa fa-calendar-check feature-icon"></i>
                    <h5 class="feature-title">Event/activity management</h5>
                    <p class="text-muted small mb-0">Keeps track of participation in community meetings and events to ensure active members are recognized.</p>
                </div>
            </div>
            <!-- Feature 4 -->
            <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                    <i class="fa fa-qrcode feature-icon"></i>
                    <h5 class="feature-title">Attendance log</h5>
                    <p class="text-muted small mb-0">No more manual logbooks! Simply present your personal QR code for fast, contactless attendance and record keeping.</p>
                </div>
            </div>
            <!-- Feature 5 -->
            <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                    <i class="fa fa-chart-pie feature-icon"></i>
                    <h5 class="feature-title">Analytics dashboard</h5>
                    <p class="text-muted small mb-0">Provides administrators with clear statistics to plan better, more helpful community programs for the elderly.</p>
                </div>
            </div>
            <!-- Feature 6 -->
            <div class="col-md-4 col-sm-6">
                <div class="feature-card">
                    <i class="fa fa-file-invoice feature-icon"></i>
                    <h5 class="feature-title">Data Reporting</h5>
                    <p class="text-muted small mb-0">Keeps official records organized and easily printable, protecting seniors' data and ensuring full accountability.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center py-4 mt-auto border-top" style="background: #fff;">
        <p class="text-muted small mb-0">&copy; <?php echo date('Y'); ?> Barangay Kalawag 1 Management System</p>
    </div>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
