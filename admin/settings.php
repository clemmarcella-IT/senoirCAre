<?php 
require_once('includes/session.php'); 

$admin_id = $_SESSION['admin_id'];

if(isset($_POST['update_settings'])) {
    $new_osca = mysqli_real_escape_string($conn, $_POST['admin_osca']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['admin_pass']);
    $new_phone = mysqli_real_escape_string($conn, $_POST['admin_phone']);

    $update = mysqli_query($conn, "UPDATE admin_users SET AdminOscaID='$new_osca', Password='$new_pass', ContactNumber='$new_phone' WHERE AdminID='$admin_id'");
    
    if($update) {
        $_SESSION['admin_osca'] = $new_osca;
        echo "<script>alert('Admin Settings Updated Successfully!'); window.location='settings.php';</script>";
    } else {
        echo "<script>alert('Error updating settings.');</script>";
    }
}

$q = mysqli_query($conn, "SELECT * FROM admin_users WHERE AdminID='$admin_id'");
$adminData = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="d-flex bg-light">
    
    <?php include('includes/sidebar.php'); ?>

    <div class="flex-grow-1 p-4">
        <h2 class="fw-bold" style="color: #1F4B2C;"><i class="fa fa-user-cog me-2"></i> Admin Security Settings</h2>
        <hr>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header text-white fw-bold" style="background-color: #1F4B2C;">
                        Update Credentials & OTP Number
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="fw-bold small text-muted">Admin OscaID (Login ID)</label>
                                <!-- RESTRICTED TO NUMBERS ONLY -->
                                <input type="text" name="admin_osca" class="form-control" 
                                       value="<?php echo $adminData['AdminOscaID']; ?>" 
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold small text-muted">Admin Password</label>
                                <input type="text" name="admin_pass" class="form-control" value="<?php echo $adminData['Password']; ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="fw-bold small text-muted"><i class="fa fa-mobile-screen text-warning"></i> Phone Number (For OTP Recovery)</label>
                                <input type="text" name="admin_phone" class="form-control" value="<?php echo $adminData['ContactNumber']; ?>" placeholder="e.g. 09123456789" required>
                            </div>
                            
                            <button type="submit" name="update_settings" class="btn w-100 fw-bold" style="background-color: #1F4B2C; color: white;">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="alert alert-info border-0 shadow-sm">
                    <h5><i class="fa fa-info-circle"></i> Security Notice</h5>
                    <p class="small text-muted mb-0">Please ensure your contact number is active. If you lose your password and do not have access to this mobile number, you will be locked out of the Admin Panel.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>