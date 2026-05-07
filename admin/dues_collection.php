<?php 
require_once('includes/session.php'); 
$did = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM monthly_dues_master WHERE DuesID = '$did'");
$dues = mysqli_fetch_array($res);

if (!$dues) {
    echo "<script>alert('Dues record not found.'); window.location='monthly_dues.php';</script>";
    exit;
}
$amount_required = $dues['Amount_Required'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Installment Collection | <?php echo $dues['Contribution_Name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-4 mb-4 gap-3">
                <div>
                    <h3 class="fw-bold text-success m-0">Collection: <?php echo $dues['Contribution_Name']; ?></h3>
                    <p class="text-muted mb-1">Target Due: ₱<?php echo number_format($amount_required, 2); ?> | <span class="text-danger fw-bold">Active Status requires full payment.</span></p>
                </div>
                <div class="no-print d-flex gap-2">
                    <a href="monthly_dues.php" class="btn btn-secondary shadow-sm">Back</a>
                </div>
            </div>

            <div class="row">
                <!-- LEFT SIDE: MANUAL ENTRY FORM -->
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-primary text-white fw-bold">Receive Payment</div>
                        <div class="card-body p-4">
                            <form action="query_record_payment.php" method="POST">
                                <input type="hidden" name="dues_id" value="<?php echo $did; ?>">
                                
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted mb-1">Search Senior (Name / OSCA ID)</label>
                                    <select name="oscaID" id="oscaID_select" class="form-select border-black shadow-sm" onchange="updateBalance()" required>
                                        <option value="" selected disabled>-- Select Senior --</option>
                                        <?php
                                        // Fetch seniors who have NOT fully paid yet (Cumulative Check)
                                        $sen_q = mysqli_query($conn, "
                                            SELECT s.OscaIDNo, s.FirstName, s.LastName, 
                                                   COALESCE(SUM(dp.Amount_Paid), 0) as total_paid
                                            FROM seniors s
                                            LEFT JOIN dues_payments dp ON s.OscaIDNo = dp.OscaIDNo AND dp.DuesID = '$did'
                                            GROUP BY s.OscaIDNo
                                            HAVING total_paid < $amount_required
                                            ORDER BY s.LastName ASC
                                        ");
                                        while($s = mysqli_fetch_array($sen_q)){
                                            echo "<option value='".$s['OscaIDNo']."'>".$s['LastName'].", ".$s['FirstName']." (ID: ".$s['OscaIDNo'].")</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="small fw-bold text-muted mb-1">Amount Received (₱)</label>
                                    <input type="number" step="0.01" min="1" name="amount" id="amount_input" class="form-control border-black shadow-sm" placeholder="Enter amount..." required>
                                    <small class="text-danger fw-bold" id="balance_display">Select a senior to view balance.</small>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mt-2">
                                    RECORD PAYMENT
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE: PAYMENT LIST -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white font-weight-bold">Transaction History (Partials & Full)</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatablesSimple" class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>OscaIDNo.</th>
                                            <th>Senior Name</th>
                                            <th>Date Paid</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $list = mysqli_query($conn, "SELECT dp.*, s.FirstName, s.LastName 
                                                                    FROM dues_payments dp 
                                                                    INNER JOIN seniors s ON s.OscaIDNo = dp.OscaIDNo 
                                                                    WHERE dp.DuesID = '$did'
                                                                    ORDER BY dp.Date_Paid DESC, dp.Time_Paid DESC");
                                        while($display = mysqli_fetch_array($list)){
                                        ?>
                                        <tr>
                                            <td class="fw-bold text-primary"><?php echo $display['OscaIDNo']; ?></td>
                                            <td class="fw-bold"><?php echo $display['LastName'].", ".$display['FirstName']; ?></td>
                                            <td><?php echo date("M d, Y", strtotime($display['Date_Paid'])) . " | " . date("h:i A", strtotime($display['Time_Paid'])); ?></td>
                                            <td class="fw-bold">₱<?php echo number_format($display['Amount_Paid'], 2); ?></td>
                                            <td>
                                                <?php if($display['Payment_Status'] == 'Paid'): ?>
                                                    <span class="badge bg-success">PAID (CLEARED)</span>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
<script src="js/datatables-simple-demo.js"></script>
<script src="js/scripts.js"></script>

<!-- DYNAMIC BALANCE JAVASCRIPT -->
<script>
    // Load remaining balances into a JS object
    const balances = {
        <?php
        mysqli_data_seek($sen_q, 0); // Reset pointer
        while($s = mysqli_fetch_assoc($sen_q)) {
            $remaining = $amount_required - $s['total_paid'];
            echo "'".$s['OscaIDNo']."': ".$remaining.",";
        }
        ?>
    };

    function updateBalance() {
        const oscaID = document.getElementById('oscaID_select').value;
        const amountInput = document.getElementById('amount_input');
        const balanceDisplay = document.getElementById('balance_display');
        
        if(balances[oscaID]) {
            // Set max payable and suggest the full remaining balance
            amountInput.value = balances[oscaID];
            amountInput.max = balances[oscaID];
            balanceDisplay.innerHTML = "Remaining Balance: ₱" + balances[oscaID].toFixed(2);
        }
    }
</script>
</body>
</html>