<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Assistance | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <h2>Assistance & Benefits Tracking</h2>
        <div class="row mb-4">
            <div class="col-md-4"><div class="card p-3"><h6>Rice Subsidy</h6><span class="badge bg-success">Distributed</span></div></div>
            <div class="col-md-4"><div class="card p-3"><h6>Medicine Kit</h6><span class="badge bg-warning">Pending</span></div></div>
        </div>
        <div class="card">
            <div class="card-header bg-white">Transaction History</div>
            <table id="datatablesSimple" class="table mb-0">
                <thead><tr><th>Date</th><th>Name</th><th>Benefit</th><th>Status</th></tr></thead>
                <tbody><tr><td>2023-10-20</td><td>Juan Dela Cruz</td><td>Rice</td><td><span class="badge bg-success">Done</span></td></tr></tbody>
            </table>
        </div>
    </main>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>