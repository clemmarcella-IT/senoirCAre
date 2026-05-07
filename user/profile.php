<?php
include("../includes/db_connection.php");

$id = $_GET['id'];

// Get Senior Info
$res = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$id'");
$row = mysqli_fetch_array($res);

// If ID is not found, redirect to login
if ($row == false) {
    header("Location: login.php");
}

// Get Admin Contact
$q_admin = mysqli_query($conn, "SELECT ContactNumber FROM admin_users WHERE AdminID=1");
$row_admin = mysqli_fetch_array($q_admin);
$admin_contact = $row_admin['ContactNumber'];

// Simple age calculation
$birthYear = date("Y", strtotime($row['Birthday']));
$currentYear = date("Y");
$age = $currentYear - $birthYear;

// Logic for Pensioner Status Display
if ($row['PensionerStatus'] == 'Yes') {
    $pension_text = "Pensioner";
    $pension_color = "text-success";
} else {
    $pension_text = "Non-Pensioner";
    $pension_color = "text-danger";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profile - OscaIDNo. <?php echo $id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/userStyle.css">
</head>
<body>

<div class="navbar-custom no-print d-flex flex-column text-center" style="height: auto; padding: 15px 0;">
    <div>SENIOR-CARE PORTAL</div>
    <div style="font-size: 0.85rem; font-weight: normal; margin-top: 5px; opacity: 0.9;">
        Admin Contact: <?php echo $admin_contact; ?>
    </div>
</div>

<div class="container py-4 main-container">
    <div class="row justify-content-center">
        <div class="col-xl-11">
            
            <div class="profile-card">
                <div class="row g-0">
                    
                    <!-- LEFT SIDE: QR CODE -->
                    <div class="col-md-4 id-side d-flex flex-column justify-content-center align-items-center">
                        <h5 class="fw-bold mb-0"><?php echo $row['FirstName']; ?></h5>
                        <p class="small opacity-75 mb-3">OscaIDNo. <?php echo $id; ?></p>
                        
                        <div id="qrcode-target" class="bg-white p-2 rounded"></div>
                        
                        <div class="mt-4 no-print">
                            <button onclick="printQRCodeOnly()" class="btn btn-sm btn-light fw-bold shadow-sm">
                                <i class="fa fa-print me-1"></i> Print QR Code
                            </button>
                        </div>
                    </div>

                    <!-- RIGHT SIDE: TEXT INFORMATION -->
                    <div class="col-md-8 data-side d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="section-title">Official Registry Details</span>
                            <?php 
                            if ($row['CitizenStatus'] == 'Inactive') {
                                $badgeColor = 'bg-danger';
                            } else {
                                $badgeColor = 'bg-success';
                            }
                            ?>
                            <span class="badge <?php echo $badgeColor; ?> no-print px-3"><?php echo $row['CitizenStatus']; ?></span>
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
                            <div class="col-6">
                                <label class="label-tag">Permanent Address</label>
                                <div class="data-box"><?php echo $row['Purok'].", ".$row['Barangay']; ?></div>
                            </div>
                            <div class="col-6">
                                <label class="label-tag">Pensioner Status</label>
                                <!-- THIS IS WHERE IT DISPLAYS PENSIONER OR NON-PENSIONER -->
                                <div class="data-box <?php echo $pension_color; ?> fw-bold"><?php echo $pension_text; ?></div>
                            </div>
                        </div>

                        <!-- SEPARATED ACTION BUTTONS -->
                        <div class="mt-4 d-flex gap-2 flex-wrap no-print border-top pt-3">
                            <a href="activity_records.php?id=<?php echo $id; ?>" class="btn btn-info px-3 py-2 fw-bold text-white"><i class="fa fa-calendar-check me-1"></i> Events/Activity</a>
                            <a href="pension_records.php?id=<?php echo $id; ?>" class="btn btn-success px-3 py-2 fw-bold"><i class="fa fa-wallet me-1"></i> Pension</a>
                            <a href="dues_records.php?id=<?php echo $id; ?>" class="btn btn-warning px-3 py-2 fw-bold"><i class="fa fa-money-bill me-1"></i> Pay Dues</a>
                            <a href="benefit_claim_records.php?id=<?php echo $id; ?>" class="btn btn-primary px-3 py-2 fw-bold"><i class="fa fa-hand-holding-heart me-1"></i> Dues Benefits</a>
                            <a href="logout.php" class="btn btn-outline-danger px-4 py-2 fw-bold ms-auto">LOGOUT</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    window.onload = function() {
        var id = "<?php echo $id; ?>";
        var target = document.getElementById("qrcode-target");
        new QRCode(target, { text: id, width: 200, height: 200, colorDark : "#1F4B2C", colorLight : "#ffffff", correctLevel : QRCode.CorrectLevel.H });
    };

    function printQRCodeOnly() {
        var qrContent = document.getElementById("qrcode-target").innerHTML;
        var newWindow = window.open("", "", "width=800,height=800");
        newWindow.document.write(`<html><head><title>Print QR</title><style>body { margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column; } #qr-wrapper { text-align: center; } img, canvas { display: block; margin: 0 auto; } p { font-family: Arial; font-weight: bold; font-size: 24px; margin-top: 10px; }</style></head><body><div id="qr-wrapper">${qrContent}<p>OSCA ID: <?php echo $id; ?></p></div><script>window.onload = function() { window.print(); window.close(); };<\/script></body></html>`);
        newWindow.document.close();
    }
</script>
</body>
</html>