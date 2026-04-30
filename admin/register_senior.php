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
                    <form id="seniorForm" action="query_add_senior.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <!-- Row 1 -->
                            <div class="col-md-4">
                                <label class="fw-bold small text-muted">OscaIDNo. (Primary Key)</label>
                                <input type="text" class="form-control card shadow border border-1 border-black" name="oscaID" placeholder="Numbers only" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required/>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold small text-muted">Sex</label>
                                <select class="form-select card shadow border border-1 border-black" name="sex" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold small text-muted">Citizen Status</label>
                                <select class="form-select card shadow border border-1 border-black" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Row 2 -->
                            <div class="col-md-4"><label class="small fw-bold">First Name</label><input type="text" class="form-control card shadow border border-1 border-black" name="fname" required/></div>
                            <div class="col-md-4"><label class="small fw-bold">Middle Name</label><input type="text" class="form-control card shadow border border-1 border-black" name="mi"/></div>
                            <div class="col-md-4"><label class="small fw-bold">Last Name</label><input type="text" class="form-control card shadow border border-1 border-black" name="lname" required/></div>

                            <!-- Row 3: Added Live Age Calculation -->
                            <div class="col-md-4">
                                <label class="small fw-bold">Purok (Zone)</label>
                                <select class="form-select card shadow border border-1 border-black" name="purok" required>
                                    <?php for($i=1; $i<=6; $i++) echo "<option value='Zone $i'>Zone $i</option>"; ?>
                                </select>
                            </div>
                            <div class="col-md-4"><label class="small fw-bold">Barangay</label><input type="text" class="form-control card shadow border border-1 border-black" name="brgy" value="Kalawag 1" readonly/></div>
                            
                            <!-- THE FIX: Birthday & Derived Age -->
                            <div class="col-md-4">
                                <label class="small fw-bold">Birthday</label>
                                <input type="date" class="form-control card shadow border border-1 border-black" name="bday" id="bdayInput" onchange="calculateAge()" required/>
                                <div id="ageDisplay" class="mt-1 text-primary fw-bold small">Derived Age: --</div>
                            </div>

                            <!-- Row 4 & 5 (Uploads) -->
                            <div class="col-12 mt-4 border-top pt-3">
                                <label class="fw-bold text-success">1. PROFILE PICTURE</label>
                                <input type="file" class="form-control card shadow border border-1 border-black" name="pic" accept="image/*" required/>
                                <div class="upload-instruction" >Note: Picture must have a plain <strong>white background</strong>.</div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="fw-bold text-success">2. SIGNATURE</label>
                                <input type="file" class="form-control card shadow border border-1 border-black" name="sig1" required/>
                                <div class="upload-instruction">Note: Sign on <strong>white paper</strong> and upload.</div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="fw-bold text-success">3. THUMBMARK</label>
                                <input type="file" class="form-control card shadow border border-1 border-black mb-2" name="thumb1" required/>
                                <div class="upload-instruction">Note: Upload single thumbprint.</div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-forest w-100 py-3 mt-4 fw-bold">SAVE & REGISTER CITIZEN</button>
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