<!-- EDIT MODAL FORM -->
<div class="modal fade" id="edit_<?php echo $id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content border border-black shadow-lg">
            
            <!-- Modal Header: Matching Registration Style -->
            <div class="modal-header text-white py-3" style="background-color: #1F4B2C;">
                <h5 class="modal-title fw-bold"><i class="fa fa-user-edit me-2"></i> Update Profile: <?php echo $id; ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form Start -->
            <form role="form" method="POST" action="query_edit_senior.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                <div class="modal-body p-4" style="background-color: #f8f9fa;">
                    <div class="row g-3">
                        
                        <!-- Row 1: Names -->
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">First Name</label>
                            <input type="text" name="fname" class="form-control card shadow border border-1 border-black" value="<?php echo $row['FirstName']; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">Middle Name</label>
                            <input type="text" name="mi" class="form-control card shadow border border-1 border-black" value="<?php echo $row['MiddleName']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">Last Name</label>
                            <input type="text" name="lname" class="form-control card shadow border border-1 border-black" value="<?php echo $row['LastName']; ?>" required>
                        </div>

                        <!-- Row 2: Sex, Purok, Birthday with Live Age -->
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">Sex</label>
                            <select name="sex" class="form-select card shadow border border-1 border-black" required>
                                <option value="Male" <?php if($row['Sex']=='Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if($row['Sex']=='Female') echo 'selected'; ?>>Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">Purok (Zone)</label>
                            <select name="purok" class="form-select card shadow border border-1 border-black" required>
                                <?php for($i=1; $i<=6; $i++): ?>
                                    <option value="Zone <?php echo $i; ?>" <?php if($row['Purok']=="Zone $i") echo 'selected'; ?>>Zone <?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <?php 
                            // Calculate existing age via PHP for initial modal load
                            $currentAge = date_diff(date_create($row['Birthday']), date_create('today'))->y; 
                        ?>
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">Birthday</label>
                            <!-- Note the dynamic ID and the parameter in calculateAge() -->
                            <input type="date" name="bday" id="bdayInput_<?php echo $id; ?>" class="form-control card shadow border border-1 border-black" value="<?php echo $row['Birthday']; ?>" onchange="calculateAge('<?php echo $id; ?>')" required>
                            <div id="ageDisplay_<?php echo $id; ?>" class="mt-1 text-primary fw-bold small">Derived Age: <?php echo $currentAge; ?> Years Old</div>
                        </div>

                        <!-- Row 3: Status and Barangay -->
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">Citizen Status</label>
                            <select name="status" class="form-select card shadow border border-1 border-black">
                                <option value="active" <?php if($row['CitizenStatus']=='active') echo 'selected'; ?>>Active</option>
                                <option value="inactive" <?php if($row['CitizenStatus']=='inactive') echo 'selected'; ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="small fw-bold text-muted">Barangay</label>
                            <input type="text" class="form-control card shadow border border-1 border-black" value="<?php echo $row['Barangay']; ?>" readonly>
                        </div>

                        <!-- Row 4: Profile Picture -->
                        <div class="col-12 mt-4 border-top pt-3">
                            <label class="fw-bold text-success">1. PROFILE PICTURE</label>
                            <input type="file" name="pic" class="form-control card shadow border border-1 border-black" accept="image/*">
                            <div class="upload-instruction">Note: Picture must have a plain <strong>white background</strong>.</div>
                        </div>

                        <!-- Row 5: Signature & Thumbmarks (Stacked vertically) -->
                        <div class="col-md-6 mt-3">
                            <label class="fw-bold text-success">2. SIGNATURE</label>
                            <input type="file" name="sig1" class="form-control card shadow border border-1 border-black">
                            <div class="upload-instruction">Note: Sign on <strong>white paper</strong> and upload.</div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="fw-bold text-success">3. THUMBMARK</label>
                            <input type="file" name="thumb1" class="form-control card shadow border border-1 border-black mb-2">
                            <div class="upload-instruction">Note: Upload single thumbprint.</div>
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