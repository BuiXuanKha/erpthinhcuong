<?php
session_start();
require_once '../connect.php';

$response = []; // Biến để trả về kết quả


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $dimension_l =  $_POST['dimension_l'];
    $dimension_w =  $_POST['dimension_w'];
    $dimension_h =  $_POST['dimension_h'];
    
    $product_customer_fullname =  $_POST['product_customer_fullname'];
    $product_vendor_id =  $_POST['product_vendor_id'];
    // đang có vấn đề ở cái ID này
    $product_customer_id =  $_POST['product_customer_id'];

    $employee_id = $_SESSION['sid_employee'];
    $product_customer_code =  $_POST['product_customer_code'];
    $grossweight =  $_POST['grossweight'];
    $color_id =  $_POST['color_id'];
    $frame_id = $_POST['frame_id'] ;
    $wood_id = $_POST['wood_id'] ;
    $rope_id = $_POST['rope_id'] ;
    $fabric_id = $_POST['fabric_id'] ;
    $ceramic_id = $_POST['ceramic_id'] ;

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

    $currentDate =  $_POST['currentDate'];
    $sid =  $_POST['sid'];

    $sql = "UPDATE tbl_product_customer 
    SET fullname = '$product_customer_fullname',
        product_vendor_id = '$product_vendor_id',
        customer_id = '$product_customer_id',
        employee_id = '$employee_id',
        product_customer_code = '$product_customer_code',
        grossweight = '$grossweight',
        color_id = '$color_id',
        frame_id = '$frame_id',
        wood_id = '$wood_id',
        rope_id = '$rope_id',
        fabric_id = '$fabric_id',
        ceramic_id = '$ceramic_id',
        carton_l = '$carton_l',
        carton_w = '$carton_w',
        carton_h = '$carton_h',
        dolly_l = '$dolly_l',
        dolly_w = '$dolly_w',
        dolly_h = '$dolly_h',
        pallet_l = '$pallet_l',
        pallet_w = '$pallet_w',
        pallet_h = '$pallet_h',
        create_at = '$currentDate',
        ctn_carton = '$ctn_carton',
        ctn_dolly = '$ctn_dolly',
        ctn_pallet = '$ctn_pallet'
    WHERE id = $sid";

        if (mysqli_query($conn, $sql)) {
                $response[] = ['success' => true, 'message' => 'Dữ liệu đã được nhập thành công vào bảng tbl_product_customer.','Sql:' => $sql];
            } else {
                $response[] = ['success' => false, 'message' => 'Lỗi: ' . mysqli_error($conn),'Sql:' => $sql];
            }
} else {
    $response[] = ['success' => false, 'message' => 'Invalid request.'];
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);
?>