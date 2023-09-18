<?php
session_start();
require_once '../connect.php';
include '../function/function.php';
$uploadDir = '../uploads/product_customer/';
$uploadDirectory = $uploadDir . 'images/';
date_default_timezone_set('Asia/Ho_Chi_Minh');

if (!file_exists($uploadDirectory)) {
    mkdir($uploadDirectory, 0755, true);
}

$currentDate = date('Y-m-d H:i:s');
$employee_id = $_SESSION['sid_employee'];
$product_customer_product_Id = $_POST['product_customer_product_Id'];
echo 'This is Value Job ID in uploadFileImage:'.$product_customer_product_Id;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_upload_image'])) {
    $fileCount = count($_FILES['file_upload_image']['name']); // Số lượng tệp tải lên
    echo "So luong file: ".$fileCount;
    // Lặp qua các tệp đã tải lên
    for ($i = 0; $i < $fileCount; $i++) {
        $originalFileName = $_FILES['file_upload_image']['name'][$i];
        $trimmedFileName = trimFilename($originalFileName, 100);
        
        $tempFileName = $_FILES['file_upload_image']['tmp_name'][$i];
        $newFileName = time() . '_' . $trimmedFileName; // Tạo tên tệp mới
        
        // Địa chỉ lưu trữ tệp trên máy chủ
        $newFilePath = $uploadDirectory . $newFileName;
        // Di chuyển tệp tạm thời vào thư mục lưu trữ
        if (move_uploaded_file($tempFileName, $newFilePath)) {

            $sql_product_customer_image = "INSERT INTO tbl_product_customer_image (product_customer_product_id,employee_id,linkimage,create_at)
            VALUES ('$product_customer_product_Id','$employee_id','$newFilePath','$currentDate')";
    
            if (mysqli_query($conn, $sql_product_customer_image)) {
                echo 'Đã thêm Linkfile và csdl thành công';
                $response[] = ['success' => true, 'message' => 'File upload OK.'];
            } else {
                $response[] = ['success' => false, 'message' => 'Loi SQL:' . mysqli_error($conn)];
            }
        } else {
            $response[] = ['success' => false, 'message' => 'File upload failed.'];
        }
    }
} else {
    $response[] = ['success' => false, 'message' => 'Invalid request.'];
}
?>
