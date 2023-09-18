<!-- COMMENT 
1. Update document files of job by ID
 THE END -->


<?php include '../header.php'; ?>

<?php 
    include '../function/function.php';
        
        $sid = $_GET['sid'];
        $qcteamjobs = getRecordTableById('tbl_qcteamjob', 'id', $sid);

        if ($qcteamjobs) {
            foreach ($qcteamjobs as $qcteamjob) {
            }
        } else {
            echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.a";
        }
        $getEmployees = getRecordTableById('tbl_employee','department_id','2');
    ?>

<div class="container custom-fixed-top">
    
    <form action="job_add_updatefile_process.php?sid=<?php echo $sid;?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <input type="hidden" name="statusjob" value="<?php echo $qcteamjob['statusjob'];?>">
                    <label for="jobdetails" class="form-label">Job Details:</label>
                    <textarea class="form-control" id="jobdetails" name="jobdetails" style="height: 298px;" required><?php echo $qcteamjob['job'];?>
                </textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes:</label>
                    <textarea class="form-control" id="notes" name="notes" style="height: 298px;"
                        required><?php echo $qcteamjob['note'];?></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="images" class="form-label">Attach images:</label>
                    <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>
                </div>
                <div class="mb-3">
                    <label for="filename" class="form-label">Attach documents:</label>
                    <input type="file" class="form-control" id="filename" name="filename[]" accept="filename/*"
                        multiple>
                </div>
                <!-- 
                    1. lấy ID nhân viên được giao nhiệm vụ trong job
                    2. lấy ID nhân viên đó so sánh với list danh sách nhân viên được show ra
                 -->
                <div class="mb-3">
                    <label for="employee" class="form-label">Employee:</label>
                    <select class="form-select" name="employee" id="employee">
                        <?php
                        if ($getEmployees) {
                                foreach ($getEmployees as $getEmployee) {
                                    $selected = ($getEmployee['id'] == $qcteamjob['process_employee_id']) ? 'selected' : '';
                                    echo "<option value=".$getEmployee['id']." ".$selected.">".$getEmployee['fullname']."</option>";
                                    // echo "<option value=".$getEmployee['id'].">".$getEmployee['fullname']."</option>";
                                }
                            } else {
                                echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.";
                            }

                        ?>
                    </select>
                </div>


                <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline:</label>
                    <input type="date" class="form-control" id="deadline" name="deadline" min="<?php echo $qcteamjob['create_at']; ?>" max="" required
                        value="<?php echo $qcteamjob['job_deadline']; ?>">
                </div>

            </div>
            <button type="submit" class="btn btn-primary">Update Job</button>
        </div>
    </form>
</div>

</div>

<?php include '../footer.php'; ?>