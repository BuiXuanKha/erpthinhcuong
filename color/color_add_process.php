<?php
require_once '../connect.php'; // Include file connect.php để sử dụng kết nối

// Kiểm tra xem form đã được gửi đi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem các trường cần thiết đã được gửi đi hay chưa
    if (isset($_POST["name"]) && isset($_POST["color_code"]) && isset($_POST["customer_id"])) {
        $name = $_POST["name"];
        $color_code = $_POST["color_code"];
        $customer_id = $_POST["customer_id"];
        $spectrophotometer = $_POST["spectrophotometer1"] .' '. $_POST["spectrophotometer2"] .' '. $_POST["spectrophotometer3"];
        $create_at = date('Y-m-d H:i:s');
        $employee = $_POST['sid_employee'];

            $uploadDir = '../upload/'; // Thư mục chứa ảnh tải lên
            // Kiểm tra lỗi khi upload file
                // Tạo tên file mới
                $imagesDir = $uploadDir . 'colorImages/';
                if (!file_exists($imagesDir)) {
                    mkdir($imagesDir, 0755, true);
                } 
                $timestamp = date('YmdHis');
                $unique_id = uniqid();
                $fileName = $timestamp . '_' . $unique_id . '_' . $_FILES["image"]["name"];

                $imagePath = $imagesDir . basename($fileName);

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                    // Lưu link hình ảnh vào CSDL hoặc làm bất kỳ xử lý nào khác
                    $linkimage = $imagePath;
                } else {
                    echo "Lỗi: Không thể lưu file tải lên.";
                }
        // Chuẩn bị câu truy vấn dùng Prepared Statements để tránh SQL Injection
        $sql = "INSERT INTO tbl_color (name, color_code, customer_id, spectrophotometer, linkimage, employee_id, create_at)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        // Chuẩn bị Prepared Statement
        if ($stmt = $conn->prepare($sql)) {
            // Gán giá trị cho các tham số '?' trong Prepared Statement
            $stmt->bind_param("sssssss", $name, $color_code, $customer_id, $spectrophotometer, $linkimage, $employee, $create_at);

            // Thực thi Prepared Statement
            if ($stmt->execute()) {
                header('Location: ./color.php');
            } else {
                echo "Lỗi khi thực hiện truy vấn: " . $stmt->error;
            }

            // Đóng Prepared Statement
            $stmt->close();
        } else {
            echo "Lỗi khi chuẩn bị truy vấn: ";
        }

        // Đóng kết nối cơ sở dữ liệu
        $conn->close();
    } else {
        echo "Vui lòng điền đầy đủ thông tin cần thiết!";
    }
}
?>