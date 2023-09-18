<?php
session_start();
// Lấy giá trị sid từ URL
$sid = $_GET['sid'];
include '../function/function.php';
$logname = $_SESSION['fullname'].' '. $_SESSION['department_name'].' Đã Hoàn thành Job có ID:'.$sid;
addLog($logname);

// Kết nối đến CSDL
include '../connect.php';

// Chuẩn bị câu lệnh UPDATE
$sql_update_status = "UPDATE tbl_qcteamjob SET statusjob = 'hoàn thành' WHERE id = $sid";
// Thực thi câu lệnh UPDATE
if (mysqli_query($conn, $sql_update_status)) {
    header('location: qcteamjob.php');
    exit();
} else {
    echo "Lỗi khi cập nhật trạng thái: " . mysqli_error($conn);
}

// Đóng kết nối
mysqli_close($conn);
?>