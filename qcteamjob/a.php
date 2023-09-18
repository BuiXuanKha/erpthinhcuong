<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header('Location: ./login/login.php');
    exit;
}

// Xử lý khi người dùng gửi form POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../connect.php';

    // Xử lý thông tin form
    $jobdetails = $_POST['jobdetails'];
    $notes = $_POST['notes'];
    $employee = $_POST['employee'];
    $deadline = $_POST['deadline'];

    $nguoigiaoviec = $_SESSION['sid_employee'];

    // Thực hiện câu truy vấn INSERT để thêm công việc mới
    $sql_add_new_job = "INSERT INTO tbl_qcteamjob (job, job_deadline, job_fisnish, employee_id, process_employee_id, statusjob, note, create_at)
                        VALUES ('$jobdetails', '$deadline', '$deadline', '$nguoigiaoviec', '$employee', 'bắt đầu', '$notes', '$currentDate')";

    $result_add_new_job = mysqli_query($conn, $sql_add_new_job);

    if ($result_add_new_job) {
        $id_job = mysqli_insert_id($conn);
        // Truy vấn thành công, thực hiện các hành động khác (nếu có)
        // ...
        echo "Đã thêm sản phẩm mới thành công";

        // Xử lý upload hình ảnh và tệp tin
        $uploadDir = '../upload/qc/';
        $imagesDir = $uploadDir . 'Images/';
        $filesDir = $uploadDir . 'FilesDocument/';

        // Kiểm tra số lượng file hình ảnh tải lên
        if (isset($_FILES["images"])) {
            $imageFiles = $_FILES["images"];
            $imageCount = count($imageFiles["name"]);

            for ($i = 0; $i < $imageCount; $i++) {
                $image = $imageFiles["name"][$i];
                $imageTmp = $imageFiles["tmp_name"][$i];

                // Kiểm tra xem có lỗi tải file hay không
                if ($imageFiles['error'][$i] !== UPLOAD_ERR_OK) {
                    echo "Lỗi khi tải file hình ảnh " . $image . ": " . $imageFiles['error'][$i];
                    continue; // Bỏ qua file lỗi và xử lý file tiếp theo
                }

                // Kiểm tra dung lượng mỗi file hình ảnh
                if ($imageFiles["size"][$i] > 5242880) { // Giới hạn dung lượng file: 5MB
                    echo "Dung lượng file hình ảnh " . $image . " vượt quá giới hạn cho phép (5MB).";
                    continue; // Bỏ qua file vượt quá dung lượng và xử lý file tiếp theo
                }

                // Tiến hành upload file hình ảnh
                $imageExtension = pathinfo($image, PATHINFO_EXTENSION);
                $timestamp = date('YmdHis');
                $unique_id = uniqid();
                $fileName = $timestamp . '_' . $unique_id . '.' . $imageExtension;
                $imagePath = $imagesDir . basename($fileName);

                if (move_uploaded_file($imageTmp, $imagePath)) {
                    // Lưu link hình ảnh vào CSDL hoặc làm bất kỳ xử lý nào khác
                    $sql_add_new_job_image = "INSERT INTO tbl_qcteamjob_image (qcteamjob_id, linkfile, create_at)
                                            VALUES ('$id_job', '$imagePath', '$currentDate')";
                    mysqli_query($conn, $sql_add_new_job_image);
                } else {
                    echo "Lỗi khi tải file hình ảnh " . $image . " lên server.";
                }
            }
        }

        // Kiểm tra số lượng file tệp tin tải lên
        if (isset($_FILES["filename"])) {
            $fileFiles = $_FILES["filename"];
            $fileCount = count($fileFiles["name"]);

            for ($i = 0; $i < $fileCount; $i++) {
                $file = $fileFiles["name"][$i];
                $fileTmp = $fileFiles["tmp_name"][$i];

                // Kiểm tra xem có lỗi tải file hay không
                if ($fileFiles['error'][$i] !== UPLOAD_ERR_OK) {
                    echo "Lỗi khi tải file tệp tin " . $file . ": " . $fileFiles['error'][$i];
                    continue; // Bỏ qua file lỗi và xử lý file tiếp theo
                }

                // Kiểm tra dung lượng mỗi file tệp tin
                if ($fileFiles["size"][$i] > 52428800) { // Giới hạn dung lượng file: 50MB
                    echo "Dung lượng file tệp tin " . $file . " vượt quá giới hạn cho phép (50MB).";
                    continue; // Bỏ qua file vượt quá dung lượng và xử lý file tiếp theo
                }

                // Tiến hành upload file tệp tin
                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                $timestamp = date('YmdHis');
                $unique_id = uniqid();
                $fileName = $timestamp . '_' . $unique_id . '.' . $fileExtension;
                $filePath = $filesDir . basename($fileName);

                if (move_uploaded_file($fileTmp, $filePath)) {
                    // Lưu link tệp tin vào CSDL hoặc làm bất kỳ xử lý nào khác
                    $sql_add_new_job_file = "INSERT INTO tbl_qcteamjob_file (qcteamjob_id, employee_id, linkfile, create_at)
                                            VALUES ('$id_job', '$nguoigiaoviec', '$filePath', '$currentDate')";
                    mysqli_query($conn, $sql_add_new_job_file);
                } else {
                    echo "Lỗi khi tải file tệp tin " . $file . " lên server.";
                }
            }
        }

        // Sau khi xử lý thành công, chuyển hướng về trang `qcteamjob.php`
        header('Location: qcteamjob.php');
        exit;
    } else {
        echo "Lỗi khi thêm yêu cầu làm mẫu vào CSDL: " . mysqli_error($conn);
    }
}
?>




<!-- <a class="btn btn-info btn-sm" href="/thinhcuong/qcteamjob/job_details.php?sid="">View</a> -->