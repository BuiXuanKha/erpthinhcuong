<?php
session_start();
$idSetAvatar = $_GET['idSetAvatar'];
$product_customer_id = $_GET['product_customer_id'];
include '../function/function.php';
// Kết nối đến CSDL
include '../connect.php';

// Bước 1: Tạo prepared statement để tìm ID của bản ghi avatar
$stmt = $conn->prepare("SELECT id FROM tbl_product_customer_image WHERE product_customer_product_id = ? AND avatar = 1");
$stmt->bind_param("i", $product_customer_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($tempStatusAvatar);
    $stmt->fetch();

    // Bước 2: Cập nhật lại trường avatar = 0
    $stmt = $conn->prepare("UPDATE tbl_product_customer_image SET avatar = 0 WHERE id = ?");
    $stmt->bind_param("i", $tempStatusAvatar);
    $stmt->execute();

    // Bước 3: Tiến hành cập nhật trạng thái
    $stmt = $conn->prepare("UPDATE tbl_product_customer_image SET avatar = 1 WHERE id = ?");
    $stmt->bind_param("i", $idSetAvatar);
    
    if ($stmt->execute()) {
        header('location:product_customer_details.php?sid='.$product_customer_id.'&menu=product');
        exit();
    } else {
        echo "Lỗi khi cập nhật trạng thái: " . $stmt->error;
    }
} else {
    $stmt = $conn->prepare("UPDATE tbl_product_customer_image SET avatar = 1 WHERE id = ?");
    $stmt->bind_param("i", $idSetAvatar);
    if ($stmt->execute()) {
        header('location:product_customer_details.php?sid='.$product_customer_id.'&menu=product');
        exit();
    } else {
        echo "Lỗi khi cập nhật trạng thái: " . $stmt->error;
    }
}

// Đóng kết nối
$stmt->close();
mysqli_close($conn);
?>
