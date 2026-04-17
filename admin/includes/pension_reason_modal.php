<!-- Individual Update Modal -->
<div class="modal fade" id="reasonModal_<?php echo $display['OscaIDNo']; ?>" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title fw-bold">Update Record</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="query_edit_pension_reason.php" method="POST">
                <div class="modal-body">
                    <!-- Hidden inputs to identify the correct record -->
                    <input type="hidden" name="oscaID" value="<?php echo $display['OscaIDNo']; ?>">
                    <input type="hidden" name="preason" value="<?php echo $preason; ?>">
                    <input type="hidden" name="pdate" value="<?php echo $pdate; ?>">
                    
                    <!-- Field 1: Control No. (Now allows any number, not just 0-9) -->
                    <div class="mb-3">
                        <label class="small fw-bold text-muted">Control No.:</label>
                        <input type="number" name="new_control" class="form-control card shadow border border-1 border-black" placeholder="Enter number" value="<?php echo $display['ControlNo']; ?>">
                    </div>

                    <!-- Field 2: Absence Reason -->
                    <div class="mb-3">
                        <label class="small fw-bold text-muted">Absence Reason:</label>
                        <input type="text" name="new_reason" class="form-control card shadow border border-1 border-black" placeholder="e.g. Bedridden" value="<?php echo $display['PensionReason']; ?>">

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Save Updates</button>
                </div>
            </form>
        </div>
    </div>
</div>