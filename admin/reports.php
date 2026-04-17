<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Reports | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <h2 class="mb-4">Reports Generation</h2>
        
        <div class="row">
            <!-- Report 1: Active Seniors -->
            <div class="col-md-4">
                <div class="card p-4 text-center shadow-sm">
                    <i class="fa fa-user-check text-success fs-1 mb-3"></i>
                    <h5>Active Seniors</h5>
                    <p class="small text-muted">List of all active citizens.</p>
                    <a href="report_active_seniors.php" class="btn btn-success">Open Report</a>
                </div>
            </div>

            <!-- Report 2: Most Attended -->
            <div class="col-md-4">
                <div class="card p-4 text-center shadow-sm">
                    <i class="fa fa-star text-warning fs-1 mb-3"></i>
                    <h5>Most Attended</h5>
                    <p class="small text-muted">Ranking of most popular events.</p>
                    <a href="report_event_popularity.php" class="btn btn-warning">Open Report</a>
                </div>
            </div>

            <!-- Report 3: Pension Summary -->
            <div class="col-md-4">
                <div class="card p-4 text-center shadow-sm">
                    <i class="fa fa-money-check-alt text-info fs-1 mb-3"></i>
                    <h5>Pension Summary</h5>
                    <p class="small text-muted">Claim rates per person.</p>
                    <a href="report_pension_rate.php" class="btn btn-info text-white">Open Report</a>
                </div>
            </div>
        </div>
    </main>

    <script src="js/scripts.js"></script>
</body>
</html>