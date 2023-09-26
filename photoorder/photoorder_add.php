<?php
include '../header.php';
include '../function/function.php';
?>
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
            <div class="mb-3">
                <label for="searchProductAddOrder" class="mr-2 text-nowrap">Khách hàng:</label>
                <!-- THẺ SELECT CHỌN DANH SÁCH KHÁCH HÀNG -->
                <select class="form-control" id="customer_id" name="customer_id">
                    <?php 
                            $listCustomers = getRecordTableById('tbl_customer','status','0');
                            if($listCustomers){
                                // <option value="a">a</option>
                               foreach($listCustomers as $listCustomer){
                                    echo "<option value=\"".$listCustomer['id']."\">".$listCustomer['fullname']."</option>";
                               }
                            }
                        ?>
                </select>
            </div>
            <!-- NGÀY KIỂM  VÀ NGÀY XUẤT HÀNG-->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="amount" class="mr-2 text-nowrap">Ngày kiểm định:</label>
                        <input type="date" class="form-control" id="date_inspection" name="date_inspection"
                            min="<?php echo date('Y-m-d');?>" max="" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="amount" class="mr-2 text-nowrap">Ngày kiểm định:</label>
                        <input type="date" class="form-control" id="date_loading" name="date_loading"
                            min="<?php echo date('Y-m-d');?>" max="" required>
                    </div>
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
                    <textarea class="form-control" id="note" rows="5"></textarea>
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
                        <label for="searchProductAddOrder" class="mr-2 text-nowrap">Sản Phẩm:</label>
                        <!-- Input Search :
                            - Nhập thông tin tìm kiếm sản phẩm
                            - Sau khi chọn được sản phẩm thì hiện FULL NAME sản phẩm ở đây
                        -->
                        <input type="text" class="form-control" id="searchProductAddOrder" name="searchProductAddOrder" placeholder="Search...">
                        
                        <!-- Chỗ này lưu PHOTO ORDER ID -->
                        <!-- Nhưng chưa có thông tin về PHOTO ORDER ID nên cẩn nghiên cứu xử lý -->
                        <!-- <input type="hidden" class="form-control" id="photoorder_id" name="photoorder_id"
                            value="<php echo $product_customer_id;?>"> -->
                        <!-- chỗ này lưu PRODUCT CUSTOMER ID -->
                        <input type="hidden" class="form-control" id="product_customer_id" name="product_customer_id">
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
                        <button id="addBomButton" type="submit" class="btn btn-info" onclick="addProductPhotoOrder()">Add</button>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="mb-3 d-flex align-items-center">
                        <button id="addBomButton" type="submit" class="btn btn-info" onclick="addPhotoOrder()">TẠO ĐƠN HÀNG</button>
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
                        <th>Product Customer Code</th>
                        <th>Fullname</th>
                        <th>Amount</th>
                        <th>Employees</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stt=1;
                        $photoorder_product_temps = getRecordTableById('tbl_photoorder_product_temp','status','0');
                        $product_customers = getRecordTableById('tbl_product_customer','status','0');
                        $employees = getRecordTableById('tbl_employee','status','0');

                        if ($photoorder_product_temps) {
                            foreach ($photoorder_product_temps as $photoorder_product_temp) {
                                echo "<tr>";
                                echo "<td>" . $stt++ . "</td>";
                                // Thông tin sản phẩm (Mã Sản Phẩm, Tên Sản phẩm)
                                echo "<td>" .getAllTableById($photoorder_product_temp["product_customer_id"],$product_customers,'product_customer_code')."</td>";
                                echo "<td>" .getAllTableById($photoorder_product_temp["product_customer_id"],$product_customers,'fullname')."</td>";
                                echo "<td>" .$photoorder_product_temp["amount"]."</td>";
                                // Tên nhân viên
                                echo "<td>" .getAllTableById($photoorder_product_temp["employee_id"],$employees,'fullname')."</td>";
                                echo "<td>
                                <a class=\"btn btn-info btn-sm\"
                                href=\"product_customer_details.php?sid=".$photoorder_product_temp["id"]."&menu=product\">Details</a>
                                <a class=\"btn btn-info btn-sm\"
                                href=\"product_customer_delete.php?sid=".$photoorder_product_temp["id"]."\" onclick=\"return confirmDelete('Sản phẩm');\">Del</a>
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