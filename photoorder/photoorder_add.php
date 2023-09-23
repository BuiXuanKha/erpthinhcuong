<?php include '../header.php'?>
<div class="container-fluid mx-md-auto custom-fixed-top">
    <div class="row">
        <div class="col text-center">
            <h3>NHẬP THÔNG TIN ĐƠN HÀNG</h3>
            <hr>
        </div>
    </div>
    <div class="row">
        <!-- CỘT BÊN TRÁI -->
        <div class="col-md-6">
            <!-- KHÁCH HÀNG -->
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="searchBom" class="mr-2 text-nowrap">Khách hàng:</label>
                    <!-- THẺ SELECT CHỌN DANH SÁCH KHÁCH HÀNG -->
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>Article</option>
                        <option>Tikamoon</option>
                        <option>System U</option>
                        <option>Syma</option>
                        <option>TJX</option>
                    </select>
                </div>
            </div>
            <!-- NGÀY KIỂM  VÀ NGÀY XUẤT HÀNG-->
            <div class="col-md-12">
                    <div class="mb-3">
                        <label for="amount" class="mr-2 text-nowrap">Ngày kiểm định:</label>
                        <input type="date" class="form-control" id="deadline" name="deadline"
                            min="<?php echo date('Y-m-d');?>" max="" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="mr-2 text-nowrap">Ngày xuất hàng:</label>
                        <input type="date" class="form-control" id="deadline" name="deadline"
                            min="<?php echo date('Y-m-d');?>" max="" required>
                    </div>
            </div>
        </div>
        <!-- CỘT BÊN PHẢI -->
        <div class="col-md-6">
            <!-- GHI CHÚ ĐƠN HÀNG -->
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="amount" class="mr-2 text-nowrap">Ghi chú đơn hàng:</label>
                    <!-- NOTES GHI CHÚ ĐƠN HÀNG -->
                    <textarea class="form-control" id="note" rows="9"></textarea>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <!-- <form id="upload-form" method="POST" enctype="multipart/form-data"> -->
        <!-- TÊN VẬT TƯ -->
        <div class="row">
            <!-- CỘT BÊN TRÁI -->
            <div class="col-md-12 d-flex align-items-center">
                <!-- Danh sách vật tư -->
                <div class="col-md-7">
                    <div class="mb-3 d-flex align-items-center">
                        <label for="searchBom" class="mr-2 text-nowrap">Vật tư:</label>
                        <input type="hidden" class="form-control" id="product_customer_id" name="product_customer_id"
                            value="<?php echo $product_customer_id;?>">
                        <input type="text" class="form-control" id="searchBom" name="searchBom" placeholder="Search...">
                        <input type="hidden" class="form-control" id="bom_id" name="bom_id">
                    </div>
                </div>
                <!-- Số lượng -->
                <div class="col-md-2">
                    <div class="mb-3 d-flex align-items-center">
                        <label for="amount" class="mr-2 text-nowrap">Số lượng:</label>
                        <input type="number" class="form-control" id="amount" name="amount" step="1" min="0">
                    </div>
                </div>
                <!-- Button Add -->
                <div class="col-md-1">
                    <div class="mb-3 d-flex align-items-center">
                        <button id="addBomButton" type="submit" class="btn btn-info" onclick="CheckInput()">Add</button>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3 d-flex align-items-center">
                        <button id="addBomButton" type="submit" class="btn btn-info" onclick="addBomLiveSearch()">Thêm
                            mới sản phẩm</button>
                    </div>
                </div>
            </div>

        </div>
        <!-- </form> -->
    </div>
    <div class="row">
        <div id="searchresult">

        </div>
    </div>
    <hr>


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