<?php
session_start(); // Khởi động phiên làm việc

// Lấy dữ liệu từ biểu mẫu đăng nhập
$username = $_POST['username'];
$password = $_POST['password'];
$ip = $_SERVER['REMOTE_ADDR'];

include '../function/function.php';


// Thực hiện kết nối đến cơ sở dữ liệu
require_once '../connect.php'; // Include file connect.php để sử dụng kết nối

// Truy vấn dữ liệu từ bảng tc_nhanvien
$sql = "SELECT nv.*, pb.department_name
        FROM tbl_employee nv
        JOIN tbl_department pb ON nv.department_id = pb.id
        WHERE users = '$username'";

// Thực hiện truy vấn
$result = $conn->query($sql);

// Kiểm tra kết quả truy vấn
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Kiểm tra mật khẩu
    if ($row['password'] == $password) {
        // Đăng nhập thành công

        $_SESSION['sid_employee'] = $row['id'];
        $_SESSION['username'] = $username;
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['department_name'] = $row['department_name'];
        $_SESSION['department_id'] = $row['department_id'];
        $logname = $_SESSION['fullname'].' '. $_SESSION['department_name'].' Đã đăng nhập hệ thống thành công!';
        addLog($logname);
        $conn->close(); // Đóng kết nối cơ sở dữ liệu
        header('Location: ../index.php'); // Chuyển hướng đến trang index.php
        exit();
    }
}

// Đăng nhập thất bại
$conn->close(); // Đóng kết nối cơ sở dữ liệu
header('Location: ./login.php?error=1'); // Chuyển hướng đến trang login.php để đăng nhập lại
$logname = 'IP: '.$ip.' đang cố gắng đăng nhập hệ thống bằng User:'.$username.' Pass:'. $password;
addLog($logname);
exit();
?>