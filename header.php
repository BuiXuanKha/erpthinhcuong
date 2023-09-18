<?php
session_start(); // khởi động phiên làm việc

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
	header('Location: /erpthinhcuong/login/login.php'); // chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
}

// Hiển thị thông tin chào mừng
// echo "Chào mừng " . $_SESSION['username'] . " đến với trang web của chúng tôi!";
?>
<!-- header.php -->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP - THỊNH CƯỜNG</title>
    <!-- Bootstrap 4.5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- <link href="/erpthinhcuong/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-vb08Am/lJYxXaTTie52GF/1N97SDheN4qujE6qC7Yggm5hsBp3HRN4fbILlWOMggGSD6MTitIK1f8J63zeqruw=="
        crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Từ Data Table -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">

    <!-- Font  Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="/erpthinhcuong/css/style.css" />

    <!-- LightBox -->
    <!-- Link tham khảo: https://www.youtube.com/watch?v=k-RtYiiB47E -->
    <link href="https://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
    <link rel="stylesheet" href="/erpthinhcuong/css/gallery-grid.css">
    <!-- MDbootstrap -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet" /> -->
    <script src="/erpthinhcuong/js/menu.js"></script>
</head>

<body>
    <header>
        <!-- Sticky-top vẫn chưa được, không hiểu tại sao -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><img src="/erpthinhcuong/imgs/logo.jpg" alt="Logo"
                        style="width: 35px;"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link"
                                href="/erpthinhcuong/photoorder/photoorder.php?menu=photoorder">PhotoOrder</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/erpthinhcuong/product/product.php?menu=product">Product TC</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/erpthinhcuong/product_customer/product_customer.php?menu=product_customer">Product Customer</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                                href="/erpthinhcuong/development/development.php?menu=development">Development</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/erpthinhcuong/warehouse/warehouse.php?menu=warehouse">Warehouse</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/erpthinhcuong/job/job.php?menu=job">Job</a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle " href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Other
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="/erpthinhcuong/color/color.php?menu=color">Color</a>
                                </li>
                                <li><a class="dropdown-item" href="/erpthinhcuong/fabric/fabric.php">Fabric</a></li>
                                <li><a class="dropdown-item" href="#">Rope</a></li>
                                <li><a class="dropdown-item" href="#">Wood</a></li>
                                <li><a class="dropdown-item" href="#">Frame</a></li>
                                <li><a class="dropdown-item" href="#">Ceramic</a></li>
                                <li><a class="dropdown-item" href="/erpthinhcuong/bom/bom.php">DS Vật tư tiêu hao</a></li>
                                <li><a class="dropdown-item" href="#">Unit</a></li>
                            </ul>
                        </li>
                      
                    </ul>
                </div>



                <!-- <i class="far fa-bell" style="color: #ffffff;"></i> -->
                <i class="far fa-bell fa-lg" style="color: #ffffff;"></i>
                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION['fullname'].' - '. $_SESSION['department_name'];
                            ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-building"></i> Thông tin chi tiết</a>
                            </li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-key"></i> Đổi mật khẩu</a></li>
                            <?php 
                                if($_SESSION['fullname'] == 'Bùi Xuân Khả'){
                                    echo "<li><a class=\"dropdown-item\" href=\"/erpthinhcuong/log/log_details.php\"><i class=\"fas fa-key\"></i> Log hệ thống</a></li>";
                                    echo "<li><a class=\"dropdown-item\" href=\"/erpthinhcuong/qcteamjob2/qcteamjob.php\">QC2</a></li>";
                                }
                            ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/erpthinhcuong/login/logout.php"><i
                                        class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>