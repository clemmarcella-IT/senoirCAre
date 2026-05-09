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
            <!-- Report 1: List of Pensioners -->
            <div class="col-md-4 mb-3">
                <div class="card p-4 text-center shadow-sm h-100 d-flex flex-column">
                    <i class="fa fa-money-check-alt text-info fs-1 mb-3"></i>
                    <h5>List of Pensioners</h5>
                    <p class="small text-muted flex-grow-1">Displays all seniors eligible for the pension for budget planning.</p>
                    <a href="report_pension_rate.php" class="btn btn-info text-white mt-auto">Open Report</a>
                </div>
            </div>

            <!-- Report 2: Member Engagement -->
            <div class="col-md-4 mb-3">
                <div class="card p-4 text-center shadow-sm h-100 d-flex flex-column">
                    <i class="fa fa-star text-warning fs-1 mb-3"></i>
                    <h5>Member Engagement & Activity Impact</h5>
                    <p class="small text-muted flex-grow-1">Shows the turnout for every activity to measure program effectiveness.</p>
                    <a href="report_activity_popularity.php" class="btn btn-warning mt-auto">Open Report</a>
                </div>
            </div>

            <!-- Report 3: Senior Contribution & Dues -->
            <div class="col-md-4 mb-3">
                <div class="card p-4 text-center shadow-sm h-100 d-flex flex-column">
                    <i class="fa fa-wallet text-success fs-1 mb-3"></i>
                    <h5>Senior Contribution & Dues Collection</h5>
                    <p class="small text-muted flex-grow-1">Financial audit report for collections and overall active status.</p>
                    <a href="report_dues_collection.php" class="btn btn-success mt-auto">Open Report</a>
                </div>
            </div>
        </div>
    </main>

    <script src="js/scripts.js"></script>
</body>
</html>