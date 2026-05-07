<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Register Senior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" />
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            <h2 class="mt-4 fw-bold text-success">New Citizen Registration</h2>
            
            <div class="card shadow-sm border-0 mt-3">
                <div class="card-header bg-dark text-white fw-bold">Senior Information (No Photo Required)</div>
                <div class="card-body p-4">
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
                                <label class="small fw-bold">Birthday</label>
                                <!-- onchange triggers the real-time viewing -->
                                <input type="date" name="bday" id="bdayInput" class="form-control" onchange="calculateAge()" required>
                                <div id="ageDisplay" class="mt-1 text-primary fw-bold small">Derived Age: --</div>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="small fw-bold">Sex</label>
                                <select name="sex" class="form-select">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
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
                                <label class="small fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-forest w-100 mt-4 py-3 fw-bold">REGISTER CITIZEN & GENERATE QR</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="js/calculateAge.js"></script>
</body>
</html>