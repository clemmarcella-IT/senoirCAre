<!-- EDIT MODAL -->
<div class="modal fade" id="edit_pen_<?php echo $uniqueID; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Update Payout Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <!-- Pass OLD values via GET so the query knows which record to change -->
            <form method="POST" action="query_edit_pension.php?old_reason=<?php echo $reason; ?>&old_date=<?php echo $date; ?>">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small fw-bold">Payout Name</label>
                        <input type="text" name="pname" class="form-control card shadow border border-1 border-black" value="<?php echo $reason; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Date</label>
                        <input type="date" name="pdate" class="form-control card shadow border border-1 border-black" value="<?php echo $date; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Cash Amount (₱)</label>
                        <input type="number" step="0.01" name="pamount" class="form-control card shadow border border-1 border-black" value="<?php echo $display['PensionCashAmount']; ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="del_pen_<?php echo $uniqueID; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold">Delete Payout Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p>Are you sure you want to delete this payout?</p>
                <h4 class="fw-bold"><?php echo $reason; ?></h4>
                <p class="text-danger small">This will delete all associated records.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="query_delete_pension.php?reason=<?php echo $reason; ?>&date=<?php echo $date; ?>" class="btn btn-danger px-4">Yes, Delete</a>
            </div>
        </div>
    </div>
</div>