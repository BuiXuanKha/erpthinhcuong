<?php
session_start();
require_once '../connect.php';

$response = []; // Biến để trả về kết quả

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_SESSION['sid_employee'];
    $product_code = $_POST['product_code'];
    $netweight = $_POST['netweight'];
    $dimension_l = $_POST['dimension_l'];
    $dimension_w = $_POST['dimension_w'];
    $dimension_h = $_POST['dimension_h'];
    $style_id = $_POST['style_id'];
    $currentDate = $_POST['currentDate'];
    $product_vendor_id = $_POST['product_vendor_id'];

    // Thêm dữ liệu vào cơ sở dữ liệu
    $sql = "UPDATE tbl_product_vendor SET
    employee_id = '$employee_id',
    product_vendor_code = '$product_code',
    netweight = '$netweight',
    dimension_l = '$dimension_l',
    dimension_w = '$dimension_w',
    dimension_h = '$dimension_h',
    style_id = '$style_id',
    create_at = '$currentDate'
    WHERE id = '$product_vendor_id'";
    echo $sql;
        // NHÁP
        if (mysqli_query($conn, $sql)) {
                $response[] = ['success' => true, 'message' => 'Dữ liệu đã được Update thành công vào bảng .', 'product_vendor_id' => $product_vendor_id];
            } else {
                $response[] = ['success' => false, 'message' => 'Không thể lấy ID của bản ghi vừa tạo.'];
            }
        // NHÁP

} else {
    $response[] = ['success' => false, 'message' => 'Invalid request.'];
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);
?>