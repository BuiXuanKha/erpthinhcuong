<?php
session_start();
require_once '../connect.php';

$response = []; // Biến để trả về kết quả

if (isset($_POST['jobtitles']) && isset($_POST['jobdetails']) && isset($_POST['assignee']) && isset($_POST['deadline']) && isset($_POST['notes']) && isset($_POST['currentDate'])) {
    $jobtitles = $_POST['jobtitles'];
    $jobdetails = $_POST['jobdetails'];
    $assignee = $_POST['assignee'];
    $deadline = $_POST['deadline'];
    $notes = $_POST['notes'];
    $currentDate = $_POST['currentDate'];

    // Lấy thông tin khác từ session hoặc các nguồn khác nếu cần
    $employee_id = $_SESSION['sid_employee'];
    $department_id = $_SESSION['department_id'];
    
    // Thêm dữ liệu vào cơ sở dữ liệu
    $query = "INSERT INTO tbl_job (job_titles, job_details, job_deadline, employee_id, assignee_id, department_id, statusjob, note, create_at)
              VALUES ('$jobtitles', '$jobdetails', '$deadline', '$employee_id', '$assignee', '$department_id', 'Bắt đầu', '$notes', '$currentDate')";

        // if (mysqli_query($conn, $query)) {
        //     // Chỗ này sẽ xảy ra lỗi: nhiều người cùng tạo job, và Người A sẽ lấy được $jobId vừa thêm vào
        //     // mới nhất của Người B. Tức là 2 người cùng tạo Job cùng 1 thời điểm, thì sẽ xảy ra hiện tượng này.
        //     // CÁCH KHẮC PHỤC: Lấy job vừa tạo mới nhất by employee_id ( Chưa làm được 24/08/2023)
        //     $jobId = mysqli_insert_id($conn); // Lấy ID của bản ghi vừa thêm
        //     $response[] = ['success' => true, 'message' => 'Dữ liệu đã được nhập thành công vào bảng tbl_job.', 'jobIdOld' => $jobId];
        // } else {
        //     $response[] = ['success' => false, 'message' => 'Lỗi: ' . mysqli_error($conn)];
        // }
        
        // NHÁP
        if (mysqli_query($conn, $query)) {
            $queryGetLatestJob = "SELECT id FROM tbl_job WHERE employee_id = '$employee_id' ORDER BY create_at DESC LIMIT 1";
            $resultGetLatestJob = mysqli_query($conn, $queryGetLatestJob);
            $rowGetLatestJob = mysqli_fetch_assoc($resultGetLatestJob);
            
            if ($rowGetLatestJob) {
                $jobId = $rowGetLatestJob['id'];
                $response[] = ['success' => true, 'message' => 'Dữ liệu đã được nhập thành công vào bảng tbl_job.', 'jobId' => $jobId];
            } else {
                $response[] = ['success' => false, 'message' => 'Không thể lấy ID của bản ghi vừa tạo.'];
            }
        } else {
            $response[] = ['success' => false, 'message' => 'Lỗi: ' . mysqli_error($conn)];
        }
        // NHÁP





} else {
    $response[] = ['success' => false, 'message' => 'Invalid request.'];
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);
?>