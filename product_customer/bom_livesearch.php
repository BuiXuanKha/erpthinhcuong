<?php
session_start();
require_once '../connect.php';
include '../function/function.php';
$colors = getRecordTableById('tbl_bom_color','status','0');
$units = getRecordTableById('tbl_unit','status','0');
// $product_customer_id = $_GET['sid'];
// Kiểm tra nếu có dữ liệu được gửi từ cuộc gọi AJAX
if (isset($_POST['input'])) {
    $input = $_POST['input'];
    // Sử dụng truy vấn SQL để tìm kiếm các tên vật tư phù hợp
    $sql = "SELECT * FROM tbl_bom WHERE fullname LIKE '%$input%'";
    $result = mysqli_query($conn, $sql);

    echo "<div class=\"row\">";
        echo "<div class=\"col-12\">";
            echo "<table id=\"myTable\" class=\"table table-striped table-bordered\" style=\"width:100%\">";
                echo "<thead>";
                    echo "<tr>";
                       echo " <th>ID</th>";
                        echo "<th>Fullname</th>";
                        echo "<th>Dimension</th>";
                        echo "<th>Color</th>";
                        echo "<th>Unit</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>".$row['id']."</td>";
                            echo "<td>".$row['fullname']."</td>";
                            echo "<td>".$row['dimension_l']." x ".$row['dimension_l']." x ".$row['dimension_l']."</td>";
                            echo "<td>".getAllTableById($row['bom_color_id'],$colors,'fullname')."</td>";
                            echo "<td>".getAllTableById($row['unit_id'],$units,'fullname')."</td>";
                            // var $a = Ham($row['fullname'].);
                            echo "<td><a href=\"#\" class=\"btn btn-info btn-sm\" onclick=\"clickAddBom('".$row['fullname']."','".$row['id']."')\">Chọn</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo '<p>Không tìm thấy kết quả.</p>';
                    }
                } else {
                    echo '<p>Lỗi truy vấn: ' . mysqli_error($conn) . '</p>';
                }
                echo "</tbody>";
            echo "</table>";

        echo "</div>";
    echo "</div>";
    
}

// Đóng kết nối cơ sở dữ liệu
mysqli_close($conn);
?>
