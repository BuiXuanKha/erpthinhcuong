<?php
session_start();
require_once '../connect.php';
include '../function/function.php';
$response = [];

if (isset($_POST['product_customer_id'])) {
    $product_customer_id = $_POST['product_customer_id'];

    // Sử dụng truy vấn SQL để tìm kiếm các giá trị tương ứng trong bảng tbl_product_customer_bom
    $sql = "SELECT * FROM tbl_photoorder_product_temp WHERE status = '0' AND product_customer_id = ?";
    
    // Sử dụng Prepared Statement để tránh SQL Injection
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $product_customer_id);
    mysqli_stmt_execute($stmt);
    
    // Lấy kết quả truy vấn
    $result = mysqli_stmt_get_result($stmt);
    
    // Kiểm tra xem có hàng dữ liệu phù hợp hay không
    $TonTaiSanPham = mysqli_num_rows($result);
    
    if (mysqli_num_rows($result) > 0) {
        // Lấy ID của sản phẩm từ hàng dữ liệu đầu tiên trong kết quả
        $row = mysqli_fetch_assoc($result);
        $recordId = $row['id']; // Thay 'id' bằng tên cột ID thực tế trong bảng tbl_product_customer_bom
        
        // Thêm giá trị $productCustomerBom_id vào mảng $response
        $response[] = ['success' => true, 'message' => 'Thành Công.', 'TonTaiSanPham' => $TonTaiSanPham,'recordId' => $recordId];
    } else {
        // Trường hợp không tìm thấy kết quả, đặt thông báo lỗi vào mảng phản hồi
        $response[] = ['success' => false, 'message' => 'Thành Công.', 'TonTaiSanPham' => $TonTaiSanPham];
    }
}

// Trả về phản hồi dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);

// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>
