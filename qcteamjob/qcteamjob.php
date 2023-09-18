<?php include '../header.php'; 
    include '../function/function.php';
    $qcteamjobs = getRecordTableById('tbl_qcteamjob','status','0');
    $employees = getAllTable('tbl_employee');
    $employees1 = getRecordTableById('tbl_employee','department_id','2');                       
?>

<div class="container-fluid mx-md-auto custom-fixed-top">
    <div class="row">
        <?php 
        if($employees1){
            foreach($employees1 as $employee){
                echo "<div class=\"col-md-4\">";
                    echo "<div class=\"card my-4\">";
                        echo "<div class=\"card-header\">";
                            echo $employee['fullname'];
                        echo "</div>";
                        echo "<div class=\"card-body\">";
                            echo "<span> Hoàn thành ".countCompletedJobs('tbl_qcteamjob',$employee['id'])."/".countEmployeeJobs('tbl_qcteamjob',$employee['id'])."</span><br>";
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
                <!-- Example single danger button -->
                <a class="btn btn-info" href="/thinhcuong/qcteamjob/job_add.php">Add Job</a>
                <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Report QC
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Thanh Nguyễn </a></li>
                        <li><a class="dropdown-item" href="#">Vũ Nga </a></li>
                        <li><a class="dropdown-item" href="#">Khả Bùi </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- table list job -->
    <div class="row">
        <div class="col-12">
            <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th class="mobile-hidden">ID</th>
                        <th class="mobile-hidden">Create by</th>
                        <th>Job</th>
                        <th class="mobile-hidden">Start</th>
                        <th>Deadline</th>
                        <th>Status job</th>
                        <th>Note</th>
                        <th>Assignee</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $stt=1;

                        if ($qcteamjobs) {
                            foreach ($qcteamjobs as $qcteamjob) {
                                echo "<tr>";
                                echo "<td class=\"mobile-hidden\">" . $stt++ . "</td>";
                                // Lấy tên nhân viên giao nhiệm vụ
                                echo "<td class=\"mobile-hidden\">" . getAllTableById($qcteamjob['employee_id'], $employees,'fullname')."</td>";
                               
                                echo "<td>" .shortenText($qcteamjob['job']). "</td>";
                                // echo "<td>" .$qcteamjob['job']. "</td>";
                                echo "<td class=\"mobile-hidden\">" . $qcteamjob['create_at'] . "</td>";
                                echo "<td>" . $qcteamjob['job_deadline'] . "</td>";
                                if($qcteamjob['statusjob']=='bắt đầu'){
                                    echo "<td><i class=\"fas fa-times\" style=\"color: #fa0000;\"></i><span style=\" color: #ffffff; \">.</span></td>";
                                }else{
                                    echo "<td><i class=\"fas fa-check\" style=\"color: #17a2b8;\"></i><span style=\" color: #ffffff; \">..</span></td>";
                                }
                                // echo "<td>" . $qcteamjob['statusjob'] . "</td>";
                                echo "<td>" . $qcteamjob['note'] . "</td>";
                                // Lấy tên nhân viên nhận nhiệm vụ
                                echo "<td>" . getAllTableById($qcteamjob['assignee_id'], $employees,'fullname') . "</td>";
                                echo "<td>
                                <a class=\"btn btn-info btn-sm\" href=\"javascript:void(0);\" onclick=\"logAddFile('/thinhcuong/qcteamjob/job_details.php?sid=".$qcteamjob['id']."', '".$_SESSION['fullname'].' '. $_SESSION['department_name']."', 'đã nhấp vào chức năng xem Details')\">Details</a>
                                <a class=\"btn btn-info btn-sm\" href=\"/thinhcuong/qcteamjob/job_delete.php?sid=".$qcteamjob['id']."\" onclick=\"return confirmDelete();\">Del</a>
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