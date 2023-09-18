<!-- 
1. Trong bảng hình ảnh tbl_product_vendor_images chỉ lưu 1 hình ảnh của 1 sản phẩm
2. 

 -->
<?php
session_start();
require_once '../connect.php';
include '../function/function.php';
$uploadDir = '../uploads/product/';
$uploadDirectory = $uploadDir . 'images/';
date_default_timezone_set('Asia/Ho_Chi_Minh');

if (!file_exists($uploadDirectory)) {
    mkdir($uploadDirectory, 0755, true);
}

$currentDate = date('Y-m-d H:i:s');
$employee_id = $_SESSION['sid_employee'];
$productId = $_POST['product_vendor_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $originalFileName = $_FILES['file_upload_image']['name'];
    $newFileName = generateNewFileName($originalFileName, 100); // Tạo tên tệp mới
    
    $tempFileName = $_FILES['file_upload_image']['tmp_name'];
    $newFilePath = $uploadDirectory . $newFileName;
    
    // Di chuyển tệp tạm thời vào thư mục lưu trữ
    if (move_uploaded_file($tempFileName, $newFilePath)) {
        
        // Xoá file trên server
        $imageLink = getLinkImages($productId,'1','linkimage');
        if($imageLink){
            unlink($imageLink);
            $sqldelete = "DELETE FROM tbl_product_vendor_images WHERE product_vendor_id =".$productId;
            if(mysqli_query($conn, $sqldelete)){
                // Xoá Ok thì đóng kết nối giải phóng bộ nhé
                echo "Đã xoá trong CSDL thành công";
            }else{
                // Xoá không Ok thì đóng kết nối giải phóng bộ nhé
                echo "Không xoá trong CSDL thành công";
            }

        }
        
        // Xoá csdl lưu trữ file đã xoá
        
        $sql_add_new_job_image = "INSERT INTO tbl_product_vendor_images (product_vendor_id,employee_id,linkimage,linkimage_avatar,create_at)
        VALUES ('$productId', '$employee_id', '$newFilePath', '1','$currentDate')";
        // Sau khi thay đổi file đại diện cho Sản phẩm, hãy xoá file cũ đi, Việc này chưa làm
        // unlink($Linkfilecu);

        if (mysqli_query($conn, $sql_add_new_job_image)) {
            echo 'Đã thêm Linkfile và csdl thành công';
            $response[] = ['success' => true, 'message' => 'File upload OK.'];
        } else {
            $response[] = ['success' => false, 'message' => 'Failed to insert link into the database.'];
        }
    } else {
        $response[] = ['success' => false, 'message' => 'File upload failed.'];
    }
    
    // Trả về kết quả trong định dạng JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    
    // Đóng kết nối CSDL
    mysqli_close($conn);
}
?>
