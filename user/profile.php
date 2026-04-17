<?php
include("../includes/db_connection.php");

if (!isset($_GET['id'])) { header("Location: login.php"); exit; }

$id = mysqli_real_escape_string($conn, $_GET['id']);
$res = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$id'");
$row = mysqli_fetch_assoc($res);

if (!$row) { header("Location: login.php"); exit; }

// --- AGE CALCULATION (PHP) ---
$bday = new DateTime($row['Birthday']);
$today = new DateTime('today');
$age = $bday->diff($today)->y;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Profile - OscaIDNo. <?php echo $id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/userStyle.css">
</head>
<body>

<div class="navbar-custom no-print">SENIOR-CARE PORTAL</div>

<div class="container py-4 main-container">
    <div class="row justify-content-center">
        <div class="col-xl-11">
            
            <!-- THE PROFILE CARD (The part that will be printed) -->
            <div class="profile-card" id="profileCard">
                <div class="row g-0">
                    <!-- LEFT SIDE: PHOTO & QR -->
                    <div class="col-md-4 id-side">
                       <img src="../uploads/<?php echo $row['Picture']; ?>" class="display-pic">
                        <h5 class="fw-bold mb-0"><?php echo $row['FirstName']; ?></h5>
                        <p class="small opacity-75 mb-3">OscaIDNo. <?php echo $id; ?></p>
                        
                        <div id="qrcode-target"></div>
                        
                        <!-- NEW PRINT QR BUTTON -->
                        <div class="mt-4 no-print">
                            <button onclick="printQRCodeOnly()" class="btn btn-sm btn-light fw-bold shadow-sm">
                                <i class="fa fa-print me-1"></i> Print QR Only
                            </button>
                        </div>
                    </div>

                    <!-- RIGHT SIDE: INFORMATION -->
                    <div class="col-md-8 data-side d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="section-title">Official Registry Details</span>
                            <span class="badge bg-success no-print px-3"><?php echo strtoupper($row['CitezenStatus']); ?></span>
                        </div>

                        <div class="row flex-grow-1">
                            <div class="col-12">
                                <label class="label-tag">OscaIDNo. (Primary System ID)</label>
                                <div class="data-box text-primary fs-5 fw-bold"><?php echo $id; ?></div>
                            </div>
                            <div class="col-12">
                                <label class="label-tag">Full Legal Name</label>
                                <div class="data-box fs-5 text-uppercase"><?php echo $row['LastName'].", ".$row['FirstName']." ".$row['MiddleName']; ?></div>
                            </div>
                            <div class="col-md-4 col-4">
                                <label class="label-tag">Sex</label>
                                <div class="data-box"><?php echo $row['Sex']; ?></div>
                            </div>
                            <div class="col-md-4 col-4">
                                <label class="label-tag">Age</label>
                                <div class="data-box text-success fw-bold"><?php echo $age; ?> Yrs</div>
                            </div>
                            <div class="col-md-4 col-4">
                                <label class="label-tag">Birthday</label>
                                <div class="data-box"><?php echo $row['Birthday']; ?></div>
                            </div>
                            <div class="col-12">
                                <label class="label-tag">Permanent Address</label>
                                <div class="data-box"><?php echo $row['Purok'].", ".$row['Barangay']; ?></div>
                            </div>
                        </div>

                        <div class="mt-2 text-muted small border-top pt-2">
                             Generated: <?php echo date("M d, Y h:i A", strtotime($row['GenerateDate'])); ?>
                        </div>

                        <!-- ACTIONS (Hidden during print) -->
                        <div class="mt-4 d-flex gap-2 no-print">
                            <button onclick="printPage()" class="btn btn-forest flex-grow-1 py-2 shadow-sm">
                                <i class="fa fa-print me-2"></i> PRINT FULL PROFILE
                            </button>
                            <a href="logout.php" class="btn btn-outline-secondary px-4 py-2">LOGOUT</a>
                        </div>
                    </div>
                </div>
            </div> <!-- End profileCard -->

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="js/UserQRGenerate.js"></script>

<script>
    window.onload = function() {
        renderProfileQR("<?php echo $id; ?>");
    };

  function printQRCodeOnly() {
    // 1. Grab the QR container
    const qrContainer = document.getElementById("qrcode-target");
    const qrContent = qrContainer.innerHTML; // This gets the <img> or <canvas> generated by qrcode.js

    // 2. Open a small window (300x300 is perfect for a QR code)
    const newWindow = window.open("", "", "width=800,height=800");

    // 3. Write minimal HTML to the popup
    newWindow.document.write(`
        <html>
        <head>
            <title>Print QR</title>
            <style>
                body { 
                    margin: 0; 
                    display: flex; 
                    justify-content: center; 
                    align-items: center; 
                    height: 100vh; 
                }
                #qr-wrapper { text-align: center; }
                img, canvas { display: block; margin: 0 auto; }
            </style>
        </head>
        <body>
            <div id="qr-wrapper">${qrContent}</div>
            <script>
                // Wait for images/canvas to load, then print
                window.onload = function() {
                    window.print();
                    window.close();
                };
            <\/script>
        </body>
        </html>
    `);
    newWindow.document.close();
}
</script>
</body>
</html>