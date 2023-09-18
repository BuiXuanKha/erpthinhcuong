<?php include '../header.php'?>
<div class="container-fluid mx-md-auto">
    <!-- chỗ này sẽ thêm button Export -->
    <div class="row">
        <div class="col text-center">
            <h3>DANH SÁCH SẢN PHẨM THỊNH CƯỜNG</h3>
            <hr>
        </div>
    </div>

    <div class="row">

        <div class="kha_list">
            <div class="kha_list_item">
            </div>
            <div class="kha_list_item1">
                <!-- Example single danger button -->
                <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Add
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/erpthinhcuong/product/product_addold.php">Add Product Old</a>
                        </li>
                        <li><a class="dropdown-item" href="/erpthinhcuong/product/product_addnew.php">Add Product New</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Images</th>
                        <th>Product Code (Thịnh Cường)</th>
                        <th>Dimension</th>
                        <th>NW (Kg)</th>
                        <th>Style</th>
                        <th>Employees</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stt=1;
                        include '../function/function.php';
                        
                        $product_vendors = getRecordTableById('tbl_product_vendor','status','0');
                        $linkimages = getRecordTableById('tbl_product_vendor_images','linkimage_avatar','1');
                        $employees = getRecordTableById('tbl_employee','status','0');
                        $styles = getRecordTableById('tbl_product_vendor_style','status','0');


                        // $productId = $product_vendor['id'];
                        $avatar = '1';
                        $columValue = 'linkimage';


                        if ($product_vendors) {
                            foreach ($product_vendors as $product_vendor) {
                                echo "<tr>";
                                echo "<td>" . $stt++ . "</td>";
                                // Lấy link hình ảnh từ CSDL sử dụng hàm getLinkImages
                                $imageLink = getLinkImages($product_vendor['id'], $avatar, $columValue);
                                echo "<td>"; // Đây là cột để chứa hình ảnh hoặc thông báo
                                if ($imageLink) {
                                    // Hiển thị hình ảnh nếu có link
                                    echo "<a href=\"".$imageLink."\"><img  class=\"imgproduct\" src=\"".$imageLink."\" alt=\"Hình ảnh\"></a>";
                                } else {
                                    // Hiển thị thông báo nếu không có link
                                    echo "<a class=\"btn btn-info btn-sm\" href=\"#\">Add photo</a>";
                                }
                                echo "</td>";
                                echo "<td>" . $product_vendor['product_vendor_code'] . "</td>";

                                echo "<td>" . $product_vendor['dimension_l'] ." x ".$product_vendor['dimension_w']." x ".$product_vendor['dimension_h']. " cm</td>";
                                echo "<td>" . $product_vendor['netweight'] . " kg</td>";
                                echo "<td>" . getAllTableById($product_vendor['style_id'] , $styles,'fullname') . "</td>";

                                echo "<td>" . getAllTableById($product_vendor['employee_id'], $employees,'fullname') . "</td>";
                                echo "<td>
                                <a class=\"btn btn-info btn-sm\"
                                href=\"product_details.php?sid=".$product_vendor["id"]."&menu=product\">Details</a>
                                <a class=\"btn btn-info btn-sm\"
                                href=\"product_delete.php?sid=".$product_vendor["id"]."\" onclick=\"return confirmDelete('Sản phẩm');\">Del</a>
                                </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.";
                        }
                        ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php include '../footer.php'?>