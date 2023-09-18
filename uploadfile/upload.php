<?php
$uploadDirectory = 'uploads/'; // Thư mục để lưu tệp đã tải lên
$response = []; // Biến để trả về kết quả

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_upload'])) {
    $fileCount = count($_FILES['file_upload']['name']); // Số lượng tệp tải lên

    // Lặp qua các tệp đã tải lên
    for ($i = 0; $i < $fileCount; $i++) {
        $originalFileName = $_FILES['file_upload']['name'][$i];
        $tempFileName = $_FILES['file_upload']['tmp_name'][$i];
        $newFileName = time() . '_' . $originalFileName; // Tạo tên tệp mới

        // Địa chỉ lưu trữ tệp trên máy chủ
        $newFilePath = $uploadDirectory . $newFileName;

        // Di chuyển tệp tạm thời vào thư mục lưu trữ
        if (move_uploaded_file($tempFileName, $newFilePath)) {
            $response[] = ['success' => true, 'message' => 'File uploaded successfully.', 'newFileName' => $newFileName];
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
