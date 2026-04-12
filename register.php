<!DOCTYPE html>
<?php include "include.php"; ?>
<html lang="en">
<head>
    <title>Senior Registration | SENIOR-CARE</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Style -->
    <link rel="stylesheet" href="userStyle.css">
</head>
<body>

<div class="navbar-custom">SENIOR-CARE MANAGEMENT SYSTEM</div>

<div class="container main-container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header py-3">Senior Citizen Profiling Registration</div>
                <div class="card-body p-4">
                    
                    <!-- ENCTYPE is mandatory for photo uploads -->
                    <form id="seniorForm" action="add_query_senior.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <!-- ID and Status Row -->
                            <div class="col-md-4">
                                <label class="fw-bold small">OscaIDNo. (Primary Key)</label>
                                <!-- Preserves leading zeros by using text type with numeric restriction -->
                                <input type="text" class="form-control" name="oscaID" 
                                       placeholder="Numbers only (e.g. 00123)" 
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')" required/>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold small">Sex</label>
                                <select class="form-select" name="sex" required>
                                    <option value="" disabled selected>Select Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold small">Citizen Status</label>
                                <select class="form-select" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Name Row -->
                            <div class="col-md-4">
                                <label class="small">First Name</label>
                                <input type="text" class="form-control" name="fname" required/>
                            </div>
                            <div class="col-md-4">
                                <label class="small">Middle Name</label>
                                <input type="text" class="form-control" name="mi"/>
                            </div>
                            <div class="col-md-4">
                                <label class="small">Last Name</label>
                                <input type="text" class="form-control" name="lname" required/>
                            </div>

                            <!-- Address and Birthday Row -->
                            <div class="col-md-4">
                                <label class="small">Purok (Zone)</label>
                                <select class="form-select" name="purok" required>
                                    <option value="" disabled selected>Select a Zone</option>
                                    <?php for($i=1; $i<=6; $i++) echo "<option value='Zone $i'>Zone $i</option>"; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="small">Barangay</label>
                                <input type="text" class="form-control" name="brgy" value="Kalawag 1" readonly/>
                            </div>
                            <div class="col-md-4">
                                <label class="small">Birthday</label>
                                <input type="date" class="form-control" name="bday" id="bdayInput" onchange="calculateAge()" required/>
                                <!-- Display Derived Age -->
                                <div id="ageDisplay" class="mt-1 text-primary fw-bold small">Derived Age: --</div>
                            </div>

                            <!-- 1. Profile Picture Section -->
                            <div class="col-12 mt-4 border-top pt-3">
                                <label class="fw-bold text-success">1. OFFICIAL PROFILE PICTURE</label>
                                <input type="file" class="form-control" name="pic" accept="image/*" required/>
                                <div class="upload-instruction">Note: Picture must have a plain <strong>white background</strong>.</div>
                            </div>

                            <!-- 2. Three Signatures Section -->
                            <div class="col-md-6 mt-3">
                                <label class="fw-bold text-success">2. THREE (3) SIGNATURES</label>
                                <input type="file" class="form-control mb-1" name="sig1" required/>
                                <input type="file" class="form-control mb-1" name="sig2" required/>
                                <input type="file" class="form-control" name="sig3" required/>
                                <div class="upload-instruction">Note: Make a signature in a <strong>white paper</strong>, take a picture and upload.</div>
                            </div>

                            <!-- 3. Three Thumbmarks Section -->
                            <div class="col-md-6 mt-3">
                                <label class="fw-bold text-success">3. THREE (3) THUMBMARKS</label>
                                <input type="file" class="form-control mb-1" name="thumb1" required/>
                                <input type="file" class="form-control mb-1" name="thumb2" required/>
                                <input type="file" class="form-control" name="thumb3" required/>
                                <div class="upload-instruction">Note: Make a thumbnail/thumbmark in a <strong>white paper</strong>, take a picture and upload.</div>
                            </div>
                        </div>

                        <br />
                        <!-- Trigger SweetAlert from UserQRGenerate.js -->
                        <button type="button" onclick="initiateProfiling()" class="btn btn-forest w-100 py-3">SUBMIT & GENERATE QR</button>
                    </form>

                </div>
                <!-- Login Link -->
                <div class="card-footer bg-white text-center border-0 pb-4">
                    <p class="mb-0 text-muted small">Already have an account? <a href="login.php" class="text-success fw-bold text-decoration-none">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="UserQRGenerate.js"></script>
</body>
</html>