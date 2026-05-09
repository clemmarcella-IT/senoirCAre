<?php
session_start();
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
                            <th>Contribution Name</th>
                            <th>Amount Paid</th>
                            <th>Status</th>
                        </tr>
                    </thead>
<tbody>
    <?php
        $clem = mysqli_query($conn, "
            SELECT dp.DuesID, m.Contribution_Name, m.Amount_Required,
                   SUM(dp.Amount_Paid) as Total_Paid,
                   MAX(dp.Date_Paid) as Latest_Date_Paid,
                   CASE 
                       WHEN SUM(dp.Amount_Paid) >= m.Amount_Required THEN 'Paid'
                       ELSE 'Partial'
                   END as Payment_Status
            FROM dues_payments dp 
            LEFT JOIN monthly_dues_master m ON dp.DuesID = m.DuesID 
            WHERE dp.OscaIDNo = '$id' AND dp.Payment_Status IN ('Partial', 'Paid')
            GROUP BY dp.DuesID, m.Contribution_Name, m.Amount_Required
            ORDER BY Latest_Date_Paid DESC
        ");

        if (!$clem) {
            echo '<tr><td colspan="4" class="text-center text-danger">Error loading dues records</td></tr>';
        } else {
            while($display = mysqli_fetch_array($clem)){
    ?>
    <tr>
        <td class="text-secondary"><?php echo date('M d, Y', strtotime($display['Latest_Date_Paid'])); ?></td>
        <td class="fw-bold"><?php echo $display['Contribution_Name']; ?></td>
        <td class="text-success fw-bold">₱<?php echo number_format($display['Total_Paid'], 2); ?></td>
        
        <td>
            <?php if($display['Payment_Status'] == 'Paid'): ?>
                <span class="badge bg-success">CLEARED</span>
            <?php else: ?>
                <span class="badge bg-warning text-dark">PARTIAL</span>
            <?php endif; ?>
        </td>
    </tr>
    <?php 
            }
        }
    ?>
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