<?php
session_start();
// Lấy giá trị sid từ URL
$sid = $_GET['sid'];
include '../function/function.php';
$logname = $_SESSION['fullname'].' '. $_SESSION['department_name'].' Đã Hoàn thành Job có ID:'.$sid;
addLog($logname);
date_default_timezone_set('Asia/Ho_Chi_Minh');
$currentDate = date('Y-m-d H:i:s');
// Kết nối đến CSDL
include '../connect.php';

// Chuẩn bị câu lệnh UPDATE
$sql_update_status = "UPDATE tbl_job SET statusjob = 'Hoàn thành', job_finish = '$currentDate' WHERE id = $sid";

// $sql_update_status = "UPDATE tbl_job SET statusjob = 'Hoàn thành', job_finish = ".$currentDate." WHERE id = $sid";
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