<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ĐĂNG NHẬP HỆ THỐNG - ERP THỊNH CƯỜNG</title>
    <!-- Liên kết tệp CSS của Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-4 col-12">
            <h2 class="text-center mb-4">Đăng nhập</h2>
            <form action="login_process.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Tài khoản:</label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu:</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="mb-3 text-center">
                    <span id="error-message" class="text-danger"></span>
                </div>
                <div class="d-grid">
                    <input type="submit" value="Đăng nhập" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>

    <!-- Liên kết tệp JavaScript của Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Kiểm tra URL có chứa tham số "error" và giá trị là "1" hay không
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');

        if (error === '1') {
            const errorMessage = document.getElementById('error-message');
            errorMessage.textContent = 'Bạn đăng nhập không thành công';
        }
    </script>
</body>

</html>
