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
    $currentDate = $_POST['currentDate'];
    $style_id = $_POST['style_id'];

    // Thêm dữ liệu vào cơ sở dữ liệu
    $sql = "INSERT INTO tbl_product_vendor (employee_id, product_vendor_code, netweight, dimension_l, dimension_w, dimension_h, create_at,style_id) 
     VALUES ('$employee_id', '$product_code', '$netweight', '$dimension_l', '$dimension_w', '$dimension_h', '$currentDate','$style_id')";
 
        // NHÁP
        if (mysqli_query($conn, $sql)) {
            
        $queryGetLatestJob = "SELECT id FROM tbl_product_vendor WHERE employee_id = '$employee_id' ORDER BY create_at DESC LIMIT 1";
        $resultGetLatestJob = mysqli_query($conn, $queryGetLatestJob);
        $rowGetLatestJob = mysqli_fetch_assoc($resultGetLatestJob);
            
            if ($rowGetLatestJob) {
                $productId = $rowGetLatestJob['id'];
                $response[] = ['success' => true, 'message' => 'Dữ liệu đã được nhập thành công vào bảng tbl_job.', 'productId' => $productId];
            } else {
                $response[] = ['success' => false, 'message' => 'Không thể lấy ID của bản ghi vừa tạo.'];
            }
        } else {
            $response[] = ['success' => false, 'message' => 'Lỗi: ' . mysqli_error($conn)];
        }
        // NHÁP

} else {
    $response[] = ['success' => false, 'message' => 'Invalid request.'];
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);
?>