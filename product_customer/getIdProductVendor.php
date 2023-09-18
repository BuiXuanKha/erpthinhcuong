<?php
session_start();
require_once '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị đã chọn từ máy khách
    $selectedValue = $_POST["selectedValue"];

    // Truy vấn cơ sở dữ liệu
    $sql = "SELECT * FROM tbl_product_vendor WHERE id = ".$selectedValue;
    // Truy vấn dữ liệu từ bảng
    $result = $conn->query($sql);
    
    // Khởi tạo một mảng response
    $response = array();
    
    // Kiểm tra và xử lý kết quả
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = $row;
        }
        $result->close();
        $conn->close();
    } else {
        $result->close();
        $conn->close();
    }
    
    // Trả về dữ liệu dưới dạng JSON
    echo json_encode($response);
}
?>
