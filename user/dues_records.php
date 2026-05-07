<?php
include("../includes/db_connection.php");
$id = $_GET['id'];

$q_admin = mysqli_query($conn, "SELECT ContactNumber FROM admin_users WHERE AdminID=1");
$row_admin = mysqli_fetch_array($q_admin);
$admin_contact = $row_admin['ContactNumber'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dues Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/userStyle.css">
</head>
<body>

<div class="navbar-custom no-print d-flex flex-column text-center" style="height: auto; padding: 15px 0;">
    <div>SENIOR-CARE PORTAL</div>
    <div style="font-size: 0.85rem; font-weight: normal; margin-top: 5px; opacity: 0.9;">Admin Contact: <?php echo $admin_contact; ?></div>
</div>

<div class="container py-4 main-container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-dark fw-bold d-flex justify-content-between align-items-center py-3">
            <span>Monthly Dues Payment History</span>
            <a href="profile.php?id=<?php echo $id; ?>" class="btn btn-light btn-sm fw-bold border border-dark">Back to Profile</a>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                
                <table class="table table-bordered table-hover align-middle" id="datatablesSimple" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th>Date Paid</th>
                            <th>Time Paid</th>
                            <th>Contribution Name</th>
                            <th>Amount Paid</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <!-- Replace the <tbody> section in your existing user/dues_records.php with this -->
<tbody>
    <?php
        // Complex query to get required amount and cumulative sums for calculating the balance
        $clem = mysqli_query($conn, "
            SELECT dp.PaymentID, dp.Amount_Paid, dp.Date_Paid, dp.Time_Paid, dp.Payment_Status,
                   m.Contribution_Name, m.Amount_Required,
                   (SELECT SUM(dp2.Amount_Paid) 
                    FROM dues_payments dp2 
                    WHERE dp2.OscaIDNo = dp.OscaIDNo 
                    AND dp2.DuesID = dp.DuesID 
                    AND dp2.PaymentID <= dp.PaymentID) as cumulative_paid
            FROM dues_payments dp 
            LEFT JOIN monthly_dues_master m ON dp.DuesID = m.DuesID 
            WHERE dp.OscaIDNo = '$id' 
            ORDER BY dp.Date_Paid DESC, dp.Time_Paid DESC
        ");

        while($display = mysqli_fetch_array($clem)){
            // The display formula
            $remaining_balance = $display['Amount_Required'] - $display['cumulative_paid'];
            $remaining_balance = ($remaining_balance < 0) ? 0 : $remaining_balance; // Prevent negatives
    ?>
    <tr>
        <td class="text-secondary"><?php echo $display['Date_Paid']; ?></td>
        <td><?php echo date("h:i A", strtotime($display['Time_Paid'])); ?></td>
        <td class="fw-bold"><?php echo $display['Contribution_Name']; ?></td>
        <td class="text-success fw-bold">+ ₱<?php echo number_format($display['Amount_Paid'], 2); ?></td>
        
        <!-- REMAINING BALANCE CALCULATION -->
        <td class="text-danger fw-bold">₱<?php echo number_format($remaining_balance, 2); ?></td>
        
        <td>
            <?php if($display['Payment_Status'] == 'Paid'): ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<!-- USING YOUR NEW JS FILE -->
<script src="js/datatables-simple-demo.js"></script>
</body>
</html>