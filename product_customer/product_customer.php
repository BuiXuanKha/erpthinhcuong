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
            <a class="btn btn-info" href="/erpthinhcuong/product_customer/product_customer_add.php">Add</a>
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
                        <th>Customer</th>
                        <th>Product Code TC</th>
                        <th>Product Code Customer</th>
                        <th>Dimension</th>
                        <th>Fullname</th>
                        <th>Employees</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stt=1;
                        include '../function/function.php';
                        
                        $product_customers = getRecordTableById('tbl_product_customer','status','0');
                        $linkimages = getRecordTableById('tbl_product_vendor_images','linkimage_avatar','1');
                        $employees = getRecordTableById('tbl_employee','status','0');
                        $customers = getRecordTableById('tbl_customer','status','0');
                        $product_vendors = getRecordTableById('tbl_product_vendor','status','0');

                        // $productId = $product_vendor['id'];
                        $avatar = '1';
                        $columValue = 'linkimage';


                        if ($product_customers) {
                            foreach ($product_customers as $product_customer) {
                                echo "<tr>";
                                echo "<td>" . $stt++ . "</td>";
                                // Lấy link hình ảnh từ CSDL sử dụng hàm getLinkImages
                                $imageLink = getLinkImagesProductCustomer($product_customer['id'], $avatar, $columValue);
                                echo "<td>"; // Đây là cột để chứa hình ảnh hoặc thông báo
                                if ($imageLink) {
                                    // Hiển thị hình ảnh nếu có link
                                    echo "<a href=\"".$imageLink."\"><img  class=\"imgproduct\" src=\"".$imageLink."\" alt=\"Hình ảnh\"></a>";
                                } else {
                                    // Hiển thị thông báo nếu không có link
                                    echo "<a class=\"btn btn-info btn-sm\" href=\"#\">Add photo</a>";
                                }
                                echo "</td>";
                                echo "<td>" . getAllTableById($product_customer['customer_id'], $customers,'fullname') . "</td>";
                                // echo "<td>" . $product_customer['customer_id'] . "</td>";
                                echo "<td>" . getAllTableById($product_customer['product_vendor_id'], $product_vendors,'product_vendor_code') . "</td>";
                                echo "<td>" . $product_customer['product_customer_code'] . "</td>";
                                echo "<td>" . getAllTableById($product_customer['product_vendor_id'], $product_vendors,'dimension_l') ." x ".getAllTableById($product_customer['product_vendor_id'], $product_vendors,'dimension_w')." x ".getAllTableById($product_customer['product_vendor_id'], $product_vendors,'dimension_h'). " cm</td>";
                                echo "<td>" . $product_customer['fullname'] . "</td>";


                                echo "<td>" . getAllTableById($product_customer['employee_id'], $employees,'fullname') . "</td>";
                                echo "<td>
                                <a class=\"btn btn-info btn-sm\"
                                href=\"product_customer_details.php?sid=".$product_customer["id"]."&menu=product\">Details</a>
                                <a class=\"btn btn-info btn-sm\"
                                href=\"product_customer_delete.php?sid=".$product_customer["id"]."\" onclick=\"return confirmDelete('Sản phẩm');\">Del</a>
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