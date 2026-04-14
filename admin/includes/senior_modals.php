<!-- EDIT MODAL FORM (Beautiful UI Design) -->
<div class="modal fade" id="edit_<?php echo $id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            
            <!-- Modal Header -->
            <div class="modal-header text-white" style="background-color: #1F4B2C;">
                <h5 class="modal-title fw-bold"><i class="fa fa-user-edit mr-2"></i> Update Profile: <?php echo $id; ?></h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form Start -->
            <form role="form" method="POST" action="query_edit_senior.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                <div class="modal-body" style="background-color: #f4f7f6;">
                    
                    <!-- 1. Personal Information Card -->
                    <div class="card border-0 shadow-sm mb-3 rounded-lg">
                        <div class="card-header bg-white fw-bold" style="color: #1F4B2C;">
                            <i class="fa fa-info-circle mr-1"></i> Personal Information
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="small text-muted font-weight-bold">First Name</label>
                                    <input type="text" name="fname" class="form-control" value="<?php echo $row['FirstName']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="small text-muted font-weight-bold">Middle Name</label>
                                    <input type="text" name="mi" class="form-control" value="<?php echo $row['MiddleName']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="small text-muted font-weight-bold">Last Name</label>
                                    <input type="text" name="lname" class="form-control" value="<?php echo $row['LastName']; ?>" required>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label class="small text-muted font-weight-bold">Sex</label>
                                    <select name="sex" class="form-control" required>
                                        <option value="Male" <?php if($row['Sex']=='Male') echo 'selected'; ?>>Male</option>
                                        <option value="Female" <?php if($row['Sex']=='Female') echo 'selected'; ?>>Female</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-muted font-weight-bold">Birthday</label>
                                    <input type="date" name="bday" class="form-control" value="<?php echo $row['Birthday']; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Address & Status Card -->
                    <div class="card border-0 shadow-sm mb-3 rounded-lg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="small text-muted font-weight-bold">Purok (Zone)</label>
                                    <select name="purok" class="form-control" required>
                                        <?php for($i=1; $i<=6; $i++): ?>
                                            <option value="Zone <?php echo $i; ?>" <?php if($row['Purok']=="Zone $i") echo 'selected'; ?>>Zone <?php echo $i; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="small text-danger font-weight-bold">Citizen Status</label>
                                    <select name="status" class="form-control border-danger font-weight-bold text-danger">
                                        <option value="active" <?php if($row['CitezenStatus']=='active') echo 'selected'; ?>>Active</option>
                                        <option value="inactive" <?php if($row['CitezenStatus']=='inactive') echo 'selected'; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Photo Updates Card (Optional) -->
                    <div class="card border-0 shadow-sm rounded-lg">
                        <div class="card-header bg-white fw-bold" style="color: #1F4B2C;">
                            <i class="fa fa-camera mr-1"></i> Update Photos <span class="text-muted font-weight-normal">(Optional)</span>
                        </div>
                        <div class="card-body">
                            <p class="small text-danger mb-3"><i class="fa fa-exclamation-triangle"></i> Leave the file boxes blank if you do not want to change the current photos.</p>
                            
                            <div class="mb-3">
                                <label class="small font-weight-bold">Update Profile Picture</label>
                                <input type="file" name="pic" class="form-control-file" accept="image/*">
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="small font-weight-bold text-muted">Update 3 Signatures</label>
                                    <input type="file" name="sig1" class="form-control-file mb-2" accept="image/*">
                                    <input type="file" name="sig2" class="form-control-file mb-2" accept="image/*">
                                    <input type="file" name="sig3" class="form-control-file" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="small font-weight-bold text-muted">Update 3 Thumbmarks</label>
                                    <input type="file" name="thumb1" class="form-control-file mb-2" accept="image/*">
                                    <input type="file" name="thumb2" class="form-control-file mb-2" accept="image/*">
                                    <input type="file" name="thumb3" class="form-control-file" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                
                <!-- Modal Footer with Working Cancel Button -->
                <div class="modal-footer bg-white border-top-0">
                    <!-- The data-dismiss="modal" is what makes the cancel button functional -->
                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">
                        <i class="fa fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn text-white px-4 font-weight-bold" style="background-color: #1F4B2C; border: none;">
                        <i class="fa fa-save mr-1"></i> Save Updates
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- DELETE MODAL FORM (Cleaned up) -->
<div class="modal fade" id="delete_<?php echo $id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle mr-2"></i> Delete Record</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-4">
                <p class="mb-2">Are you sure you want to permanently delete the profile of:</p>
                <h4 class="font-weight-bold text-dark"><?php echo strtoupper($row['LastName'].", ".$row['FirstName']); ?></h4>
                <p class="text-danger small mt-3 px-3">
                    <strong>Warning:</strong> This will also instantly delete all Health, Attendance, Assistance, and Pension records associated with this citizen.
                </p>
            </div>
            <div class="modal-footer justify-content-center bg-light border-0">
                <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancel</button>
                <form method="POST" action="query_delete_senior.php?id=<?php echo $id; ?>">
                    <button type="submit" class="btn btn-danger px-4"><i class="fa fa-trash mr-1"></i> Confirm Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>