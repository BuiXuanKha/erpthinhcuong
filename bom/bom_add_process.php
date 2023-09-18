<?php
session_start();
require_once '../connect.php';

$response = []; // Biến để trả về kết quả


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_SESSION['sid_employee'];
    
    $fullname =  $_POST['fullname'];
    $unit_id =  $_POST['unit_id'];
    $dimension_l =  $_POST['dimension_l'];
    $dimension_w =  $_POST['dimension_w'];
    $dimension_h =  $_POST['dimension_h'];
    $bom_color_id =  $_POST['bom_color_id'];
    $currentDate =  $_POST['currentDate'];
    $notes =  $_POST['notes'];
// Nháp
    
    $sql = "INSERT INTO tbl_bom (employee_id,unit_id,fullname,create_at,dimension_l,dimension_w,dimension_h,bom_color_id,note) VALUES ('$employee_id','$unit_id','$fullname','$currentDate','$dimension_l','$dimension_w','$dimension_h','$bom_color_id','$notes')";
        if (mysqli_query($conn, $sql)) {
            echo $sql;
            $queryGetLatestJob = "SELECT id FROM tbl_bom WHERE employee_id = '$employee_id' ORDER BY create_at DESC LIMIT 1";
            $resultGetLatestJob = mysqli_query($conn, $queryGetLatestJob);
            $rowGetLatestJob = mysqli_fetch_assoc($resultGetLatestJob);
                
                if ($rowGetLatestJob) {
                    $product_customer_product_Id = $rowGetLatestJob['id'];
                    $response[] = ['success' => true, 'message' => 'Dữ liệu đã được nhập thành công vào bảng tbl_bom.', 'product_customer_product_Id' => $product_customer_product_Id];
                } else {
                    $response[] = ['success' => false, 'message' => 'Không thể lấy ID của bản ghi vừa tạo.'];
                }
            } else {
                $response[] = ['success' => false, 'message' => 'Lỗi: ' . mysqli_error($conn)];
            }
} else {
    $response[] = ['success' => false, 'message' => 'Invalid request.'];
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);
?>