<?php
session_start(); // khởi động phiên làm việc
date_default_timezone_set('Asia/Ho_Chi_Minh');
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header('Location: ./login/login.php'); // chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
}
require_once '../connect.php';

$currentDate = date('Y-m-d H:i:s');
// Lấy dữ liệu từ biểu mẫu
$jobTitles = $_POST['jobtitles'];
$jobDetails = $_POST['jobdetails'];
$deadline = $_POST['deadline'];
$nguoigiaoviec = $_SESSION['sid_employee'];
$assignee = $_POST['assignee'];
$department_id = $_SESSION['department_id'];
// $notes = $_POST['notesInput'];
$notes = 'NOtes';
$images = $_FILES['images'];
$filenames = $_FILES['filename'];
// Thêm thông tin công việc vào CSDL
// ...

$sql_add_new_job = "INSERT INTO tbl_job2 (
    job_titles,
    job_details,
    job_deadline,
    job_finish,  
    employee_id,
    assignee_id,
    department_id,
    statusjob,
    note,
    create_at
)
VALUES (
    '$jobTitles',
    '$jobDetails',
    '$deadline',
    '$deadline',
    '$nguoigiaoviec',   
    '$assignee',
    '$department_id',
    'bắt đầu',
    '$notes',  
    '$currentDate'
)";

    $result_add_new_job = mysqli_query($conn, $sql_add_new_job);
// ... (Phần mã khác)

if ($result_add_new_job) {
    $jobId = mysqli_insert_id($conn);

    // ... (Xử lý tải lên tệp)

    echo json_encode(['success' => true, 'jobId' => $jobId]);
    exit();
} else {
    echo json_encode(['success' => false]);
}
?>


?>

