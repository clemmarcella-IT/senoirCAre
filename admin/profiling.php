<?php
include("../includes/db_connection.php");

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

$query = "SELECT * FROM seniors WHERE (LastName LIKE '%$search%' OR OscaIDNo LIKE '%$search%')";
if($status_filter != '') { $query .= " AND CitezenStatus = '$status_filter'"; }

$result = mysqli_query($conn, $query);
?>

<!-- Add to HTML inside #content -->
<div class="card p-4">
    <div class="d-flex justify-content-between mb-3">
        <form class="d-flex gap-2">
            <input type="text" name="search" class="form-control" placeholder="Search ID or Name..." value="<?php echo $search; ?>">
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            <button class="btn btn-forest">Search</button>
        </form>
    </div>

    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>OscaIDNo.</th>
                <th>Full Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['OscaIDNo']; ?></td>
                <td><?php echo $row['LastName'] . ", " . $row['FirstName']; ?></td>
                <td>
                    <span class="badge <?php echo ($row['CitezenStatus'] == 'active') ? 'bg-success' : 'bg-danger'; ?>">
                        <?php echo $row['CitezenStatus']; ?>
                    </span>
                </td>
                <td>
                    <a href="edit_senior.php?id=<?php echo $row['OscaIDNo']; ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="delete_senior.php?id=<?php echo $row['OscaIDNo']; ?>" onclick="return confirm('Delete this record?')" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>