<?php
session_start();
require_once '../connect.php';
include '../function/function.php';
$response = [];

if (isset($_POST['amount'])) {
    $product_photoorder_amount = $_POST['amount'];
    $product_customer_id = $_POST['product_customer_id'];
    $recordId = $_POST['recordId'];
    $employee_id = $_SESSION['sid_employee'];

    // UPDATE số lượng cho bản ghi có STATUS = 0 VÀ ID = $product_customer_id
    $sql = "UPDATE tbl_photoorder_product_temp SET amount = ".$product_photoorder_amount." WHERE status = '0' AND employee_id= ".$employee_id." AND id = ".$recordId;
    // Sử dụng Prepared Statement để tránh SQL Injection
    if (mysqli_query($conn, $sql)) {
        $response[] = ['success' => true, 'message' => 'Thành Công.', 'Nội Dung' => 'Đã Update số lượng thành công', 'ID Sản Phẩm:' => $recordId];
    } else {
        $response[] = ['success' => false, 'message' => 'Không thành Công.', 'Thông báo lỗi' => $sql];
    }
}

// Trả về phản hồi dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);

// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>