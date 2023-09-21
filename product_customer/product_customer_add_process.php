<?php
session_start();
require_once '../connect.php';

$response = []; // Biến để trả về kết quả


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_SESSION['sid_employee'];
    
    $product_vendor_id =  $_POST['product_vendor_id'];
    $product_customer_code =  $_POST['product_customer_code'];
    $product_customer_fullname =  $_POST['product_customer_fullname'];
    $product_customer_id =  $_POST['product_customer_id'];

    $grossweight =  $_POST['grossweight'];
    $dimension_l =  $_POST['dimension_l'];
    $dimension_w =  $_POST['dimension_w'];
    $dimension_h =  $_POST['dimension_h'];

    $carton_l =  $_POST['carton_l'];
    $carton_w =  $_POST['carton_w'];
    $carton_h =  $_POST['carton_h'];
    $ctn_carton =  $_POST['ctn_carton'];

    $dolly_l =  $_POST['dolly_l'];
    $dolly_w =  $_POST['dolly_w'];
    $dolly_h =  $_POST['dolly_h'];
    $ctn_dolly =  $_POST['ctn_dolly'];

    $pallet_l =  $_POST['pallet_l'];
    $pallet_w =  $_POST['pallet_w'];
    $pallet_h =  $_POST['pallet_h'];
    $ctn_pallet =  $_POST['ctn_pallet'];

    $frame_id =$_POST['frame_id'] ;
    $rope_id =$_POST['rope_id'] ;
    $fabric_id =$_POST['fabric_id'] ;
    $wood_id =$_POST['wood_id'] ;
    $ceramic_id =$_POST['ceramic_id'] ;

    // '$frame_id','$rope_id','$fabric_id','$wood_id'

    $color_id =  $_POST['color_id'];
    // $style_category_id =  $_POST['style_category_id'];
    $currentDate =  $_POST['currentDate'];
// Nháp
    
    $sql = "INSERT INTO tbl_product_customer (product_vendor_id,product_customer_code,fullname,customer_id,grossweight,carton_l,carton_w,carton_h,dolly_l,dolly_w,dolly_h,pallet_l,pallet_w,pallet_h,color_id,create_at,employee_id,frame_id,rope_id,fabric_id,wood_id,ceramic_id,ctn_carton,ctn_dolly,ctn_pallet)
                VALUES ('$product_vendor_id','$product_customer_code','$product_customer_fullname','$product_customer_id','$grossweight','$carton_l','$carton_w','$carton_h','$dolly_l','$dolly_w','$dolly_h','$pallet_l','$pallet_w','$pallet_h','$color_id','$currentDate','$employee_id','$frame_id','$rope_id','$fabric_id','$wood_id','$ceramic_id','$ctn_carton','$ctn_dolly','$ctn_pallet')";
        if (mysqli_query($conn, $sql)) {
            
            $queryGetLatestJob = "SELECT id FROM tbl_product_customer WHERE employee_id = '$employee_id' ORDER BY create_at DESC LIMIT 1";
            $resultGetLatestJob = mysqli_query($conn, $queryGetLatestJob);
            $rowGetLatestJob = mysqli_fetch_assoc($resultGetLatestJob);
                
                if ($rowGetLatestJob) {
                    $product_customer_product_Id = $rowGetLatestJob['id'];
                    $response[] = ['success' => true, 'message' => 'Dữ liệu đã được nhập thành công vào bảng tbl_product_customer.', 'product_customer_product_Id' => $product_customer_product_Id];
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