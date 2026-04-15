<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Reports | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <h2 class="mb-4">Reports Generation</h2>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <i class="fa fa-file-invoice text-success fs-1 mb-3"></i>
                    <h5>Summary Report</h5>
                    <p class="small text-muted">Overall citizen statistics and demographic breakdown.</p>
                    <button class="btn btn-success">Download PDF</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <i class="fa fa-exchange-alt text-primary fs-1 mb-3"></i>
                    <h5>Transaction Report</h5>
                    <p class="small text-muted">History of all assistance and pension distributions.</p>
                    <button class="btn btn-primary">Download PDF</button>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <i class="fa fa-gauge-high text-warning fs-1 mb-3"></i>
                    <h5>Performance Report</h5>
                    <p class="small text-muted">Participation rates and medical activity monitoring.</p>
                    <button class="btn btn-warning">Download PDF</button>
                </div>
            </div>
        </div>
    </main>
    <script src="js/scripts.js"></script>
</body>
</html>