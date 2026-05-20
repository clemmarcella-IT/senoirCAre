<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Admin | Register Senior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css" rel="stylesheet" />
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
                <h2 class="fw-bold text-success"><i class="fa fa-user-plus me-2"></i> Register New Citizen</h2>
                <a href="profiling.php" class="btn btn-outline-dark"><i class="fa fa-arrow-left me-1"></i> Back to Profiling</a>
            </div>

            <div class="card shadow-sm border border-1 border-black">
                <div class="card-header bg-dark text-white fw-bold py-3">Senior Citizen Data Entry</div>
                <div class="card-body p-4">
                    <form id="seniorForm" action="query_add_senior.php" method="POST">
                        <div class="row g-3">

                            
                            <div class="col-md-4">
                                <label class="fw-bold small text-muted">OscaIDNo. (Primary Key)</label>
                                <input type="text" class="form-control card shadow border border-1 border-black" name="oscaID" placeholder="Numbers only" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required/>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold small text-muted">Sex</label>
                                <select class="form-select card shadow border border-1 border-black" name="sex" required>
                                    <option value="" disabled selected>Select Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold small text-muted">Citizen Status</label>
                                <select class="form-select card shadow border border-1 border-black" name="status">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>

                           
                            <div class="col-md-4">
                                <label class="small fw-bold">First Name</label>
                                <input type="text" class="form-control card shadow border border-1 border-black" name="fname" required/>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold">Middle Name</label>
                                <input type="text" class="form-control card shadow border border-1 border-black" name="mi"/>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold">Last Name</label>
                                <input type="text" class="form-control card shadow border border-1 border-black" name="lname" required/>
                            </div>

                            
                            <div class="col-md-4">
                                <label class="small fw-bold">Purok (Zone)</label>
                                <select class="form-select card shadow border border-1 border-black" name="purok" required>
                                    <option value="" disabled selected>Select Zone</option>
                                    <?php for($i=1; $i<=6; $i++) echo "<option value='Zone $i'>Zone $i</option>"; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold">Barangay</label>
                                <input type="text" class="form-control card shadow border border-1 border-black" name="brgy" value="Kalawag 1" readonly/>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold">Birthday</label>
                                <input type="date" class="form-control card shadow border border-1 border-black" name="bday" id="bdayInput" onchange="calculateAge()" required/>
                                <div id="ageDisplay" class="mt-1 text-primary fw-bold small">Derived Age: --</div>
                            </div>

                          
                            <div class="col-md-4">
                                <label class="fw-bold small text-muted">Pensioner Status</label>
                                <select class="form-select card shadow border border-1 border-black" name="pension_status">
                                    <option value="Non-Pensioner">Non-Pensioner</option>
                                    <option value="Pensioner">Pensioner</option>
                                </select>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-forest w-100 py-3 mt-4 fw-bold">
                            <i class="fa fa-user-plus me-2"></i> SAVE &amp; REGISTER CITIZEN
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="js/scripts.js"></script>
    <script src="js/calculateAge.js"></script>
</body>
</html>