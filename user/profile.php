<?php
session_start();
include("../includes/db_connection.php");

$id = $_GET['id'];
$oscaID = $id;

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
if ($row['PensionerStatus'] == 'Pensioner' || $row['PensionerStatus'] == 'Yes') {
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

<<<<<<< HEAD
                        <h5 class="fw-bold border-bottom pb-2 mb-3 mt-5 text-success">Documentary Verifications</h5>
<div class="row g-3 text-center no-print">
    
    <!-- SIGNATURE SIDE -->
    <div class="col-6">
        <label class="small text-muted fw-bold mb-2">SIGNATURE (Click to view)</label>
        <div class="d-flex justify-content-center">
            <img src="../uploads/<?php echo $row['SignaturePicture']; ?>" class="doc-img rounded shadow-sm" style="width: 90px !important; height: 90px !important; object-fit: contain !important; background-color: #f8f9fa; border: 1px solid #ccc;" onclick="viewImage(this)">
        </div>
    </div>
    
    <!-- THUMBMARKS SIDE -->
    <div class="col-6">
        <label class="small text-muted fw-bold mb-2">3 THUMBMARKS (Click to view)</label>
        <div class="d-flex justify-content-center gap-2">
            <img src="../uploads/<?php echo $row['thumbNailPicture1']; ?>" class="doc-img rounded shadow-sm" style="width: 90px !important; height: 90px !important; object-fit: contain !important; background-color: #f8f9fa; border: 1px solid #ccc;" onclick="viewImage(this)">
            <img src="../uploads/<?php echo $row['thumbNailPicture2']; ?>" class="doc-img rounded shadow-sm" style="width: 90px !important; height: 90px !important; object-fit: contain !important; background-color: #f8f9fa; border: 1px solid #ccc;" onclick="viewImage(this)">
            <img src="../uploads/<?php echo $row['thumbNailPicture3']; ?>" class="doc-img rounded shadow-sm" style="width: 90px !important; height: 90px !important; object-fit: contain !important; background-color: #f8f9fa; border: 1px solid #ccc;" onclick="viewImage(this)">
        </div>
    </div>
    
</div>

                        <div class="mt-2 text-muted small border-top pt-2">
                             Generated: <?php echo date("M d, Y h:i A", strtotime($row['GenerateDate'])); ?>
                        </div>
=======
                        <!-- SEPARATED ACTION BUTTONS -->
                        <div class="mt-4 no-print border-top pt-3">
                             <span class="section-title mb-3 d-block">View History Transaction (Click the Buttons below):</span>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="activity_records.php?id=<?php echo $id; ?>" class="btn btn-info px-3 py-2 fw-bold text-white">
                                    <i class="fa fa-calendar-check me-1"></i> Events/Activity
                                </a>
>>>>>>> newrevisesystem

                                <a href="pension_records.php?id=<?php echo $id; ?>" class="btn btn-success px-3 py-2 fw-bold">
                                    <i class="fa fa-wallet me-1"></i> Pension
                                </a>

                                <a href="dues_records.php?id=<?php echo $id; ?>" class="btn btn-warning px-3 py-2 fw-bold">
                                    <i class="fa fa-money-bill me-1"></i> Pay Dues
                                </a>

                                <a href="benefit_claim_records.php?id=<?php echo $id; ?>" class="btn btn-primary px-3 py-2 fw-bold">
                                    <i class="fa fa-hand-holding-heart me-1"></i> Dues Benefits
                                </a>
                                <a href="logout.php" class="btn btn-outline-danger px-4 py-2 fw-bold ms-auto">LOGOUT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<<<<<<< HEAD
<div class="modal fade" id="imageViewerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 text-center">
                <div class="position-relative d-inline-block">
                    <button type="button" class="btn-close custom-close-btn position-absolute top-0 end-0 m-3 shadow" data-bs-dismiss="modal" aria-label="Close"></button>
                    <img id="modalPreviewImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 85vh; background: white; padding: 5px; border: 1px solid #ddd;">
                </div>
            </div>
        </div>
    </div>
</div>

=======
>>>>>>> newrevisesystem
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    window.onload = function() {
        var id = "<?php echo $id; ?>";
        var target = document.getElementById("qrcode-target");
        new QRCode(target, { text: id, width: 200, height: 200, colorDark : "#1F4B2C", colorLight : "#ffffff", correctLevel : QRCode.CorrectLevel.H });
    };

<<<<<<< HEAD
    function viewImage(imgElement) {
        document.getElementById('modalPreviewImage').src = imgElement.src;
        var myModal = new bootstrap.Modal(document.getElementById('imageViewerModal'));
        myModal.show();
    }

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

function printCitizenRecord() {
    var newWindow = window.open("", "", "width=900,height=1000");

    var htmlContent = `
    <!DOCTYPE html>
    <html>
    <head>
        <title>SENIOR CITIZEN ID INFORMATION FORM</title>
        <style>
            @media print {
                @page { margin: 10mm; size: A4 portrait; }
                body { 
                    -webkit-print-color-adjust: exact; 
                    print-color-adjust: exact; 
                }
                /* FORCES CONTENT INTO ONE PAGE */
                html, body {
                    height: 100%;
                    overflow: hidden; 
                    page-break-inside: avoid;
                }
            }
            body {
                font-family: Arial, sans-serif;
                color: black;
                background: white;
                margin: 0 auto;
                padding: 15px 30px;
                box-sizing: border-box;
                width: 210mm; /* Strict A4 Width */
                height: 297mm; /* Strict A4 Height */
            }
            /* Header Title */
            .form-title {
                text-align: center;
                font-weight: bold;
                font-size: 21px;
                margin-bottom: 25px;
                margin-top: 10px;
                letter-spacing: 1px;
            }
            /* Top Layout: Fields on Left, Picture on Right */
            .top-section {
                display: flex;
                justify-content: space-between;
                margin-bottom: 20px;
            }
            .info-fields {
                flex: 1;
                padding-right: 30px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            /* Form Fields alignment */
            .field-row {
                display: flex;
                align-items: flex-end;
                margin-bottom: 16px;
            }
            .label {
                width: 260px;
                display: flex;
                justify-content: space-between;
                font-size: 14px;
                font-weight: normal;
                padding-right: 15px;
            }
            .value-line {
                flex: 1;
                border-bottom: 1px solid black;
                font-size: 15px;
                font-weight: bold;
                text-transform: uppercase;
                text-align: center;
                padding-bottom: 2px;
            }
            /* 2x2 Picture Box */
            .picture-box {
                width: 180px;
                height: 180px;
                border: 1px solid black;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 6px;
                box-sizing: border-box;
            }
            .inner-pic-box {
                width: 100%;
                height: 100%;
                border: 1px solid black;
                display: flex;
                justify-content: center;
                align-items: center;
                text-align: center;
                font-size: 12px;
                font-weight: bold;
            }
            .inner-pic-box img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            
            /* ==========================================
               UPDATED TABLE & IMAGE SIZING (Maximized Height)
               ========================================== */
            .sig-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                table-layout: fixed; 
            }
            .sig-table th, .sig-table td {
                border: 1px solid black;
                text-align: center;
                vertical-align: middle;
            }
            .sig-table th {
                padding: 12px;
                font-weight: bold;
                font-size: 16px;
            }
            .sig-table td {
                height: 175px; 
                padding: 5px; 
            }
            .sig-img {
                width: 100%;
                height: 165px; 
                object-fit: contain; 
                display: block;
                margin: 0 auto;
            }
            /* ========================================== */

            /* Footer Signatures */
            .footer {
                display: flex;
                justify-content: space-around;
                margin-top: 40px; 
            }
            .footer-sig {
                text-align: center;
                font-size: 14px;
            }
            .footer-line {
                border-bottom: 1px solid black;
                width: 280px;
                margin-bottom: 5px;
                text-align: center;
                font-weight: bold;
                padding-bottom: 3px;
            }
            /* Custom Checkboxes */
            .checkbox-container {
                display: flex;
                align-items: center;
                gap: 5px;
            }
            .checkbox {
                width: 30px;
                height: 18px;
                border: 1px solid black;
                display: inline-flex;
                justify-content: center;
                align-items: center;
                font-weight: bold;
                font-size: 16px;
            }
        </style>
    </head>
    <body>
        <div class="form-title">SENIOR CITIZEN ID INFORMATION FORM</div>
        
        <div class="top-section">
            <!-- LEFT SIDE: Text Fields -->
            <div class="info-fields">
                <div class="field-row">
                    <div class="label"><span>OSCA ID NO.</span><span>:</span></div>
                    <div class="value-line"><?php echo $id; ?></div>
                </div>
                <div class="field-row">
                    <div class="label"><span>LAST NAME/Apelyido</span><span>:</span></div>
                    <div class="value-line"><?php echo $row['LastName']; ?></div>
                </div>
                <div class="field-row">
                    <div class="label"><span>GIVEN NAME/Pangalan</span><span>:</span></div>
                    <div class="value-line"><?php echo $row['FirstName']; ?></div>
                </div>
                <div class="field-row">
                    <div class="label"><span>MIDDLE NAME/Gitnang Apelyido</span><span>:</span></div>
                    <div class="value-line"><?php echo $row['MiddleName']; ?></div>
                </div>
                <div class="field-row">
                    <div class="label"><span>ADDRESS/Tirahan</span><span>:</span></div>
                    <div class="value-line"><?php echo $row['Purok'].", ".$row['Barangay']; ?></div>
                </div>
                
                <div class="field-row">
                    <div class="label"><span>BIRTHDAY/Petsa ng Kapanganakan</span><span>:</span></div>
                    <div class="value-line" style="flex: 0.6;"><?php echo date("M d, Y", strtotime($row['Birthday'])); ?></div>
                    <div style="font-size: 14px; margin-left: 15px; margin-right: 5px;">AGE/Edad:</div>
                    <div class="value-line" style="flex: 0.3;"><?php echo $row['Age']; ?></div>
                </div>
                
                <div class="field-row" style="align-items: center; margin-top: 5px;">
                    <div class="label"><span>SEX/Kasarian</span><span>:</span></div>
                    <div style="flex: 1; display:flex; gap: 30px; margin-left: 10px;">
                        <div class="checkbox-container">
                            <div class="checkbox"><?php echo ($row['Sex'] == 'Male') ? '&#10003;' : ''; ?></div>
                            <span>Male</span>
                        </div>
                        <div class="checkbox-container">
                            <div class="checkbox"><?php echo ($row['Sex'] == 'Female') ? '&#10003;' : ''; ?></div>
                            <span>Female</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- RIGHT SIDE: Picture Box -->
            <div class="picture-box">
                <div class="inner-pic-box">
                    <?php if ($row['Picture'] != '') { ?>
                        <img src="../uploads/<?php echo $row['Picture']; ?>">
                    <?php } else { ?>
                        2X2 ID<br>PICTURE
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- THE SIGNATURE/THUMBMARK TABLE -->
        <table class="sig-table">
            <tr>
                <th>SIGNATURE</th>
                <th>THUMBMARK</th>
            </tr>
            <!-- ROW 1 -->
            <tr>
                <td>
                    <?php if ($row['SignaturePicture'] != '') { ?>
                        <img src="../uploads/<?php echo $row['SignaturePicture']; ?>" class="sig-img">
                    <?php } ?>
                </td>
                <td>
                    <?php if ($row['thumbNailPicture1'] != '') { ?>
                        <img src="../uploads/<?php echo $row['thumbNailPicture1']; ?>" class="sig-img">
                    <?php } ?>
                </td>
            </tr>
            <!-- ROW 2 (Duplicate Signature) -->
            <tr>
                <td>
                    <?php if ($row['SignaturePicture'] != '') { ?>
                        <img src="../uploads/<?php echo $row['SignaturePicture']; ?>" class="sig-img">
                    <?php } ?>
                </td>
                <td>
                    <?php if ($row['thumbNailPicture2'] != '') { ?>
                        <img src="../uploads/<?php echo $row['thumbNailPicture2']; ?>" class="sig-img">
                    <?php } ?>
                </td>
            </tr>
            <!-- ROW 3 (Duplicate Signature) -->
            <tr>
                <td>
                    <?php if ($row['SignaturePicture'] != '') { ?>
                        <img src="../uploads/<?php echo $row['SignaturePicture']; ?>" class="sig-img">
                    <?php } ?>
                </td>
                <td>
                    <?php if ($row['thumbNailPicture3'] != '') { ?>
                        <img src="../uploads/<?php echo $row['thumbNailPicture3']; ?>" class="sig-img">
                    <?php } ?>
                </td>
            </tr>
        </table>

        <!-- FOOTER -->
        <div class="footer">
            <div class="footer-sig">
                <!-- Changed to display Senior Citizen's full name in ALL CAPS -->
                <div class="footer-line" style="text-transform: uppercase;"><?php echo $row['FirstName'] . " " . $row['MiddleName'] . " " . $row['LastName']; ?></div>
                <div>Senior Citizen</div>
            </div>
            <div class="footer-sig">
                <div class="footer-line"><?php echo date("M d, Y"); ?></div>
                <div>Generated Date</div>
            </div>
        </div>
    </body>
    </html>
    `;

    newWindow.document.write(htmlContent);
    newWindow.document.close();
    newWindow.focus();
    
    setTimeout(function() {
        newWindow.print();
        newWindow.close();
    }, 1500); 
}
=======
    function printQRCodeOnly() {
        var qrContent = document.getElementById("qrcode-target").innerHTML;
        var newWindow = window.open("", "", "width=800,height=800");
        newWindow.document.write(`<html><head><title>Print QR</title><style>body { margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column; } #qr-wrapper { text-align: center; } img, canvas { display: block; margin: 0 auto; } p { font-family: Arial; font-weight: bold; font-size: 24px; margin-top: 10px; }</style></head><body><div id="qr-wrapper">${qrContent}<p>OSCA ID: <?php echo $id; ?></p></div><script>window.onload = function() { window.print(); window.close(); };<\/script></body></html>`);
        newWindow.document.close();
    }
>>>>>>> newrevisesystem
</script>
</body>
</html>