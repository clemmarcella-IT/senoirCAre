<!-- EDIT MODAL FORM -->
<div class="modal fade" id="edit_<?php echo $id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content border border-black shadow-lg">
            
            <div class="modal-header text-white py-3" style="background-color: #1F4B2C;">
                <h5 class="modal-title fw-bold"><i class="fa fa-user-edit me-2"></i> Update Profile: <?php echo $id; ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form role="form" method="POST" action="query_edit_senior.php?id=<?php echo $id; ?>">
                <div class="modal-body p-4" style="background-color: #f8f9fa;">
                    <div class="row g-3">
                        
                        <!-- Row 1: Names -->
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">First Name</label>
                            <input type="text" name="fname" class="form-control card shadow border border-1 border-black" value="<?php echo $row['FirstName']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">Middle Name</label>
                            <input type="text" name="mi" class="form-control card shadow border border-1 border-black" value="<?php echo $row['MiddleName']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">Last Name</label>
                            <input type="text" name="lname" class="form-control card shadow border border-1 border-black" value="<?php echo $row['LastName']; ?>">
                        </div>

                        <!-- Row 2: Sex, Purok, Birthday -->
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">Sex</label>
                            <select name="sex" class="form-select card shadow border border-1 border-black">
                                <option value="Male" <?php if($row['Sex']=='Male'){ echo 'selected'; } ?>>Male</option>
                                <option value="Female" <?php if($row['Sex']=='Female'){ echo 'selected'; } ?>>Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">Purok (Zone)</label>
                            <select name="purok" class="form-select card shadow border border-1 border-black">
                                <?php for($i=1; $i<=6; $i++){ ?>

                                    <option value="Zone <?php echo $i; ?>" <?php if($row['Purok']=="Zone $i"){ echo 'selected'; } ?>>Zone <?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <?php 
                            // Very simple and safe age calculation
                            $bday = $row['Birthday'];
                            $birthYear = date("Y", strtotime($bday));
                            $currentYear = date("Y");
                            $currentAge = $currentYear - $birthYear;
                        ?>
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">Birthday</label>
                            <input type="date" name="bday" id="bdayInput_<?php echo $id; ?>" class="form-control card shadow border border-1 border-black" value="<?php echo $row['Birthday']; ?>" onchange="calculateAge('<?php echo $id; ?>')">
                            <div id="ageDisplay_<?php echo $id; ?>" class="mt-1 text-primary fw-bold small">Derived Age: <?php echo $currentAge; ?> Years Old</div>
                        </div>

                        <!-- Row 3: Status and Barangay -->
                        <div class="col-md-4">
                            <label class="small fw-bold text-muted">Citizen Status</label>
                            <select name="status" class="form-select card shadow border border-1 border-black">
                                <option value="Active" <?php if($row['CitizenStatus']=='Active'){ echo 'selected'; } ?>>Active</option>
                                <option value="Inactive" <?php if($row['CitizenStatus']=='Inactive'){ echo 'selected'; } ?>>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="small fw-bold text-muted">Barangay</label>
                            <input type="text" class="form-control card shadow border border-1 border-black" value="<?php echo $row['Barangay']; ?>" readonly>
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
                <h4 class="font-weight-bold text-dark"><?php echo $row['LastName']; ?>, <?php echo $row['FirstName']; ?></h4>
                <p class="text-danger small">This action is permanent.</p>
            </div>
            <div class="modal-footer justify-content-center bg-light border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                <a href="query_delete_senior.php?id=<?php echo $id; ?>" class="btn btn-danger px-4">Confirm Delete</a>
            </div>
        </div>
    </div>
</div>