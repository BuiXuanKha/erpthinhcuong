<?php
session_start();
require_once '../connect.php';
include '../function/function.php';
$response = []; // Biến để trả về kết quả


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentDate =  $_POST['currentDate'];

    $customer_id =  $_POST['customer_id'];
    $employee_id = $_SESSION['sid_employee'];

    $date_inspection =  $_POST['date_inspection'];
    $date_loading =  $_POST['date_loading'];
    $note =  $_POST['note'];

    // Tạo bản ghi mới cho bảng tbl_photoorder
    $sqlPhotoorder = "INSERT INTO tbl_photoorder (customer_id,employee_id,date_inspection,date_loading,statusorder,note,create_at)
                    VALUES ('$customer_id','$employee_id','$date_inspection','$date_loading','Đang sản xuất','$note','$currentDate')";

    if (mysqli_query($conn, $sqlPhotoorder)) {
            
        $queryGetLatestJob = "SELECT id FROM tbl_photoorder WHERE employee_id = '$employee_id' ORDER BY create_at DESC LIMIT 1";
        $resultGetLatestJob = mysqli_query($conn, $queryGetLatestJob);
        $rowGetLatestJob = mysqli_fetch_assoc($resultGetLatestJob);
            if ($rowGetLatestJob) {
                $photoorder_id = $rowGetLatestJob['id'];

                $photoorder_product_temps = getRecordTableById('tbl_photoorder_product_temp','status','0');
                if($photoorder_product_temps){
                    // Lấy ID của $photoorder_product_id
                    foreach($photoorder_product_temps as $photoorder_product_temp){
                        $product_customer_id = $photoorder_product_temp["product_customer_id"];
                        $amount = $photoorder_product_temp["employee_id"];
                        $amount = $photoorder_product_temp["amount"];
                        $create_at = $photoorder_product_temp["create_at"];
                       
                        $sqlconvert = "INSERT INTO tbl_photoorder_product (product_customer_id,employee_id,photoorder_id,amount,create_at)
                                VALUES ('$product_customer_id','$employee_id','$photoorder_id','$amount','$currentDate')";
                        if (mysqli_query($conn, $sqlconvert)) {
                            $response[] = ['success' => true, 'message' => 'Thành công Add tbl_photoorder_product.'];
                        }else{
                            $response[] = ['success' => false, 'message' => 'Thất bại.','Lỗi' => $sqlconvert];

                        }
                    }
                    // Xoá toàn bộ bảng temp
                    $sqldelete = "DELETE FROM tbl_photoorder_product_temp";
                    mysqli_query($conn, $sqldelete);
                }
                
            }


    } else {
        $response[] = ['success' => false, 'message' => 'Lỗi tạo Đơn hàng.'];
            }
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);
?>