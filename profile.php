<?php
require_once('include.php');

// Redirect if no ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: login.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$res = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$id'");
$row = mysqli_fetch_assoc($res);

// If ID doesn't exist in the database
if (!$row) {
    echo "<script>alert('OscaIDNo. not found!'); window.location='login.php';</script>";
    exit;
}

// 1. Derived Age Calculation (3NF logic)
$birthDate = new DateTime($row['Birthday']);
$today = new DateTime('today');
$derivedAge = $birthDate->diff($today)->y;

// 2. Status Color Logic
$statusClass = ($row['CitezenStatus'] == 'active') ? 'active-bg' : 'inactive-bg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - OscaIDNo. <?php echo $row['OscaIDNo']; ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Your Custom CSS -->
    <link rel="stylesheet" href="userStyle.css">
</head>
<body>

<div class="navbar-custom no-print">
    <i class="fa-solid fa-id-badge me-2"></i> SENIOR-CARE PORTAL
</div>

<div class="container py-4 main-container">
    <div class="row justify-content-center">
        <div class="col-xl-11">
            
            <!-- Admin Authorization Note -->
            <div class="admin-notice mb-3 no-print">
                <i class="fa-solid fa-lock me-2"></i> 
                <strong>OscaIDNo. <?php echo $row['OscaIDNo']; ?></strong> is a verified record. 
                Authority to edit details is restricted to the Admin.
            </div>

            <div class="profile-card">
                <div class="row g-0">
                    
                    <!-- LEFT SIDE: IDENTITY BOX -->
                    <div class="col-md-4 id-side">
                        <!-- Shows uploaded photo from /uploads folder -->
                        <img src="uploads/<?php echo $row['Picture']; ?>" class="display-pic shadow" alt="Profile Photo">
                        
                        <h4 class="fw-bold mb-0"><?php echo $row['FirstName']; ?></h4>
                        <p class="small opacity-75 mb-3">OscaIDNo. <?php echo $row['OscaIDNo']; ?></p>

                        <!-- QR Code Area (Approach 1) -->
                        <div id="qrcode-target"></div>
                        
                        <div class="mt-4 px-2 no-print">
                            <div class="p-2 rounded bg-white bg-opacity-10 small border border-light border-opacity-25">
                                <i class="fa-solid fa-camera me-1 text-warning"></i>
                                Screenshot or Download QR
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE: INFORMATION GRID -->
                    <div class="col-md-8 data-side">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="section-title">Official Registry Details</span>
                            <span class="status-pill <?php echo $statusClass; ?>">
                                <i class="fa-solid fa-circle-check me-1"></i> <?php echo strtoupper($row['CitezenStatus']); ?>
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label class="label-tag">OscaIDNo. (System Primary Key)</label>
                                <div class="data-box text-primary fs-5 fw-bold"><?php echo $row['OscaIDNo']; ?></div>
                            </div>

                            <div class="col-12">
                                <label class="label-tag">Full Legal Name</label>
                                <div class="data-box fs-5 text-uppercase">
                                    <?php echo $row['LastName'] . ", " . $row['FirstName'] . " " . $row['MiddleName']; ?>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="label-tag">Sex</label>
                                <div class="data-box"><?php echo $row['Sex']; ?></div>
                            </div>
                            <div class="col-md-4">
                                <label class="label-tag">Derived Age</label>
                                <div class="data-box text-success fw-bold"><?php echo $derivedAge; ?> Years Old</div>
                            </div>
                            <div class="col-md-4">
                                <label class="label-tag">Birthday</label>
                                <div class="data-box"><?php echo date("M d, Y", strtotime($row['Birthday'])); ?></div>
                            </div>

                            <div class="col-12 mt-2">
                                <span class="section-title">Address Information</span>
                            </div>

                            <div class="col-md-6">
                                <label class="label-tag">Purok / Zone</label>
                                <div class="data-box"><?php echo $row['Purok']; ?></div>
                            </div>
                            <div class="col-md-6">
                                <label class="label-tag">Barangay</label>
                                <div class="data-box"><?php echo $row['Barangay']; ?></div>
                            </div>

                            <div class="col-12 mt-3 pt-3 border-top">
                                <div class="d-flex justify-content-between small text-muted">
                                    <span><strong>Generated on:</strong> <?php echo date("F j, Y - h:i A", strtotime($row['GenerateDate'])); ?></span>
                                    <span class="no-print"><i class="fa-solid fa-shield-halved"></i> Secured Record</span>
                                </div>
                            </div>
                        </div>

                        <!-- ACTIONS (HIDDEN ON PRINT) -->
                        <div class="mt-4 d-flex gap-2 no-print">
                            <button onclick="window.print()" class="btn btn-forest flex-grow-1 py-2">
                                <i class="fa-solid fa-print me-2"></i> PRINT OFFICIAL PROFILE
                            </button>
                            <a href="logout.php" class="btn btn-outline-secondary px-4 py-2">
                                <i class="fa-solid fa-right-from-bracket"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Code Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<!-- Externalized Script File -->
<script src="UserQRGenerate.js"></script>

<script>
    // Initialize QR code generation on page load using the ID from PHP
    window.onload = function() {
        renderProfileQR("<?php echo $row['OscaIDNo']; ?>");
    };
</script>

</body>
</html>