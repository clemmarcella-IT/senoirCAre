<!-- EDIT MODAL -->
<div class="modal fade" id="edit_<?php echo $row['OscaIDNo']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="query_edit_senior.php?id=<?php echo $row['OscaIDNo']; ?>" method="POST">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Update Record: <?php echo $row['OscaIDNo']; ?></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="small fw-bold">First Name</label><input type="text" name="fname" class="form-control" value="<?php echo $row['FirstName']; ?>"></div>
                    <div class="mb-3"><label class="small fw-bold">Last Name</label><input type="text" name="lname" class="form-control" value="<?php echo $row['LastName']; ?>"></div>
                    <div class="mb-3">
                        <label class="small fw-bold">Citizen Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?php if($row['CitezenStatus']=='active') echo 'selected'; ?>>Active</option>
                            <option value="inactive" <?php if($row['CitezenStatus']=='inactive') echo 'selected'; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-success">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="del_<?php echo $row['OscaIDNo']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to delete the profile of:</p>
                <h5 class="fw-bold"><?php echo $row['LastName'].", ".$row['FirstName']; ?></h5>
                <p class="text-danger small">This will also delete all their health and attendance records.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="query_delete_senior.php?id=<?php echo $row['OscaIDNo']; ?>" class="btn btn-danger">Confirm Delete</a>
            </div>
        </div>
    </div>
</div>