<!-- EDIT MODAL FORM -->
<div class="modal fade" id="edit_<?php echo $id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
            
            <!-- Modal Header -->
            <div class="modal-header text-white" style="background-color: #1F4B2C;">
                <h5 class="modal-title fw-bold"><i class="fa fa-user-edit mr-2"></i> Update Profile: <?php echo $id; ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    <select name="status" class="form-control border-danger font-weight-bold">
                                        <option value="active" <?php if($row['CitezenStatus']=='active') echo 'selected'; ?>>Active</option>
                                        <option value="inactive" <?php if($row['CitezenStatus']=='inactive') echo 'selected'; ?>>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Photo Updates Card -->
                    <div class="card border-0 shadow-sm rounded-lg">
                        <div class="card-header bg-white fw-bold" style="color: #1F4B2C;">
                            <i class="fa fa-camera mr-1"></i> Update Photos (Optional)
                        </div>
                        <div class="card-body">
                            <input type="file" name="pic" class="form-control-file mb-3" accept="image/*">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="small font-weight-bold">3 Signatures</label>
                                    <input type="file" name="sig1" class="form-control-file mb-1">
                                    <input type="file" name="sig2" class="form-control-file mb-1">
                                    <input type="file" name="sig3" class="form-control-file">
                                </div>
                                <div class="col-md-6">
                                    <label class="small font-weight-bold">3 Thumbmarks</label>
                                    <input type="file" name="thumb1" class="form-control-file mb-1">
                                    <input type="file" name="thumb2" class="form-control-file mb-1">
                                    <input type="file" name="thumb3" class="form-control-file">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer bg-white border-top-0">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn text-white px-4 font-weight-bold" style="background-color: #1F4B2C; border: none;">Save Updates</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE MODAL FORM -->
<div class="modal fade" id="delete_<?php echo $id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-trash mr-2"></i> Delete Record</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <p>Are you sure you want to delete the profile of:</p>
                <!-- REMOVED strtoupper HERE -->
                <h4 class="font-weight-bold text-dark"><?php echo $row['LastName'].", ".$row['FirstName']; ?></h4>
                <p class="text-danger small">This action is permanent.</p>
            </div>
            <div class="modal-footer justify-content-center bg-light border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                <a href="query_delete_senior.php?id=<?php echo $id; ?>" class="btn btn-danger px-4">Confirm Delete</a>
            </div>
        </div>
    </div>
</div>