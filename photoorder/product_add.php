<?php
session_start();
require_once '../connect.php';

$response = []; // Biến để trả về kết quả


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $product_customer_id =  $_POST['product_customer_id'];
    $employee_id = $_SESSION['sid_employee'];
    $amount =  $_POST['amount'];

    $currentDate =  $_POST['currentDate'];
    $sql = "INSERT INTO tbl_photoorder_product_temp (product_customer_id,employee_id,amount,create_at)
                VALUES ('$product_customer_id','$employee_id','$amount','$currentDate')";
        if (mysqli_query($conn, $sql)) {
                $response[] = ['success' => true, 'message' => 'Dữ liệu đã được nhập thành công vào bảng tbl_photoorder_product_temp.'];
            } else {
                $response[] = ['success' => false, 'message' => 'Lỗi: ' . $sql];
            }
} else {
    $response[] = ['success' => false, 'message' => 'Invalid request.'];
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);
?>