<?php
session_start();
$sid = $_GET['sid'];
include '../function/function.php';
// Ghi log khi có người dùng xoá Job
$logname = $_SESSION['fullname'].' '. $_SESSION['department_name'].' Đã xoá Job:<a class="btn btn-info btn-sm" href="/thinhcuong/job/job_details.php?sid='.$sid.'">View</a>';
addLog($logname);
// Lấy giá trị sid từ URL
// Kết nối đến CSDL
include '../connect.php';

// Chuẩn bị câu lệnh UPDATE
$sql_update_status = "UPDATE tbl_job SET status = 1 WHERE id = $sid";

// Thực thi câu lệnh UPDATE
if (mysqli_query($conn, $sql_update_status)) {
    header('location: job.php');
    exit();
} else {
    echo "Lỗi khi cập nhật trạng thái: " . mysqli_error($conn);
}

// Đóng kết nối
mysqli_close($conn);
?>
