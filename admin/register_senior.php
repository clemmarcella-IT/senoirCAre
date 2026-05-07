<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin | Register Senior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-success"><i class="fa fa-user-plus me-2"></i> Register New Citizen</h2>
                <a href="profiling.php" class="btn btn-outline-dark"><i class="fa fa-arrow-left"></i> Back to Profiling</a>
            </div>

            <div class="card shadow-sm border border-1 border-black">
                <div class="card-header bg-dark text-white fw-bold py-3">Senior Citizen Data Entry</div>
                <div class="card-body p-4">
                   <!-- Inside the form in register_senior.php -->
<form action="query_add_senior.php" method="POST">
    <div class="row g-3">
        <div class="col-md-4">
            <label class="small fw-bold">OscaIDNo.</label>
            <input type="text" name="oscaID" class="form-control" placeholder="Numbers only" required>
        </div>
        <div class="col-md-4">
            <label class="small fw-bold">First Name</label>
            <input type="text" name="fname" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="small fw-bold">Last Name</label>
            <input type="text" name="lname" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="small fw-bold">Middle Name</label>
            <input type="text" name="mi" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="small fw-bold">Sex</label>
            <select name="sex" class="form-select">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="small fw-bold">Birthday</label>
            <input type="date" name="bday" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="small fw-bold">Purok</label>
            <select name="purok" class="form-select">
                <?php for($i=1;$i<=6;$i++) echo "<option value='Zone $i'>Zone $i</option>"; ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="small fw-bold">Pensioner Status</label>
            <select name="pension_status" class="form-select">
                <option value="No">No</option>
                <option value="Yes">Yes</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="small fw-bold">Citizen Status</label>
            <select name="status" class="form-select">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-forest w-100 mt-4 py-3 fw-bold">SAVE CITIZEN RECORD</button>
</form>
                </div>
            </div>
        </div>
    </main>
    <script src="js/scripts.js"></script>
    <!-- INCLUDE THE AGE CALCULATION SCRIPT -->
    <script src="js/calculateAge.js"></script>
</body>
</html>