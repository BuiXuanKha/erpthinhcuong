<!-- 
Đoạn mã PHP trên thực hiện các công việc sau:

Khởi động phiên làm việc (session_start()) và đặt múi giờ mặc định là 'Asia/Ho_Chi_Minh'.

Kiểm tra xem người dùng đã đăng nhập chưa bằng cách kiểm tra xem biến $_SESSION['username'] có tồn tại không. Nếu chưa đăng nhập, sẽ chuyển hướng người dùng đến trang đăng nhập (login.php).

Lấy thông tin về công việc và người thực hiện từ dữ liệu gửi lên qua POST.

Thêm thông tin công việc mới vào bảng tbl_qcteamjob trong cơ sở dữ liệu. Nếu thành công, in ra thông báo "Đã thêm sản phẩm mới thành công"; nếu thất bại, in ra thông báo lỗi và thông tin câu truy vấn không thành công.

Nếu không thêm được công việc vào cơ sở dữ liệu, in ra thông báo lỗi kèm thông tin lỗi từ cơ sở dữ liệu.

Tạo thư mục lưu trữ hình ảnh và tệp tin nếu chưa tồn tại.

Xử lý upload hình ảnh nếu có. Đổi tên hình ảnh và lưu vào thư mục ../upload/qc/Images/, sau đó lưu đường dẫn vào bảng tbl_qcteamjob_image trong cơ sở dữ liệu.

Xử lý upload tệp tin nếu có. Đổi tên tệp tin và lưu vào thư mục ../upload/qc/FilesDocument/, sau đó lưu đường dẫn vào bảng tbl_qcteamjob_file trong cơ sở dữ liệu.

 -->

<?php
session_start(); // khởi động phiên làm việc
date_default_timezone_set('Asia/Ho_Chi_Minh');
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header('Location: ./login/login.php'); // chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
}
$currentDate = date('Y-m-d H:i:s');
// Xử lý upload hình ảnh và tệp tin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../connect.php';
    $jobdetails = $_POST['jobdetails'];
    $notes = $_POST['notes'];
    $employee = $_POST['employee'];
    $deadline = $_POST['deadline'];

    $nguoigiaoviec = $_SESSION['sid_employee'];

    $sql_add_new_job = "INSERT INTO tbl_qcteamjob (job,job_deadline,job_fisnish,employee_id,assignee_id,statusjob,note,create_at)
                                    VALUES ('$jobdetails','$deadline','$deadline','$nguoigiaoviec','$employee','bắt đầu','$notes','$currentDate')";

    $result_add_new_job = mysqli_query($conn, $sql_add_new_job);

    if ($result_add_new_job) {
        $id_job = mysqli_insert_id($conn);
        // Truy vấn thành công, thực hiện các hành động khác (nếu có)
        echo "Đã thêm sản phẩm mới thành công";
    } else {
        echo "sai rồi " . $sql_add_new_job;
        // Truy vấn không thành công, xử lý lỗi (nếu có)
    }

    if (!$result_add_new_job) {
        echo "Lỗi khi thêm yêu cầu làm mẫu vào CSDL: " . mysqli_error($conn);
    }
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

                $sql_add_new_job_image = "INSERT INTO tbl_qcteamjob_image (qcteamjob_id,linkfile,create_at)
                                        VALUES ('$id_job','$imagePath','$currentDate')";

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

                $sql_add_new_job_file = "INSERT INTO tbl_qcteamjob_file (qcteamjob_id,assignee_id,linkfile,create_at)
                                        VALUES ('$id_job','$nguoigiaoviec','$filePath','$currentDate')";

                mysqli_query($conn, $sql_add_new_job_file);
            }
        }
	}
}
?>


