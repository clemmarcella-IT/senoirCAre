<!-- Edit Modal -->
<div class="modal fade" id="editModal<?php echo $row['LogID']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Edit Benefit Claim</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="query_benefits_crud.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="log_id" value="<?php echo $row['LogID']; ?>">
                    <div class="mb-3">
                        <label class="fw-bold text-muted small">Amount Released (₱)</label>
                        <input type="number" step="0.01" name="amount" class="form-control" value="<?php echo $row['Amount_Released']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-muted small">Reason</label>
                        <input type="text" name="reason" class="form-control" value="<?php echo htmlspecialchars($row['Reason']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold text-muted small">Date Recorded</label>
                        <input type="date" name="date" class="form-control" value="<?php echo $row['DateRecorded']; ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="edit_claim" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal<?php echo $row['LogID']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold">Delete Benefit Claim</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <i class="fa fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                <p class="fw-bold">Are you sure you want to delete this benefit claim?</p>
                <h5 class="text-dark"><?php echo $name; ?> - ₱<?php echo number_format($row['Amount_Released'], 2); ?></h5>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                <form action="query_benefits_crud.php" method="POST" class="m-0 p-0">
                    <input type="hidden" name="log_id" value="<?php echo $row['LogID']; ?>">
                    <button type="submit" name="delete_claim" class="btn btn-danger px-4 fw-bold">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
