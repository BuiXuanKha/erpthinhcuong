<?php 
    include '../header.php';
    include '../function/function.php';
    $sid = $_GET['sid'];
    // $sid = 38;
    $dem = 0;
    $where ='status = 0 AND product_customer_id';
    $listBoms = getRecordTableById('tbl_product_customer_bom',$where,$sid);
    $customers = getRecordTableById('tbl_product_customer','id',$_GET['sid']);
    $product_vendors = getRecordTableById('tbl_customer','status','0');
    $boms = getRecordTableById('tbl_bom','status','0');
    $employees = getRecordTableById('tbl_employee','status','0');

    $productCustomers = getRecordTableById('tbl_product_customer','status','0');
    $colors = getRecordTableById('tbl_bom_color','status','0');
    $units = getRecordTableById('tbl_unit','status','0');
    // $customers = getRecordTableById('tbl_customer','status','0');
    // $sid = $_GET['sid'];
    $product_customer_id = $_GET['sid'];
?>
<div class="container-fluid mx-md-auto custom-fixed-top">
    <!-- TIÊU ĐỀ CỦA PAGES -->
    <div class="row">
        <div class="col text-center">
            <h3>DANH SÁCH VẬT TƯ CỦA SẢN PHẨM
                <?php 
                if($customers){
                    foreach($customers as $customer){
                        // echo getAllTableById($customer['customer_id'] , $product_vendors,'fullname');
                        echo strtoupper(getAllTableById($customer['customer_id'] , $product_vendors,'fullname')." | ".$customer['product_customer_code']);
                    }
                }
                ?>
            </h3>
            <hr>
        </div>
    </div>
    <!-- FORM CHỌN VẬT TƯ THÊM VÀO DANH SÁCH VẬT TƯ CỦA SẢN PHẨM -->
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
                            <input type="hidden" class="form-control" id="product_customer_id" name="product_customer_id" value="<?php echo $product_customer_id;?>">
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
                            <button id="addBomButton" type="submit" class="btn btn-info" onclick="addBomLiveSearch()">Thêm mới vật tư</button>
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
    </div>
    <!-- BUTTON CHỨC NĂNG -->
    <div class="row">
        <div class="kha_list">
            <div class="kha_list_item">
            </div>
            <div class="kha_list_item1">
                <!-- <a class="btn btn-info" href="/erpthinhcuong/product_customer/product_customer_add.php">Add</a> -->
            </div>
        </div>
    </div>
    <!-- TABLE DANH SÁCH VẬT TƯ CỦA SẢN PHẨM ĐƯỢC THÊM VÀO -->
    <div class="row">
        <div class="col-12">
            <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tên vật tư</th>
                        <th>Kích thước</th>
                        <th>Màu</th>
                        <th>Quy cách</th>
                        <th>Số lượng</th>
                        <th>Nhân viên</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                        if($listBoms){
                            foreach($listBoms as $listBom){
                                $dem++;
                                echo "<tr>";
                                echo "<td>".$dem."</td>";
                                echo "<td>".getAllTableById($listBom['bom_id'] , $boms,'fullname')."</td>"; 
                                echo "<td>".getAllTableById($listBom['bom_id'] , $boms,'dimension_l')." x ".getAllTableById($listBom['bom_id'] , $boms,'dimension_w')." x ".getAllTableById($listBom['bom_id'] , $boms,'dimension_h')."</td>";
                                // echo "<td>".getAllTableById($listBom['bom_id'] , $boms,'bom_color_id')."</td>";
                                echo "<td>".getAllTableById(getAllTableById($listBom['bom_id'] , $boms,'bom_color_id') , $colors,'fullname')."</td>";
                                echo "<td>".getAllTableById(getAllTableById($listBom['bom_id'] , $boms,'unit_id') , $units,'fullname')."</td>";
                                echo "<td>".$listBom['amount']."</td>";
                                echo "<td>".getAllTableById($listBom['employee_id'] , $employees,'fullname')."</td>";
                                echo "<td><a href=\"#\" class=\"btn btn-info btn-sm\">Edit</a> <a href=\"#\" class=\"btn btn-info btn-sm\">Del</a></td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>

<?php include '../footer.php'?>