<?php
include("../includes/db_connection.php");

// Handle Login Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect ID as string to preserve leading zeros (e.g., 00123)
    $id = mysqli_real_escape_string($conn, $_POST['login_osca']);
    
    // Check if ID exists in the database
    $res = mysqli_query($conn, "SELECT OscaIDNo FROM seniors WHERE OscaIDNo = '$id'");
    
    if (mysqli_num_rows($res) > 0) {
        // Redirect to profile page
        header("Location: profile.php?id=$id");
        exit;
    } else {
        // Use a simple alert if ID is not found
        echo "<script>alert('Error: OscaIDNo. $id not found in our records.'); window.location='login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login | SENIOR-CARE</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Style -->
   <link rel="stylesheet" href="css/userStyle.css">
</head>
<body>

    <!-- Simple Navigation Bar -->
    <div class="navbar-custom">
        SENIOR-CARE MANAGEMENT SYSTEM
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                
                <!-- Centered Login Card -->
                <div class="card p-4 shadow">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold" style="color: var(--forest-deep);">Senior Citizen Login</h4>
                        <p class="text-muted small">Enter your ID to view your profile and QR code.</p>
                    </div>

                    <form action="login.php" method="POST">
                        <div class="mb-4">
                            <label class="fw-bold small mb-2">OscaIDNo.</label>
                            <input type="text" 
                                   name="login_osca" 
                                   class="form-control form-control-lg" 
                                   placeholder="Digits only (e.g. 001)" 
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                                   required>
                        </div>

                        <button type="submit" class="btn btn-forest w-100 py-2 mb-3">
                            VIEW PROFILE & QR
                        </button>

                        <div class="text-center mt-2 border-top pt-3">
                            <p class="small text-muted mb-0">No account yet?</p>
                            <a href="register.php" class="text-success small fw-bold text-decoration-none">
                                Click here to register profiling
                            </a>
                        </div>
                    </form>
                    <!-- Find the end of your form and add this before the </div> of the card -->
                    <div class="text-center mt-3 pt-3 border-top">
                        <p class="small text-muted mb-2">Staff or Administrator?</p>
                        <a href="../admin/login.php" class="btn btn-outline-dark btn-sm w-100 py-2 shadow-sm">
                            <i class="fa-solid fa-user-shield me-2"></i> GO TO ADMIN LOGIN
                        </a>
                        </div>
                </div>

                <!-- Simple Footer Note -->
                <div class="text-center mt-4 opacity-50">
                    <small>Barangay Kalawag 1 Management System</small>
                </div>

            </div>
        </div>
    </div>

</body>
</html>