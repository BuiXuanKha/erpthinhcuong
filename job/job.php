<?php include '../header.php'; 
    include '../function/function.php';
    $idDepartment = $_SESSION['department_id'];

    $status_test = 'department_id='.$idDepartment.' AND status';
    $jobs = getRecordTableById('tbl_job',$status_test,'0');
    
    $employees = getAllTable('tbl_employee');
    $employees1 = getRecordTableById('tbl_employee','department_id',$idDepartment);                       
?>

<div class="container-fluid mx-md-auto custom-fixed-top">
    <div class="row">
        <?php 
        // echo $status_test;
        if($employees1){
            foreach($employees1 as $employee){
                echo "<div class=\"col-md-4\">";
                    echo "<div class=\"card my-4\">";
                        echo "<div class=\"card-header\">";
                            echo $employee['fullname'];
                        echo "</div>";
                        echo "<div class=\"card-body\">";
                            echo "<span> Hoàn thành ".countCompletedJobs('tbl_job',$employee['id'])."/".countEmployeeJobs('tbl_job',$employee['id'])."</span><br>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
            }
        }
        ?>

    </div>
    <!-- menu thêm mới job -->
    <div class="row">

        <div class="kha_list">

            <div class="kha_list_item">
            </div>
            <div class="kha_list_item1">
                <a class="btn btn-info" href="/thinhcuong/job/job_add.php">Add Job</a>
                <!-- <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Report QC
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Thanh Nguyễn </a></li>
                        <li><a class="dropdown-item" href="#">Vũ Nga </a></li>
                        <li><a class="dropdown-item" href="#">Khả Bùi </a></li>
                    </ul>
                </div> -->
            </div>
        </div>
    </div>
    <!-- table list job -->
    <div class="row">
        <div class="col-12">
            <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Create by</th>
                        <th>Job titles</th>
                        <th>Job Details</th>
                        <th>Start</th>
                        <th>Deadline</th>
                        <th>S</th>
                        <th>Note</th>
                        <th>Assignee</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $stt=1;

                        if ($jobs) {
                            foreach ($jobs as $job) {
                                echo "<tr>";
                                echo "<td>" . $stt++ . "</td>";
                                // Lấy tên nhân viên giao nhiệm vụ
                                echo "<td>" . getAllTableById($job['employee_id'], $employees,'fullname')."</td>";
                               
                                echo "<td>" .shortenText($job['job_titles']). "</td>";
                                echo "<td>" .shortenText($job['job_details']). "</td>";
                                echo "<td>" . $job['create_at'] . "</td>";
                                echo "<td>" . $job['job_deadline'] . "</td>";
                                if($job['statusjob']=='Bắt đầu'){
                                    echo "<td><i class=\"fas fa-times\" style=\"color: #fa0000;\"></i><span style=\" color: #ffffff; \">.</span></td>";
                                }else{
                                    echo "<td><i class=\"fas fa-check\" style=\"color: #17a2b8;\"></i><span style=\" color: #ffffff; \">..</span></td>";
                                }
                                // echo "<td>" . $job['statusjob'] . "</td>";
                                echo "<td>" . $job['note'] . "</td>";
                                // Lấy tên nhân viên nhận nhiệm vụ
                                echo "<td>" . getAllTableById($job['assignee_id'], $employees,'fullname') . "</td>";
                                echo "<td>
                                <a class=\"btn btn-info btn-sm\" href=\"javascript:void(0);\" onclick=\"logAddFile('/thinhcuong/job/job_details.php?sid=".$job['id']."', '".$_SESSION['fullname'].' '. $_SESSION['department_name']."', 'đã nhấp vào chức năng xem Details')\">Details</a>
                                <a class=\"btn btn-info btn-sm\" href=\"/thinhcuong/job/job_delete.php?sid=".$job['id']."\" onclick=\"return confirmDelete('công việc');\">Del</a>
                                </td>";
                                echo "</tr>";

                            }
                        } else {
                            echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.";
                        }
                        ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>

<?php include '../footer.php'; ?>