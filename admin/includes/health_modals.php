<!-- EDIT HEALTH MODAL -->
<div class="modal fade" id="edit_health_<?php echo $uniqueID; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold">Update Health Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="query_edit_health_event.php?old_name=<?php echo $hname; ?>&old_date=<?php echo $hdate; ?>">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="small fw-bold">Event Name</label>
                        <input type="text" name="hname" class="form-control card shadow border border-1 border-black" value="<?php echo $display['HealthName']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Date</label>
                        <input type="date" name="hdate" class="form-control card shadow border border-1 border-black" value="<?php echo $display['HealthDate']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Purpose</label>
                        <select name="hpurpose" class="form-select card shadow border border-1 border-black" required>
                            <option value="Check up" <?php if($display['HealthPurpose'] == 'Check up') echo 'selected'; ?>>Check up</option>
                            <option value="Giving a medicine" <?php if($display['HealthPurpose'] == 'Giving a medicine') echo 'selected'; ?>>Giving a medicine</option>
                            <option value="Both" <?php if($display['HealthPurpose'] == 'Both') echo 'selected'; ?>>Both</option>
                            <option value="Others medication" <?php if($display['HealthPurpose'] == 'Others medication') echo 'selected'; ?>>Others medication</option>
                        </select>
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

<!-- DELETE HEALTH MODAL -->
<div class="modal fade" id="del_health_<?php echo $uniqueID; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold">Delete Health Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p>Are you sure you want to delete this event?</p>
                <h4 class="fw-bold"><?php echo $display['HealthName']; ?></h4>
                <p class="text-danger small">This will delete all scanned records for this health activity.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="query_delete_health_event.php?name=<?php echo $hname; ?>&date=<?php echo $hdate; ?>" class="btn btn-danger px-4">Yes, Delete</a>
            </div>
        </div>
    </div>
</div>