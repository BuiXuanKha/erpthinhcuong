<?php
session_start();
require_once '../connect.php';
include '../function/function.php';
$uploadDir = '../uploads/job/';
$uploadDirectory = $uploadDir . 'images/';
date_default_timezone_set('Asia/Ho_Chi_Minh');
if (!file_exists($uploadDirectory)) {
    mkdir($uploadDirectory, 0755, true);
}
$currentDate = date('Y-m-d H:i:s');
$employee_id = $_SESSION['sid_employee'];
$department_id = $_SESSION['department_id'];
$jobId = $_POST['jobId'];
echo 'This is Value Job ID in uploadFileImage:'.$jobId;

$response = []; // Biến để trả về kết quả
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_upload_image'])) {
    $fileCount = count($_FILES['file_upload_image']['name']); // Số lượng tệp tải lên
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
            $response[] = ['success' => true, 'message' => 'File uploaded successfully.', 'newFileName' => $newFileName];
            // Nếu upload file thành công thì hãy nhập tên file vào csdl bảng tbl_job_image
            $sql_add_new_job_image = "INSERT INTO tbl_job_image (job_id,employee_id,department_id,linkfile,create_at)
            VALUES ('$jobId','$employee_id','$department_id','$newFilePath','$currentDate')";
                        
            if (mysqli_query($conn, $sql_add_new_job_image)) {
                // Thành công
                echo "Thêm dữ liệu vào tbl_job_image thành công.";
            } else {
                // Lỗi
                echo "Lỗi khi thêm dữ liệu vào tbl_job_image: " . mysqli_error($conn);
            }

        } else {
            $response[] = ['success' => false, 'message' => 'File upload failed.'];
        }
    }
} else {
    $response[] = ['success' => false, 'message' => 'Invalid request.'];
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($response);
?>