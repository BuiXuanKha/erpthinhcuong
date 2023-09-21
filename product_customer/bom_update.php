<?php
session_start();
require_once '../connect.php';
include '../function/function.php';
$response = [];

if (isset($_POST['amount'])) {
    $bom_amountid = $_POST['amount'];
    $product_customer_bom_id = $_POST['product_customer_bom_id'];

    // UPDATE số lượng cho bản ghi có STATUS = 0 VÀ ID = $product_customer_bom_id
    $sql = "UPDATE tbl_product_customer_bom SET amount = ".$bom_amountid." WHERE status = '0' AND id = ".$product_customer_bom_id;
    // Sử dụng Prepared Statement để tránh SQL Injection
    if (mysqli_query($conn, $sql)) {
        $response[] = ['success' => true, 'message' => 'Thành Công.', 'Nội Dung' => 'Đã Update số lượng thành công', 'ID Vật Tư:' => $bom_id];
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