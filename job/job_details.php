<?php include '../header.php'; ?>

<div class="container-fluid mx-md-auto custom-fixed-top">
    <?php 
    include '../function/function.php';
        // Chính xác chỗ này phải đặt tên biến là jobId
        $sid = $_GET['sid'];
        $jobs = getRecordTableById('tbl_job', 'id', $sid);

        if ($jobs) {
            foreach ($jobs as $job) {
            }
        } else {
            echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.a";
        }
        $employee1s = getRecordTableById('tbl_employee', 'id', $job['employee_id']);

        if ($employee1s) {
            foreach ($employee1s as $employee) {
            }
        } else {
            echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.a";
        }
        $employee2s = getRecordTableById('tbl_employee', 'id', $job['assignee_id']);

        if ($employee2s) {
            foreach ($employee2s as $employee2) {
            }
        } else {
            echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.a";
        }
        $job_files = getRecordTableById('tbl_job_file', 'job_id',$job['id']);

        $job_images = getRecordTableById('tbl_job_image', 'job_id',$job['id']);
        // Lấy toàn bộ nhân viên
        $allEmployess = getAllTable('tbl_employee');

       
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card my-4">
                <div class="card-header font-weight-bold d-flex justify-content-between ">
                    <span>Create job by: <?php echo $employee['fullname'];?></span>
                    <a class="btn btn-info" href="javascript:void(0);"
                        onclick="logAddFile('/thinhcuong/job/job_update.php?jobId=<?php echo $sid; ?>', '<?php echo $_SESSION['fullname'].' '. $_SESSION['department_name']; ?>', 'đã nhấp vào chức năng add file')">Edit</a>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Nội dung công việc -->
                            <pre><?php echo trim($job['job_details']); ?></pre>
                        </div>
                        <div class="col-md-6">
                            <p class="font-weight-bold">Planning:</p>
                            <?php echo "from: ".$job['create_at']."  to: ".$job['job_deadline'] ;?>
                            <hr>
                            <p class="font-weight-bold">Status:</p> <?php echo $job['statusjob'];?>
                            <hr>
                            <p class="font-weight-bold">Notes:</p><?php echo $job['note'];?>
                            <hr>
                            <p class="font-weight-bold">Assignee:</p><?php echo $employee2['fullname'];?>
                        </div>
                    </div>
                    <hr>
                    <!-- Danh sách file đính kèm -->
                    <!-- <div class="d-flex justify-content-between">
                        <p class="font-weight-bold">File đính kèm:</p>
                        <a class="btn btn-info" href="javascript:void(0);"
                            onclick="logAddFile('/thinhcuong/job/job_add_updatefile.php?sid=<php echo $sid; ?>''Thanh nguyễn', 'đã nhấp vào chức năng add file')">Add
                            file</a>
                    </div> -->
                    <!-- Trong phần HTML, thêm sự kiện onclick để gọi hàm logAddFile() khi người dùng click vào button và chuyển đến trang mới -->
                    <!-- <div class="d-flex justify-content-between">
                        <p class="font-weight-bold">File đính kèm:</p>
                        <a class="btn btn-info" href="javascript:void(0);"
                            onclick="logAddFile('/thinhcuong/job/job_add_updatefile.php?sid=<php echo $sid; ?>', 'Thanh nguyễn', 'đã nhấp vào chức năng add file')">Add
                            file</a>
                    </div> -->
                    <div class="d-flex justify-content-between">
                        <p class="font-weight-bold">File đính kèm:</p>
                    </div>


                    <!-- <div class="d-flex justify-content-between">
                        <p class="font-weight-bold">File đính kèm:</p>
                        <a class="btn btn-info"
                            href="/thinhcuong/job/job_add_updatefile.php?sid=<php echo $sid; ?>">Add file</a>
                    </div> -->

                    <?php 
                            if ($job_files) {
                                foreach ($job_files as $job_file) {
                                    $fileName = basename($job_file['linkfile']);
                                    echo $fileName." <a class=\"font-weight-bold\" href=\"".$job_file['linkfile']."\" class=\"btn btn-info btn-sm\" >Download</a> Update at: "
                                    .$job_file['create_at']." by " .getAllTableById($job_file['employee_id'],$allEmployess,'fullname')."</br>";
                                }
                            } 
                    ?>
                    <hr>
                    <!-- Danh sách hình ảnh đính kèm -->
                    <p class="font-weight-bold">Hình ảnh đính kèm:</p>
                    <?php 
                        if ($job_images) {
                            echo "<div class=\"tz-gallery\">";
                            echo "<div class=\"image-gallery\">";
                            foreach ($job_images as $job_image) {
                                echo   "<div class=\"gallery-item\">";
                                echo "<a class=\"lightbox\" href=\"".$job_image['linkfile']."\">";
                                    echo "<img src=\"".$job_image['linkfile']."\" alt=\"Sky\">";
                                echo "</a>";
                                echo "</div>";
                            }
                            
                            echo "</div>";
                            echo "</div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                <a class="btn btn-info"
                    href="/thinhcuong/job/job_finish.php?sid=<?php echo $job['id'];?>">Finish</a>
                <span class="mx-2"></span>
                <!-- <a class="btn btn-info" href="#">Cancel</a> -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-center">
                <span>ERP - THINH CUONG COMPANY 2023 </span>
            </div>
        </div>
    </div>
</div>
</div>


</div>

<?php include '../footer.php'; ?>