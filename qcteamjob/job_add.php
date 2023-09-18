<?php include '../header.php'; ?>
<div class="container custom-fixed-top">
    <form action="job_add_process.php" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="jobdetails" class="form-label">Job Details:</label>
                    <textarea class="form-control" id="jobdetails" name="jobdetails" style="height: 298px;" required></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes:</label>
                    <textarea class="form-control" id="notes" name="notes" style="height: 298px;" required></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="images" class="form-label">Attach images:</label>
                    <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple
                        >
                </div>
                <div class="mb-3">
                    <label for="filename" class="form-label">Attach documents:</label>
                    <input type="file" class="form-control" id="filename" name="filename[]" accept="filename/*" multiple
                        >
                </div>
                <div class="mb-3">

                    <label for="employee" class="form-label">Employee:</label>
                    <select class="form-select" name="employee" id="employee">
                    <?php
                        include '../function/function.php';
                        $getEmployees = getRecordTableById('tbl_employee','department_id','2');
                        if ($getEmployees) {
                                foreach ($getEmployees as $getEmployee) {
                                    echo "<option value=".$getEmployee['id'].">".$getEmployee['fullname']."</option>";
                                }
                            } else {
                                echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.";
                            }

                    ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline:</label>
                    <input type="date" class="form-control" id="deadline" name="deadline" min="<?php echo date('Y-m-d');?>" max="" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Add Job</button>
        </div>
    </form>
</div>

</div>

<?php include '../footer.php'; ?>