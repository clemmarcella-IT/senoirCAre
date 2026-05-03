<?php
include("../includes/db_connection.php");

$id = $_GET['id'];

// Query seniors directly; image fields live in seniors table
$res = mysqli_query($conn, "SELECT seniors.* 
                            FROM seniors 
                            WHERE seniors.OscaIDNo = '$id'");
$row = mysqli_fetch_array($res);

if (!$row) { header("Location: login.php"); exit; }

// Fetch the Admin Contact Number
$q_admin = mysqli_query($conn, "SELECT ContactNumber FROM admin_users WHERE AdminID=1");
$row_admin = mysqli_fetch_array($q_admin);
$admin_contact = $row_admin['ContactNumber'];

// Simple age calculation from Birthday
$birthYear  = date("Y", strtotime($row['Birthday']));
$birthMonth = date("m", strtotime($row['Birthday']));
$birthDay   = date("d", strtotime($row['Birthday']));

$currentYear  = date("Y");
$currentMonth = date("m");
$currentDay   = date("d");

$age = $currentYear - $birthYear;
if ($currentMonth < $birthMonth) {
    $age = $age - 1;
} else if ($currentMonth == $birthMonth && $currentDay < $birthDay) {
    $age = $age - 1;
}
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

<div class="navbar-custom no-print d-flex flex-column text-center" style="height: auto; padding: 15px 0;">
    <div>SENIOR-CARE PORTAL</div>
    <div style="font-size: 0.85rem; font-weight: normal; margin-top: 5px; opacity: 0.9;">
        Admin Contact: <?php echo $admin_contact; ?>
    </div>
</div>

<div class="container py-4 main-container">
    <div class="row justify-content-center">
        <div class="col-xl-11">
            
            <div class="profile-card" id="profileCard">
                <div class="row g-0">
                    <!-- LEFT SIDE: PHOTO & QR -->
                    <div class="col-md-4 id-side">
                       <img src="../uploads/<?php echo $row['Picture']; ?>" class="display-pic">
                        <h5 class="fw-bold mb-0"><?php echo $row['FirstName']; ?></h5>
                        <p class="small opacity-75 mb-3">OscaIDNo. <?php echo $id; ?></p>
                        
                        <div id="qrcode-target"></div>
                        
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
                            <?php 
                            if ($row['CitizenStatus'] == 'inactive') {
                                $statusClass = 'bg-danger';
                            } else {
                                $statusClass = 'bg-success';
                            }
                            ?>
                            <span class="badge <?php echo $statusClass; ?> no-print px-3"><?php echo $row['CitizenStatus']; ?></span>
                        </div>

                        <div class="row flex-grow-1">
                            <div class="col-12">
                                <label class="label-tag">OscaIDNo. (Primary System ID)</label>
                                <div class="data-box text-primary fs-5 fw-bold"><?php echo $id; ?></div>
                            </div>
                            <div class="col-12">
                                <label class="label-tag">Full Legal Name</label>
                                <div class="data-box fs-5 text-uppercase"><?php echo $row['LastName']; ?>, <?php echo $row['FirstName']; ?> <?php echo $row['MiddleName']; ?></div>
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
                                <div class="data-box"><?php echo $row['Purok']; ?>, <?php echo $row['Barangay']; ?></div>
                            </div>
                        </div>

                        <h5 class="fw-bold border-bottom pb-2 mb-3 mt-5 text-success">Documentary Verifications</h5>
                        <div class="row g-3 text-center no-print">
                            
                            <!-- SIGNATURE SIDE -->
                            <div class="col-6">
                                <label class="small text-muted fw-bold mb-2">SIGNATURE (Click to view)</label>
                                <div class="d-flex justify-content-center">
                                    <img src="../uploads/<?php echo $row['SignaturePicture']; ?>" class="doc-img rounded shadow-sm" style="width: 90px !important; height: 90px !important; object-fit: contain !important; background-color: #f8f9fa; border: 1px solid #ccc;" onclick="viewImage(this)">
                                </div>
                            </div>
                            
                            <!-- THUMBMARK SIDE -->
                            <div class="col-6">
                                <label class="small text-muted fw-bold mb-2">THUMBMARK (Click to view)</label>
                                <div class="d-flex justify-content-center gap-2">
                                    <img src="../uploads/<?php echo $row['ThumbmarkPicture']; ?>" class="doc-img rounded shadow-sm" style="width: 90px !important; height: 90px !important; object-fit: contain !important; background-color: #f8f9fa; border: 1px solid #ccc;" onclick="viewImage(this)">
                                </div>
                            </div>
                            
                        </div>

                        <div class="mt-2 text-muted small border-top pt-2">
                             Generated: <?php echo date("M d, Y h:i A", strtotime($row['GenerateDate'])); ?>
                        </div>

                        <!-- ACTIONS -->
                        <div class="mt-4 d-flex gap-2 no-print">
                            <button onclick="printCitizenRecord()" class="btn btn-forest flex-grow-1 py-2 shadow-sm">
                                <i class="fa fa-print me-2"></i> PRINT FULL PROFILE
                            </button>
                            <a href="logout.php" class="btn btn-outline-secondary px-4 py-2">LOGOUT</a>
                        </div>
                    </div>
                </div>
            </div> 

        </div>
    </div>
</div>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="js/UserQRGenerate.js"></script>

<script>
    window.onload = function() {
        renderProfileQR("<?php echo $id; ?>");
    };

    function viewImage(imgElement) {
        document.getElementById('modalPreviewImage').src = imgElement.src;
        var myModal = new bootstrap.Modal(document.getElementById('imageViewerModal'));
        myModal.show();
    }

  function printQRCodeOnly() {
    const qrContainer = document.getElementById("qrcode-target");
    const qrContent = qrContainer.innerHTML;

    const newWindow = window.open("", "", "width=800,height=800");

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
                width: 210mm;
                height: 297mm;
            }
            .form-title {
                text-align: center;
                font-weight: bold;
                font-size: 21px;
                margin-bottom: 25px;
                margin-top: 10px;
                letter-spacing: 1px;
            }
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
                    <div class="value-line"><?php echo $row['Purok']; ?>, <?php echo $row['Barangay']; ?></div>
                </div>
                
                <div class="field-row">
                    <div class="label"><span>BIRTHDAY/Petsa ng Kapanganakan</span><span>:</span></div>
                    <div class="value-line" style="flex: 0.6;"><?php echo date("M d, Y", strtotime($row['Birthday'])); ?></div>
                    <div style="font-size: 14px; margin-left: 15px; margin-right: 5px;">AGE/Edad:</div>
                    <div class="value-line" style="flex: 0.3;"><?php echo $age; ?></div>
                </div>
                
                <div class="field-row" style="align-items: center; margin-top: 5px;">
                    <div class="label"><span>SEX/Kasarian</span><span>:</span></div>
                    <div style="flex: 1; display:flex; gap: 30px; margin-left: 10px;">
                        <div class="checkbox-container">
                            <div class="checkbox"><?php if($row['Sex'] == 'Male') { echo '&#10003;'; } else { echo ''; } ?></div>
                            <span>Male</span>
                        </div>
                        <div class="checkbox-container">
                            <div class="checkbox"><?php if($row['Sex'] == 'Female') { echo '&#10003;'; } else { echo ''; } ?></div>
                            <span>Female</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="picture-box">
                <div class="inner-pic-box">
                    <?php if ($row['Picture'] != "") { ?>
                        <img src="../uploads/<?php echo $row['Picture']; ?>">
                    <?php } else { ?>
                        2X2 ID<br>PICTURE
                    <?php } ?>
                </div>
            </div>
        </div>

        <table class="sig-table">
            <tr>
                <th>SIGNATURE</th>
                <th>THUMBMARK</th>
            </tr>
            <!-- ROW 1 -->
            <tr>
                <td>
                    <?php if ($row['SignaturePicture'] != "") { ?>
                        <img src="../uploads/<?php echo $row['SignaturePicture']; ?>" class="sig-img">
                    <?php } ?>
                </td>
                <td>
                    <?php if ($row['ThumbmarkPicture'] != "") { ?>
                        <img src="../uploads/<?php echo $row['ThumbmarkPicture']; ?>" class="sig-img">
                    <?php } ?>
                </td>
            </tr>
            <!-- ROW 2 -->
            <tr>
                <td>
                    <?php if ($row['SignaturePicture'] != "") { ?>
                        <img src="../uploads/<?php echo $row['SignaturePicture']; ?>" class="sig-img">
                    <?php } ?>
                </td>
                <td>
                    <?php if ($row['ThumbmarkPicture'] != "") { ?>
                        <img src="../uploads/<?php echo $row['ThumbmarkPicture']; ?>" class="sig-img">
                    <?php } ?>
                </td>
            </tr>
            <!-- ROW 3 -->
            <tr>
                <td>
                    <?php if ($row['SignaturePicture'] != "") { ?>
                        <img src="../uploads/<?php echo $row['SignaturePicture']; ?>" class="sig-img">
                    <?php } ?>
                </td>
                <td>
                    <?php if ($row['ThumbmarkPicture'] != "") { ?>
                        <img src="../uploads/<?php echo $row['ThumbmarkPicture']; ?>" class="sig-img">
                    <?php } ?>
                </td>
            </tr>
        </table>

        <div class="footer">
            <div class="footer-sig">
                <div class="footer-line" style="text-transform: uppercase;"><?php echo $row['FirstName']; ?> <?php echo $row['MiddleName']; ?> <?php echo $row['LastName']; ?></div>
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
</script>
</body>
</html>