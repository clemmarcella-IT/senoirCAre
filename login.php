<?php
require_once('include.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['login_osca']);
    $res = mysqli_query($conn, "SELECT OscaIDNo FROM seniors WHERE OscaIDNo = '$id'");
    if (mysqli_num_rows($res) > 0) { header("Location: profile.php?id=$id"); exit; }
    else { echo "<script>alert('OscaIDNo. Not Found!');</script>"; }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login | SENIOR-CARE</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="userStyle.css"></head>
<body>
    <div class="navbar-custom">SENIOR-CARE MANAGEMENT SYSTEM</div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4">
                    <h4 class="text-center fw-bold mb-4" style="color: var(--forest-deep);">Senior Login</h4>
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label class="fw-bold small">OscaIDNo.</label>
                            <input type="text" name="login_osca" class="form-control" placeholder="Enter ID Number" required>
                        </div>
                        <button class="btn btn-forest w-100 mb-3 py-2">VIEW PROFILE</button>
                        <div class="text-center"><a href="register.php" class="text-success small fw-bold text-decoration-none">No profile? Register here</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>