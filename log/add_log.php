<?php
// Đảm bảo rằng bạn đã đưa mã PHP của hàm addLog() vào tệp xử lý này hoặc đã kết nối đến cơ sở dữ liệu ở đầu tệp.
include '../function/function.php';
// Kiểm tra xem yêu cầu là POST và có thông tin ghi log hay không
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logComments"]) && isset($_POST["status"])) {
    // Lấy thông tin log từ yêu cầu Ajax
    $logComments = $_POST["logComments"];
    $status = $_POST["status"];

    // Gọi hàm addLog() để lưu thông tin vào bảng tbl_log
    addLog($logComments, $status);

    // Trả về kết quả thành công cho yêu cầu Ajax (nếu cần)
    echo "Log đã được ghi thành công.";
} else {
    // Trả về kết quả lỗi cho yêu cầu Ajax nếu không có thông tin ghi log
    http_response_code(400); // Bad Request
    echo "Lỗi: Thông tin log không hợp lệ.";
}
?>
