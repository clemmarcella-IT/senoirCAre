<?php 
require_once('includes/session.php'); 
$did = $_GET['id'];

// Get Dues Details
$res = mysqli_query($conn, "SELECT * FROM monthly_dues_master WHERE DuesID = '$did'");
$dues = mysqli_fetch_array($res);
if (!$dues) {
    echo "<script>alert('Dues not found.'); window.location='monthly_dues.php';</script>";
    exit;
}
$amount_required = $dues['Amount_Required'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Dues Collection | <?php echo $dues['Contribution_Name']; ?></title>
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
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-4 mb-4 gap-3">
                <div>
                    <h3 class="fw-bold text-success m-0"><?php echo $dues['Contribution_Name']; ?></h3>
                    <p class="text-muted mb-1">Required Amount: ₱<?php echo number_format($amount_required, 2); ?> | Due: <?php echo date("M d, Y", strtotime($dues['Due_Date'])); ?></p>
                </div>
                <div class="no-print d-flex flex-column flex-sm-row gap-2">
                    <a href="monthly_dues.php" class="btn btn-secondary fw-bold shadow-sm w-100">Back</a>
                    <button type="button" class="btn btn-success fw-bold shadow-sm w-100" onclick="printTable()">
                        <i class="fa fa-print me-2"></i> Print Report
                    </button>
                </div>
            </div>

            <div class="row">
                <!-- LEFT: PAYMENT FORM -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-success text-white fw-bold">Record Office Payment</div>
                        <div class="card-body">
                            <form action="query_collect_dues.php" method="POST">
                                <input type="hidden" name="dues_id" value="<?php echo $did; ?>">
                                <input type="hidden" name="amount_required" value="<?php echo $amount_required; ?>">
                                
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted mb-1">Select Senior</label>
                                    <select name="osca_id" class="form-select select2-senior" required>
                                        <option value="">Search by ID or Name...</option>
                                        <?php
                                        // Finds seniors who haven't fully paid. If fully paid, it's removed from selection.
                                        $senior_q = mysqli_query($conn, "
                                            SELECT s.OscaIDNo, s.LastName, s.FirstName,
                                            COALESCE((SELECT SUM(Amount_Paid) FROM dues_payments dp WHERE dp.OscaIDNo = s.OscaIDNo AND dp.DuesID = '$did'), 0) as total_paid
                                            FROM seniors s
                                            HAVING total_paid < $amount_required
                                            ORDER BY s.LastName ASC
                                        ");
                                        while ($s = mysqli_fetch_array($senior_q)) {
                                            $balance = $amount_required - $s['total_paid'];
                                        ?>
                                            <option value="<?php echo $s['OscaIDNo']; ?>">
                                                <?php echo $s['OscaIDNo'] . " - " . $s['LastName'] . ", " . $s['FirstName'] . " (Bal: ₱" . number_format($balance, 2) . ")"; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="small fw-bold text-muted mb-1">Amount Paid (₱)</label>
                                    <input type="number" step="0.01" name="amount_paid" class="form-control card shadow border border-1 border-black" required>
                                </div>

                                <button type="submit" class="btn btn-success w-100 py-2 fw-bold">RECORD PAYMENT & ACTIVATE</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: COLLECTION RECORDS -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white fw-bold">Recent Collections</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatablesSimple" class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>OscaIDNo.</th>
                                            <th>Senior Name</th>
                                            <th>Total Paid</th>
                                            <th>Last Payment Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // UPDATED LOGIC: Group by senior and sum the total payments to avoid duplication
                                        $list = mysqli_query($conn, "
                                            SELECT dp.OscaIDNo, s.LastName, s.FirstName, 
                                                   SUM(dp.Amount_Paid) as Total_Paid, 
                                                   MAX(dp.Date_Paid) as Last_Date_Paid,
                                                   MAX(dp.Time_Paid) as Last_Time_Paid
                                            FROM dues_payments dp
                                            JOIN seniors s ON dp.OscaIDNo = s.OscaIDNo
                                            WHERE dp.DuesID = '$did'
                                            GROUP BY dp.OscaIDNo, s.LastName, s.FirstName
                                            ORDER BY Last_Date_Paid DESC, Last_Time_Paid DESC
                                        ");
                                        while ($row = mysqli_fetch_array($list)) {
                                            $total_paid = $row['Total_Paid'];
                                        ?>
                                            <tr>
                                                <td class="fw-bold"><?php echo $row['OscaIDNo']; ?></td>
                                                <td><?php echo $row['LastName'] . ", " . $row['FirstName']; ?></td>
                                                <td class="text-success fw-bold">₱<?php echo number_format($total_paid, 2); ?></td>
                                                <td><?php echo date("M d, Y", strtotime($row['Last_Date_Paid'])) . " " . date("h:i A", strtotime($row['Last_Time_Paid'])); ?></td>
                                                <td>
                                                    <?php if($total_paid >= $amount_required): ?>
                                                        <span class="badge bg-success">CLEARED</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning text-dark">PARTIAL</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="js/scripts.js"></script>
    <script>
        $(document).ready(function() {
            // Apply select2 dropdown for easy finding
            $('.select2-senior').select2({
                placeholder: "Search by ID or Name...",
                allowClear: true,
                width: '100%'
            });
        });

        
    function printTable() {
        var table = document.getElementById("datatablesSimple");
        var newWindow = window.open("", "", "width=900,height=800");
        newWindow.document.write("<html><head><title>Dues Collection Report</title>");
        newWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">');
        newWindow.document.write("<style>body{padding:40px;font-family:sans-serif;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:10px;text-align:left;}th{background:#1F4B2C!important;color:white!important;text-transform:uppercase;font-size:12px;}</style>");
        newWindow.document.write("</head><body>");
        newWindow.document.write("<div style='text-align:center;border-bottom:2px solid #1F4B2C;padding-bottom:10px;margin-bottom:20px;'><h2><?php echo $dues['Contribution_Name']; ?> - Dues Collection Report</h2><p style='margin:0;'>Required Amount: ₱<?php echo number_format($amount_required, 2); ?> | Due Date: <?php echo date('M d, Y', strtotime($dues['Due_Date'])); ?></p></div>");
        if (table) {
            var tableClone = table.cloneNode(true);
            newWindow.document.write(tableClone.outerHTML);
        } else {
            newWindow.document.write('<p style="text-align:center;margin-top:30px;">No data found.</p>');
        }
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        setTimeout(function() { newWindow.print(); newWindow.close(); }, 750);
    }
   
    </script>
</body>
</html>