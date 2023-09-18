<?php include '../header.php'; ?>

<div class="container-fluid mx-md-auto">
    <div class="card my-4">
        <div class="card-header font-weight-bold">
            Danh sách Log
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Log Comments</th>
                            <th>Status</th>
                            <th>Create At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Kết nối đến cơ sở dữ liệu (sử dụng các thông số kết nối của bạn)
                        include '../connect.php';

                        // Thực hiện truy vấn để lấy danh sách log từ bảng tbl_log
                        // $query = "SELECT * FROM tbl_log";
                        // Thực hiện truy vấn để lấy danh sách log từ bảng tbl_log, sắp xếp theo ngày giờ tạo mới nhất
                        $query = "SELECT * FROM tbl_log ORDER BY create_at DESC";
                        $result = mysqli_query($conn, $query);

                        // Kiểm tra nếu có dữ liệu trả về
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['logcomments']}</td>";
                                echo "<td>{$row['status']}</td>";
                                echo "<td>{$row['create_at']}</td>";
                                echo "</tr>";
                            }
                        } else {
                            // Nếu không có log nào trong bảng tbl_log
                            echo "<tr><td colspan='4'>Không có log nào.</td></tr>";
                        }

                        // Đóng kết nối
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>
