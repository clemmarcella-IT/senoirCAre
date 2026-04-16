<!-- ==========================================
     EDIT EVENT MODAL (Beautiful UI)
     ========================================== -->
<div class="modal fade" id="edit_event_<?php echo $uniqueID; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            
            <div class="modal-header text-white" style="background-color: #1F4B2C;">
                <h5 class="modal-title fw-bold"><i class="fa fa-edit me-2"></i> Edit Health Activity</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Action passes old name/date via GET to identify the records -->
            <form role="form" method="POST" action="query_edit_health_event.php?old_name=<?php echo urlencode($row['HealthName']); ?>&old_date=<?php echo $row['HealthDate']; ?>">
                <div class="modal-body p-4" style="background-color: #f4f7f6;">
                    
                    <div class="card border-0 shadow-sm rounded-lg p-3">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted">RENAME ACTIVITY</label>
                            <input type="text" name="new_name" class="form-control" value="<?php echo $row['HealthName']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold text-muted">CHANGE DATE</label>
                            <input type="date" name="new_date" class="form-control" value="<?php echo $row['HealthDate']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="small fw-bold text-muted">UPDATE PURPOSE</label>
                            <select name="new_purpose" class="form-select" required>
                                <option value="Check up" <?php if($row['HealthPurpose']=='Check up') echo 'selected'; ?>>Check up</option>
                                <option value="Giving a medicine" <?php if($row['HealthPurpose']=='Giving a medicine') echo 'selected'; ?>>Giving a medicine</option>
                                <option value="Both" <?php if($row['HealthPurpose']=='Both') echo 'selected'; ?>>Both</option>
                                <option value="Others medication" <?php if($row['HealthPurpose']=='Others medication') echo 'selected'; ?>>Others medication</option>
                            </select>
                        </div>
                    </div>

                </div>
                
                <div class="modal-footer bg-white border-0">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4 fw-bold">Save All Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- ==========================================
     DELETE EVENT MODAL (Simple & Organized)
     ========================================== -->
<div class="modal fade" id="del_event_<?php echo $uniqueID; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold"><i class="fa fa-trash me-2"></i> Delete Health Event</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center p-4">
                <p class="mb-1 text-muted">Are you sure you want to delete the entire event:</p>
                <h4 class="fw-bold text-dark"><?php echo $row['HealthName']; ?></h4>
                <p class="small badge bg-light text-dark border"><?php echo date("F d, Y", strtotime($row['HealthDate'])); ?></p>
                
                <div class="alert alert-warning small mt-3">
                    <i class="fa fa-exclamation-triangle"></i> <strong>Warning:</strong> This will permanently erase ALL attendance logs for this day.
                </div>
            </div>

            <div class="modal-footer justify-content-center border-0 bg-light">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                
                <!-- Link follows your requested SIMPLE DELETE format -->
                <a href="query_delete_health_event.php?name=<?php echo urlencode($row['HealthName']); ?>&date=<?php echo $row['HealthDate']; ?>" class="btn btn-danger px-4 fw-bold">
                    Confirm Delete
                </a>
            </div>
            
        </div>
    </div>
</div>