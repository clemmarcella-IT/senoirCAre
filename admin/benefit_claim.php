<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>New Benefit Claim | SENIOR-CARE</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 38px;
            border: 1px solid rgba(0, 0, 0, 0.35);
            border-radius: 0.75rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            padding: 4px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mt-4 mb-4">
                <div>
                    <h3 class="fw-bold text-success m-0">New Benefit Claim</h3>
                    <p class="text-muted mb-0">Scan the senior's QR code, then enter reason and amount released.</p>
                </div>
                <div class="no-print d-flex flex-column flex-sm-row gap-2">
                    <a href="benefits.php" class="btn btn-secondary fw-bold shadow-sm w-100 w-sm-auto py-2">Back</a>
                </div>
            </div>

            <form id="benefitScannerForm" action="query_record_benefit_claim.php" method="POST">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card p-3 shadow-sm border-0">
                            <div id="reader"></div>
                            <div class="mt-3">
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted">Osca ID</label>
                                    <input type="text" name="oscaID" id="scanned_id" class="form-control text-center font-weight-bold text-primary" readonly placeholder="Waiting for Scan">
                                </div>
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted">Or Select Manually</label>
                                    <select id="manualSeniorSelect" class="form-select select2-senior">
                                        <option value="">Search by ID or Name...</option>
                                        <?php
                                        $senior_q = mysqli_query($conn, "SELECT OscaIDNo, LastName, FirstName FROM seniors ORDER BY LastName ASC");
                                        while ($s = mysqli_fetch_array($senior_q)) {
                                        ?>
                                            <option value="<?php echo $s['OscaIDNo']; ?>">
                                                <?php echo $s['OscaIDNo'] . " - " . $s['LastName'] . ", " . $s['FirstName']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <button type="submit" id="submitBtn" class="btn btn-success fw-bold shadow-sm w-100 py-2" disabled>Save Benefit Claim</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 mb-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-success text-white fw-bold">Claim Details</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted">Senior Name</label>
                                    <input type="text" id="scanned_name" class="form-control card shadow border border-1 border-black" readonly placeholder="Scan QR to load senior name">
                                </div>
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted">Reason</label>
                                    <input type="text" name="reason" id="reason" class="form-control card shadow border border-1 border-black" placeholder="e.g. Medical Emergency" required>
                                </div>
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted">Amount Released (₱)</label>
                                    <input type="number" step="0.01" name="amount" id="amount" class="form-control card shadow border border-1 border-black" placeholder="Enter amount" required>
                                </div>
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted">Claim Date</label>
                                    <input type="date" name="date" id="claim_date" class="form-control card shadow border border-1 border-black" value="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/qr_scanner_logic.js?v=<?php echo time(); ?>"></script>
    <script>
        startScanner();
        $(document).ready(function() {
            $('.select2-senior').select2({
                placeholder: "Search by ID or Name...",
                allowClear: true,
                width: '100%'
            });
            $('#manualSeniorSelect').on('change', function() {
                var selectedId = $(this).val();
                if (selectedId) {
                    onScanSuccess(selectedId, null);
                }
            });
        });
    </script>
</body>
</html>
