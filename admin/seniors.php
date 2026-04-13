<?php require_once('includes/session.php'); 

// Delete Logic
if(isset($_GET['delete'])) {
    $del = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM seniors WHERE OscaIDNo='$del'");
    header("Location: seniors.php");
}
// Status Update Logic
if(isset($_POST['update_status'])) {
    $id = $_POST['id']; $stat = $_POST['status'];
    mysqli_query($conn, "UPDATE seniors SET CitezenStatus='$stat' WHERE OscaIDNo='$id'");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Seniors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
</head>
<body class="d-flex">
    <?php include('includes/sidebar.php'); ?>

    <div class="flex-grow-1 p-4 bg-light">
        <h2>Senior Citizen Master List</h2>
        <div class="card mt-4">
            <div class="card-body">
                <table id="seniorTable" class="table table-bordered">
                    <thead class="table-dark">
                        <tr><th>OscaID</th><th>Name</th><th>Barangay</th><th>Birthday</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $q = mysqli_query($conn, "SELECT * FROM seniors");
                        while($row = mysqli_fetch_assoc($q)): ?>
                        <tr>
                            <td><?php echo $row['OscaIDNo']; ?></td>
                            <td><?php echo $row['LastName'].', '.$row['FirstName']; ?></td>
                            <td><?php echo $row['Barangay']; ?></td>
                            <td><?php echo $row['Birthday']; ?></td>
                            <td>
                                <form method="POST" class="d-flex gap-2">
                                    <input type="hidden" name="id" value="<?php echo $row['OscaIDNo']; ?>">
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option <?php if($row['CitezenStatus']=='active') echo 'selected'; ?>>active</option>
                                        <option <?php if($row['CitezenStatus']=='inactive') echo 'selected'; ?>>inactive</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                            <td>
                                <a href="../user/profile.php?id=<?php echo $row['OscaIDNo']; ?>" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-eye"></i> View</a>
                                <a href="seniors.php?delete=<?php echo $row['OscaIDNo']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this profile permanently? This deletes all their records.');"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script> $(document).ready(function() { $('#seniorTable').DataTable(); }); </script>
</body>
</html>