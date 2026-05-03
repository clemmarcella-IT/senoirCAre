<?php 
include("../includes/db_connection.php");
require_once('includes/session.php'); 

if (!isset($_GET['id'])) { 
    header("Location: profiling.php"); 
    exit; 
}

$id = $_GET['id']; 

$query = mysqli_query($conn, "SELECT seniors.* 
                              FROM seniors 
                              WHERE seniors.OscaIDNo = '$id'");
$data = mysqli_fetch_array($query);

if (!$data) {
    echo "<script>alert('Record not found.'); window.location='profiling.php';</script>";
    exit;
}

// Simple age calculation from Birthday
$birthYear  = date("Y", strtotime($data['Birthday']));
$birthMonth = date("m", strtotime($data['Birthday']));
$birthDay   = date("d", strtotime($data['Birthday']));

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
    <title>Citizen Profile | <?php echo $id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h2 class="fw-bold text-success"><i class="fa fa-address-card me-2"></i> Citizen Full Record</h2>
            <a href="profiling.php" class="btn btn-outline-dark"><i class="fa fa-arrow-left"></i> Back to Master List</a>
        </div>

        <div class="card shadow border-0" id="printArea">
            <div class="row g-0">
                <div class="col-md-4 bg-dark text-white text-center p-5 id-side">
                    <img src="../uploads/<?php echo $data['Picture']; ?>" class="display-pic rounded-circle shadow mb-4 border border-3 border-success" style="width:160px; height:160px; object-fit:cover;">
                    <h3 class="text-uppercase fw-bold"><?php echo $data['FirstName']; ?></h3>
                    <p class="small opacity-75 mb-4">OscaIDNo. <?php echo $data['OscaIDNo']; ?></p>
                    
                    <div class="bg-white p-3 rounded d-inline-block shadow-sm" style="min-width: 150px; min-height: 150px;">
                        <div id="qrcode-target"></div>
                    </div>
                </div>

                <div class="col-md-8 p-5 bg-white data-side">
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-4">
                        <h4 class="fw-bold text-success">Personal Data</h4>
                        <?php $statusClass = ($data['CitizenStatus'] == 'inactive') ? 'bg-danger' : 'bg-success'; ?>
                        <span class="badge <?php echo $statusClass; ?> fs-6 text-uppercase"><?php echo $data['CitizenStatus']; ?></span>
                    </div>

                   <div class="row mb-4 g-3">
                        <div class="col-12">
                            <label class="label-tag text-muted small fw-bold">OscaIDNo. (Primary ID)</label>
                            <div class="data-box fs-5 fw-bold text-primary"><?php echo $data['OscaIDNo']; ?>
                        </div>
                    </div>
                        <div class="col-12">
                            <label class="label-tag text-muted small fw-bold">FULL LEGAL NAME</label>
                            <div class="data-box fs-5 fw-bold text-uppercase"><?php echo $data['LastName'].", ".$data['FirstName']." ".$data['MiddleName']; ?>
                        </div>
                    </div>
                        <div class="col-4">
                            <label class="label-tag text-muted small fw-bold">SEX</label>
                            <div class="data-box"><?php echo $data['Sex']; ?>
                        </div>
                    </div>
                        <div class="col-4">
                            <label class="label-tag text-muted small fw-bold">DERIVED AGE</label>
                            <div class="data-box text-success fw-bold"><?php echo $age; ?> Years Old</div>
                        </div>
                        <div class="col-4">
                            <label class="label-tag text-muted small fw-bold">BIRTHDAY</label>
                            <div class="data-box"><?php echo date("F d, Y", strtotime($data['Birthday'])); ?></div>
                        </div>
                        <div class="col-6">
                            <label class="label-tag text-muted small fw-bold">PUROK / ZONE</label>
                            <div class="data-box"><?php echo $data['Purok']; ?></div>
                        </div>
                        <div class="col-6">
                            <label class="label-tag text-muted small fw-bold">BARANGAY</label>
                            <div class="data-box"><?php echo $data['Barangay']; ?></div>
                        </div>
                        <div class="col-12">
                            <label class="label-tag text-muted small fw-bold">REGISTRATION TIMESTAMP</label>
                            <div class="data-box small text-muted"><?php echo date("F d, Y h:i A", strtotime($data['GenerateDate'])); ?></div>
                        </div>
                    </div>


                    <h5 class="fw-bold border-bottom pb-2 mb-3 mt-5 text-success">Documentary Verifications</h5>
                    <div class="row g-3 text-center no-print">
                        <div class="col-6">
                            <label class="small text-muted fw-bold mb-2">SIGNATURE (Click to view)</label>
                            <div class="d-flex justify-content-center">
                                <?php if (!empty($data['SignaturePicture'])) { ?>
                                    <img src="../uploads/<?php echo $data['SignaturePicture']; ?>" class="doc-img rounded" style="width: 90px !important; height: 90px !important; object-fit: contain !important; background-color: #f8f9fa; border: 1px solid #ccc;" onclick="viewImage(this)">
                                <?php } else { ?>
                                    <div style="width: 90px; height: 90px; background-color: #f8f9fa; border: 1px solid #ccc; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #999; font-size: 12px;">No Signature</div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted fw-bold mb-2">THUMBMARK (Click to view)</label>
                            <div class="d-flex justify-content-center">
                                <?php if (!empty($data['ThumbmarkPicture'])) { ?>
                                    <img src="../uploads/<?php echo $data['ThumbmarkPicture']; ?>" class="doc-img rounded" style="width: 90px !important; height: 90px !important; object-fit: contain !important; background-color: #f8f9fa; border: 1px solid #ccc;" onclick="viewImage(this)">
                                <?php } else { ?>
                                    <div style="width: 90px; height: 90px; background-color: #f8f9fa; border: 1px solid #ccc; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #999; font-size: 12px;">No Thumbmark</div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 no-print text-end">
                        <button onclick="printQRCodeOnly()" class="btn btn-outline-dark fw-bold px-4 py-2 me-2">
                            <i class="fa fa-qrcode me-2"></i> Print QR Only
                        </button>
                        <button onclick="printCitizenRecord()" class="btn btn-success fw-bold px-4 py-2">
                            <i class="fa fa-print me-2"></i> Print Official Record
                        </button>
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
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="js/scripts.js"></script>
    <!-- CORRECT LINK TO ADMIN JS -->
    <script src="js/UserQRGenerate.js"></script>
    
    <script>
        window.onload = function() {
            // Using the standardized function
            renderProfileQR("<?php echo $id; ?>");
        };

        function viewImage(imgElement) {
            document.getElementById('modalPreviewImage').src = imgElement.src;
            var myModal = new bootstrap.Modal(document.getElementById('imageViewerModal'));
            myModal.show();
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
                            <div class="value-line"><?php echo $data['LastName']; ?></div>
                        </div>
                        <div class="field-row">
                            <div class="label"><span>GIVEN NAME/Pangalan</span><span>:</span></div>
                            <div class="value-line"><?php echo $data['FirstName']; ?></div>
                        </div>
                        <div class="field-row">
                            <div class="label"><span>MIDDLE NAME/Gitnang Apelyido</span><span>:</span></div>
                            <div class="value-line"><?php echo $data['MiddleName']; ?></div>
                        </div>
                        <div class="field-row">
                            <div class="label"><span>ADDRESS/Tirahan</span><span>:</span></div>
                            <div class="value-line"><?php echo $data['Purok'].", ".$data['Barangay']; ?></div>
                        </div>
                        
                        <div class="field-row">
                            <div class="label"><span>BIRTHDAY/Petsa ng Kapanganakan</span><span>:</span></div>
                            <div class="value-line" style="flex: 0.6;"><?php echo date("M d, Y", strtotime($data['Birthday'])); ?></div>
                            <div style="font-size: 14px; margin-left: 15px; margin-right: 5px;">AGE/Edad:</div>
                            <div class="value-line" style="flex: 0.3;"><?php echo $age; ?></div>
                        </div>
                        
                        <div class="field-row" style="align-items: center; margin-top: 5px;">
                            <div class="label"><span>SEX/Kasarian</span><span>:</span></div>
                            <div style="flex: 1; display:flex; gap: 30px; margin-left: 10px;">
                                <div class="checkbox-container">
                                    <div class="checkbox"><?php echo ($data['Sex'] == 'Male') ? '&#10003;' : ''; ?></div>
                                    <span>Male</span>
                                </div>
                                <div class="checkbox-container">
                                    <div class="checkbox"><?php echo ($data['Sex'] == 'Female') ? '&#10003;' : ''; ?></div>
                                    <span>Female</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- RIGHT SIDE: Picture Box -->
                    <div class="picture-box">
                        <div class="inner-pic-box">
                            <?php if (!empty($data['Picture'])) { ?>
                                <img src="../uploads/<?php echo $data['Picture']; ?>">
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
                            <?php if (!empty($data['SignaturePicture'])) { ?>
                                <img src="../uploads/<?php echo $data['SignaturePicture']; ?>" class="sig-img">
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (!empty($data['ThumbmarkPicture'])) { ?>
                                <img src="../uploads/<?php echo $data['ThumbmarkPicture']; ?>" class="sig-img">
                            <?php } ?>
                        </td>
                    </tr>
                    <!-- ROW 2 (Duplicate Signature) -->
                    <tr>
                        <td>
                            <?php if (!empty($data['SignaturePicture'])) { ?>
                                <img src="../uploads/<?php echo $data['SignaturePicture']; ?>" class="sig-img">
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (!empty($data['ThumbmarkPicture'])) { ?>
                                <img src="../uploads/<?php echo $data['ThumbmarkPicture']; ?>" class="sig-img">
                            <?php } ?>
                        </td>
                    </tr>
                    <!-- ROW 3 (Duplicate Signature) -->
                    <tr>
                        <td>
                            <?php if (!empty($data['SignaturePicture'])) { ?>
                                <img src="../uploads/<?php echo $data['SignaturePicture']; ?>" class="sig-img">
                            <?php } ?>
                        </td>
                        <td>
                            <?php if (!empty($data['ThumbmarkPicture'])) { ?>
                                <img src="../uploads/<?php echo $data['ThumbmarkPicture']; ?>" class="sig-img">
                            <?php } ?>
                        </td>
                    </tr>
                </table>

                <!-- FOOTER -->
                <div class="footer">
                    <div class="footer-sig">
                        <div class="footer-line" style="text-transform: uppercase;"><?php echo $data['FirstName'] . " " . $data['MiddleName'] . " " . $data['LastName']; ?></div>
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

        function printQRCodeOnly() {
            const qrContainer = document.getElementById("qrcode-target");
            const qrContent = qrContainer.innerHTML;

            if (!qrContent || qrContent.trim() === "") {
                alert("QR Code is still generating. Please wait.");
                return;
            }

            const newWindow = window.open("", "", "width=800,height=800");
            newWindow.document.write(`
                <html>
                <head>
                    <title>Print QR</title>
                    <style>
                        body { margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
                        #qr-wrapper { text-align: center; }
                        img, canvas { display: block; margin: 0 auto; }
                    </style>
                </head>
                <body>
                    <div id="qr-wrapper">${qrContent}</div>
                    <script>
                        window.onload = function() {
                            setTimeout(function() { window.print(); window.close(); }, 500);
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