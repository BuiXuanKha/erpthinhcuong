<?php
session_start();
require_once '../connect.php';

$response = []; // Biến để trả về kết quả


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $product_customer_id =  $_POST['product_customer_id'];
    $bom_id =  $_POST['bom_id'];
    $employee_id = $_SESSION['sid_employee'];
    $amount =  $_POST['amount'];

    $currentDate =  $_POST['currentDate'];

    echo "ID sản phẩm của khác".$product_customer_id;
    echo "ID vât tư:".$bom_id;
// Nháp
    
    $sql = "INSERT INTO tbl_product_customer_bom (product_customer_id,bom_id,employee_id,amount,create_at)
                VALUES ('$product_customer_id','$bom_id','$employee_id','$amount','$currentDate')";
        if (mysqli_query($conn, $sql)) {
            
            $queryGetLatestJob = "SELECT id FROM tbl_product_customer_bom WHERE employee_id = '$employee_id' ORDER BY create_at DESC LIMIT 1";
            $resultGetLatestJob = mysqli_query($conn, $queryGetLatestJob);
            $rowGetLatestJob = mysqli_fetch_assoc($resultGetLatestJob);
                
                if ($rowGetLatestJob) {
                    $product_customer_product_Id = $rowGetLatestJob['id'];
                    $response[] = ['success' => true, 'message' => 'Dữ liệu đã được nhập thành công vào bảng tbl_product_customer.', 'product_customer_product_Id' => $product_customer_product_Id];
                } else {
                    $response[] = ['success' => false, 'message' => 'Không thể lấy ID của bản ghi vừa tạo.'];
                }
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