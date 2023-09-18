<?php
session_start(); // khởi động phiên làm việc
date_default_timezone_set('Asia/Ho_Chi_Minh');
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
	header('Location: ./login/login.php'); // chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
}
// Lấy mã job mới, chứ không phải lấy sid
// $id_job = 10;
$currentDate = date('Y-m-d H:i:s');
// Xử lý upload hình ảnh và tệp tin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Đường dẫn lưu trữ thư mục chính
	require_once '../connect.php';

	// Thực hiện câu truy vấn SELECT
	$jobdetails = $_POST['jobdetails'];
	$notes = $_POST['notes'];
	$employee = $_POST['employee'];
	$deadline = $_POST['deadline'];
	$id_job = $_GET['sid'];
	$statusjob = $_POST['statusjob'];
	$nguoigiaoviec = $_SESSION['sid_employee'];
    // Update SQL
    $sql_add_update_job = "UPDATE tbl_qcteamjob 
                  SET job = '$jobdetails',
                      job_deadline = '$deadline',
                      job_fisnish = '$deadline',
                      employee_id = '$nguoigiaoviec',
                      assignee_id = '$employee',
                    --   statusjob cần phải lấy kiểu POST nhé
                      statusjob = '$statusjob',
                      note = '$notes',
                      create_at = '$currentDate'
                  WHERE id = '$id_job'";
    // Cần phải kiểm tra xem các file có được upload thành công không?
    // Nếu không thành công thì không được lưu vào csdl
    mysqli_query($conn, $sql_add_update_job);

	// echo  $sql_add_update_job."<br>";
	}

    // $sql_add_update_job = "INSERT INTO tbl_qcteamjob (job,job_deadline,job_fisnish,employee_id,process_employee_id,statusjob,note,create_at)
    // VALUES ('$jobdetails','$deadline','$deadline','$nguoigiaoviec','$employee','bắt đầu','$notes','$currentDate')";
    


	$uploadDir = '../upload/qc/';
	$imagesDir = $uploadDir . 'Images/';
	if (!file_exists($imagesDir)) {
		mkdir($imagesDir, 0755, true);
	} 

	$filesDir = $uploadDir . 'FilesDocument/';
	if (!file_exists($filesDir)) {
		mkdir($filesDir, 0755, true);
	} 
	// Xử lý upload hình ảnh
	if (isset($_FILES["images"])) {
        $imageFiles = $_FILES["images"];
        $imageCount = count($imageFiles["name"]);

        for ($i = 0; $i < $imageCount; $i++) {
            $image = $imageFiles["name"][$i];
            $imageTmp = $imageFiles["tmp_name"][$i];

            if (!empty($image) && is_uploaded_file($imageTmp)) {
                $imageExtension = pathinfo($image, PATHINFO_EXTENSION);
                $timestamp = date('YmdHis');
                $unique_id = uniqid();
                $fileName = $timestamp . '_' . $unique_id . '.' . $imageExtension;
                $imagePath = $imagesDir . basename($fileName);
                move_uploaded_file($imageTmp, $imagePath);

                // Lưu link hình ảnh vào CSDL hoặc làm bất kỳ xử lý nào khác
                $sql_add_new_job_image = "INSERT INTO tbl_qcteamjob_image (qcteamjob_id,linkfile,create_at)
                                        VALUES ('$id_job','$imagePath','$currentDate')";
				// echo $sql_add_new_job_image."<br>";
                mysqli_query($conn, $sql_add_new_job_image);
            }
        }
    }

    // Xử lý upload tệp tin
    if (isset($_FILES["filename"])) {
        $fileFiles = $_FILES["filename"];
        $fileCount = count($fileFiles["name"]);

        for ($i = 0; $i < $fileCount; $i++) {
            $file = $fileFiles["name"][$i];
            $fileTmp = $fileFiles["tmp_name"][$i];

            if (!empty($file) && is_uploaded_file($fileTmp)) {
                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                $timestamp = date('YmdHis');
                $unique_id = uniqid();
                $fileName = $timestamp . '_' . $unique_id . '_.' . $fileExtension;
                $filePath = $filesDir . basename($fileName);
                move_uploaded_file($fileTmp, $filePath);

                // Lưu link tệp tin vào CSDL hoặc làm bất kỳ xử lý nào khác
                $sql_add_new_job_file = "INSERT INTO tbl_qcteamjob_file (qcteamjob_id,employee_id,linkfile,create_at)
                                        VALUES ('$id_job','$nguoigiaoviec','$filePath','$currentDate')";
				echo $sql_add_new_job_file."<br>";
				// echo $currentDate;
                mysqli_query($conn, $sql_add_new_job_file);
            }
        }
	}
?>