<!-- Individual Reason Modal -->
<div class="modal fade" id="reasonModal_<?php echo $display['OscaIDNo']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title fw-bold">Set Absence Reason</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="query_edit_pension_reason.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="oscaID" value="<?php echo $display['OscaIDNo']; ?>">
                    <input type="hidden" name="preason" value="<?php echo $preason; ?>">
                    <input type="hidden" name="pdate" value="<?php echo $pdate; ?>">
                    
                    <label class="small fw-bold text-muted">Reason for Not Attending:</label>
                    <input type="text" name="new_reason" class="form-control" placeholder="e.g. Bedridden" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Save Reason</button>
                </div>
            </form>
        </div>
    </div>
</div>