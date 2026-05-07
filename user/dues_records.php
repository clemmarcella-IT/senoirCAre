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
                    <tbody>
                        <?php
                            $clem = mysqli_query($conn, "SELECT monthly_dues_master.Contribution_Name, dues_payments.Amount_Paid, dues_payments.Date_Paid, dues_payments.Time_Paid, dues_payments.Payment_Status 
                                                         FROM dues_payments 
                                                         LEFT JOIN monthly_dues_master ON dues_payments.DuesID = monthly_dues_master.DuesID 
                                                         WHERE dues_payments.OscaIDNo = '$id' 
                                                         ORDER BY dues_payments.Date_Paid DESC");

                            while($display = mysqli_fetch_array($clem)){
                        ?>
                        <tr>
                            <td><?php echo $display['Date_Paid']; ?></td>
                            <td><?php echo date("h:i A", strtotime($display['Time_Paid'])); ?></td>
                            <td class="fw-bold"><?php echo $display['Contribution_Name']; ?></td>
                            <td class="text-success fw-bold">₱<?php echo number_format($display['Amount_Paid'], 2); ?></td>
                            <td><span class="badge bg-warning text-dark"><?php echo $display['Payment_Status']; ?></span></td>
                        </tr>
                        <?php
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