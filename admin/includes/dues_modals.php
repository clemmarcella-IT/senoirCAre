<!-- EDIT DUES MODAL -->
<div class="modal fade" id="edit_dues_<?php echo $did; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Update Dues Standard</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="query_edit_dues.php?id=<?php echo $did; ?>">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small fw-bold">Amount Required (₱)</label>
                        <input type="number" step="0.01" min="1" name="amount" class="form-control card shadow border border-1 border-black" value="<?php echo $row['Amount_Required']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Due Date</label>
                        <input type="date" name="due_date" class="form-control card shadow border border-1 border-black" value="<?php echo $row['Due_Date']; ?>" required>
                    </div>
                    <div class="alert alert-info small mb-0">
                        Contribution name will be regenerated from the chosen Due Date as <strong>MonthlyDue_Month_Year</strong>.
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

<!-- DELETE DUES MODAL -->
<div class="modal fade" id="del_dues_<?php echo $did; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold">Delete Dues Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p>Delete <strong><?php echo $row['Contribution_Name']; ?></strong>?</p>
                <p class="text-danger small">All payment and attendance records for this dues will also be deleted.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="query_delete_dues.php?id=<?php echo $did; ?>" class="btn btn-danger px-4">Confirm Delete</a>
            </div>
        </div>
    </div>
</div>