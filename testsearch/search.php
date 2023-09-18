<?php
include '../function/function.php';
echo "<table id=\"myTable\" class=\"table table-striped table-bordered\" style=\"width:100%\">";
echo "<thead>";
echo "<tr>";
echo "<th>No.</th>";
echo "<th>Product Code (Thịnh Cường)</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
// Chỗ này này thiếu cái gì đó chưa xong
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    $getSearchProducts = getSearchProduct($keyword);
    if ($getSearchProducts) {
        foreach ($getSearchProducts as $getSearchProduct) {
            echo "<p>" . $getSearchProduct['product_vendor_code'] . "</p>";
        }
    } else {
        echo "<p>Không có kết quả phù hợp.</p>";
    }
}
echo "</tbody>";
echo "</table>";
?>