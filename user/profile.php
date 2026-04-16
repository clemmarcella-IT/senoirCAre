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
                        <!-- Added Prefix -->
                        <p class="small opacity-75 mb-3">OscaIDNo. <?php echo $id; ?></p>
                        
                        <div id="qrcode-target"></div>
                        
                        <div class="mt-4 px-2 no-print small opacity-75">
                            <i class="fa fa-camera"></i> Screenshot or Download QR
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
                                <i class="fa fa-print me-2"></i> PRINT PROFILE
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

    function printPage() {
        var cardContent = document.getElementById("profileCard");
        var printClone = cardContent.cloneNode(true);
        var buttons = printClone.querySelectorAll('.no-print');
        buttons.forEach(btn => btn.remove());

        var newWindow = window.open("", "", "width=800,height=600");
        newWindow.document.write("<html><head><title>Print Official Profile</title>");
        
        // Corrected CSS path for the new window
        newWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">');
        newWindow.document.write('<link rel="stylesheet" href="css/userStyle.css">');
        
        newWindow.document.write(`
            <style>
                body { background: white !important; padding: 30px; }
                .profile-card { box-shadow: none !important; border: 1px solid #333; width: 100%; border-radius: 0; }
                .id-side { background-color: #f8f9fa !important; color: black !important; border-right: 1px solid #ddd; }
                .display-pic { border: 3px solid #333 !important; }
                .data-box { border-bottom: 1px solid #000 !important; font-weight: bold; }
            </style>
        `);
        newWindow.document.write("</head><body>");
        newWindow.document.write('<div class="profile-card">' + printClone.innerHTML + '</div>');
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        
        newWindow.focus();
        setTimeout(function() {
            newWindow.print();
            newWindow.close();
        }, 750);
    }
</script>
</body>
</html>