<?php
session_start();
// Xóa tất cả các session hiện tại
session_destroy();


// Redirect đến trang đăng nhập
header('Location: ../index.php');
exit;
?>
