<?php
session_start();
require_once '../connect.php';
include '../function/function.php';
$response = [];

if (isset($_POST['amount'])) {
    $bom_amountid = $_POST['amount'];
    $product_customer_bom_id = $_POST['product_customer_bom_id'];

    // Sử dụng truy vấn SQL để tìm kiếm các giá trị tương ứng trong bảng tbl_product_customer_bom
    $sql = "UPDATE tbl_product_customer_bom SET amount = ".$bom_amountid." WHERE status = '0' AND id = ".$product_customer_bom_id;
    // $sql = "SELECT * FROM tbl_product_customer_bom WHERE bom_id = ? AND product_customer_id=".$product_customer_id;
    echo "Câu lệnh Update SQL:". $sql;
    // Sử dụng Prepared Statement để tránh SQL Injection
    // mysqli_query($conn, $sql);
    if (mysqli_query($conn, $sql)) {
    // Lấy ID của sản phẩm từ hàng dữ liệu đầu tiên trong kết quả

    // Thêm giá trị $productCustomerBom_id vào mảng $response
    $response[] = ['success' => true, 'message' => 'Thành Công.', 'Nội Dung' => 'Đã Update số lượng thành công', 'ID Vật Tư:' => $bom_id];
} else {
    // Trường hợp không tìm thấy kết quả, đặt thông báo lỗi vào mảng phản hồi
    $response[] = ['success' => false, 'message' => 'Không thành Công.', 'Thông báo lỗi' => $sql];
}

}

// Trả về phản hồi dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);

// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>