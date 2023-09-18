<?php
require_once '../connect.php';

// Kiểm tra xem biến $_GET["sid"] đã được truyền từ URL hay chưa
if (isset($_GET["sid"]) && is_numeric($_GET["sid"])) {
    $color_id = $_GET["sid"];

    // Chuẩn bị câu truy vấn dùng Prepared Statements để tránh SQL Injection
    $sql = "UPDATE tbl_color SET status = 1 WHERE id = ?";

    // Chuẩn bị Prepared Statement
    if ($stmt = $conn->prepare($sql)) {
        // Gán giá trị cho tham số '?' trong Prepared Statement
        $stmt->bind_param("i", $color_id);

        // Thực thi Prepared Statement
        if ($stmt->execute()) {
            // Chuyển hướng về trang color.php sau khi cập nhật thành công
            header('location: ./color.php');
            exit();
        } else {
            echo "Lỗi khi thực hiện truy vấn: ";
        }

        // Đóng Prepared Statement
        $stmt->close();
    } else {
        echo "Lỗi khi chuẩn bị truy vấn: ";
    }
} else {
    echo "Không tìm thấy id màu để xóa!";
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
