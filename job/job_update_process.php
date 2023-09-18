<?php
session_start();
require_once '../connect.php';

$response = []; // Biến để trả về kết quả

    $jobtitles = $_POST['jobtitles'];
    $jobdetails = $_POST['jobdetails'];
    $assignee = $_POST['assignee'];
    $deadline = $_POST['deadline'];
    $currentDateOld = $_POST['currentDateOld'];
    $jobId = $_POST['jobId'];

    // Lấy thông tin khác từ session hoặc các nguồn khác nếu cần
    $employee_id = $_SESSION['sid_employee'];
    $department_id = $_SESSION['department_id'];
    
    // Thêm dữ liệu vào cơ sở dữ liệu
    $sql_add_update_job =   "UPDATE tbl_job SET
                    job_titles = '$jobtitles',
                    job_details = '$jobdetails',
                    job_deadline = '$deadline',
                    employee_id = '$employee_id',
                    assignee_id = '$assignee',
                    department_id = '$department_id',
                    statusjob = 'Bắt đầu',
                    create_at = '$currentDateOld'
                WHERE id = $jobId"; // Thay $jobId bằng giá trị ID của job mà bạn muốn cập nhật
    echo $sql_add_update_job;
    echo "ID của trang process:".$jobId;
    if (mysqli_query($conn, $sql_add_update_job)) {
            $response[] = ['success' => true, 'message' => 'Update thành công vào bảng tbl_job.', 'jobId' => $jobId];
        } else {
            $response[] = ['success' => false, 'message' => 'Không thể lấy ID của bản ghi vừa tạo.'];
        }
?>