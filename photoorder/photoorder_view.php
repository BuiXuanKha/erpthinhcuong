<?php
include '../header.php';
include '../function/function.php';
?>
<div class="container-fluid mx-md-auto custom-fixed-top">
    <div class="row">
        <div class="col text-center">
            <h1>DANH SÁCH SẢN PHẨM TRONG ĐƠN HÀNG .....</h1>
            <hr>
        </div>
    </div>
    <!-- BẢNG DANH SÁCH SẢN PHẨM CỦA ĐƠN HÀNG -->
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
                        $id = $_GET['sid'];
                        $stt=1;
                        $status = 'status = 0 AND photoorder_id';
                        $photoorder_product_temps = getRecordTableById('tbl_photoorder_product',$status,$id);
                        $product_customers = getRecordTableById('tbl_product_customer','status','0');
                        $employees = getRecordTableById('tbl_employee','status','0');

                        if ($photoorder_product_temps) {
                            foreach ($photoorder_product_temps as $photoorder_product) {
                                echo "<tr>";
                                echo "<td>" . $stt++ . "</td>";
                                // Thông tin sản phẩm (Mã Sản Phẩm, Tên Sản phẩm)
                                echo "<td>" .getAllTableById($photoorder_product["product_customer_id"],$product_customers,'product_customer_code')."</td>";
                                echo "<td>" .getAllTableById($photoorder_product["product_customer_id"],$product_customers,'fullname')."</td>";
                                echo "<td>" .$photoorder_product["amount"]."</td>";
                                // Tên nhân viên
                                echo "<td>" .getAllTableById($photoorder_product["employee_id"],$employees,'fullname')."</td>";
                                echo "<td>
                                <a class=\"btn btn-info btn-sm\"
                                href=\"product_customer_details.php?sid=".$photoorder_product["id"]."&menu=product\">Details</a>
                                <a class=\"btn btn-info btn-sm\"
                                href=\"#\" onclick=\"return confirmDelete('Sản phẩm');\">Del</a>
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
    <!-- BẢNG DANH SÁCH VẬT TƯ CỦA TẤT CẢ SẢN PHẨM TRONG ĐƠN HÀNG -->
    <hr>
    <div class="row">
        <div class="row">
            <div class="col text-center">
                <h1>DANH SÁCH NGUYÊN VẬT LIỆU SẢN XUẤT</h1>
            </div>
        </div>
        <div class="col-12">
            <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <!-- <th>Mã sản phẩm</th> -->
                        <th>Tên Nguyên Vật Liệu</th>
                        <th>Kích Thước</th>
                        <th>Màu Sắc</th>
                        <!-- <th>Quy Cách</th> -->
                        <th>Số Lượng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $id = $_GET['sid'];
                        $stt=1;
                        $status = 'status = 0 AND photoorder_id';
                        // Lấy danh sách nguyên vật liệu sản xuất by ID Đơn Hàng
                        $photoorder_products = getRecordTableById('tbl_photoorder_product',$status,$id);
                        $product_customers = getRecordTableById('tbl_product_customer','status','0');
                        $employees = getRecordTableById('tbl_employee','status','0');
                        $listBoms = getRecordTableById('tbl_bom','status','0');
                        $listColors = getRecordTableById('tbl_bom_color','status','0');

                        $product_customers = getRecordTableById('tbl_product_customer','status','0');
                        $materialData = array(); // Mảng tạm thời để lưu thông tin về nguyên vật liệu
                        
                        if ($photoorder_products) {
                            foreach($photoorder_products as $photoorder_product){
                                // 1. LẤY DANH SÁCH SẢN PHẨM THEO ID ĐƠN HÀNG
                                $id2 = $photoorder_product['product_customer_id'];
                                $status2 = 'status = 0 AND product_customer_id';
                                $product_customer_boms = getRecordTableById('tbl_product_customer_bom', $status2, $id2);
                                if ($product_customer_boms) {
                                    $stt2 = 1;
                                    foreach ($product_customer_boms as $product_customer_bom) {
                                        // THÊM CÁC TRƯỜNG KHÁC VÀO ĐÂY
                                        $id = $product_customer_bom['id'];
                                        $product_customer_id = $product_customer_bom['product_customer_id'];
                                        $bom_id = $product_customer_bom['bom_id'];
                                        $employee_id = $product_customer_bom['employee_id'];
                                        $amount = $product_customer_bom['amount'];
                                        $amount_So_Luong_San_Pham = $photoorder_product['amount'];
                                        $status = $product_customer_bom['status'];
                                        $create_at = $product_customer_bom['create_at'];
                                        // Kiểm tra xem nguyên vật liệu có tồn tại trong mảng tạm thời hay không
                                        if (!array_key_exists($bom_id, $materialData)) {
                                            // Nếu không có, thêm nguyên vật liệu vào mảng tạm thời
                                            $materialData[$bom_id] = array(
                                                'product_customer_id' => $product_customer_id,
                                                'bom_id' => $bom_id,
                                                'employee_id' => $employee_id,
                                                'amount' => $amount,
                                                'amount_So_Luong_San_Pham' => $amount_So_Luong_San_Pham,
                                                'status' => $status,
                                                'create_at' => $create_at,
                                            );
                                        }else{
                                            // Cộng thêm số lượng vào tổng số lượng
                                            $materialData[$bom_id]['amount'] += $amount;
                                        }
                                    }
                                }
                                // KẾT THÚC NHÁP
                                // $product_customer_boms = getRecordTableById('tbl_product_customer_bom',$status2,$id2);
                                // if($product_customer_boms){
                                //     $stt2 = 1;
                                //     foreach($product_customer_boms as $product_customer_bom){
                                //         // 2. LẤY DANH SÁCH NGUYÊN VẬT LIỆU THEO ID SẢN PHẨM
                                //         $TongSoLuong = $product_customer_bom['amount'] * $photoorder_product['amount'] ;
                                //         echo "<tr>";
                                //             echo "<td>".$stt++."</td>";
                                //             // echo "<td>".getAllTableById($photoorder_product['product_customer_id'],$product_customers,'product_customer_code')."</td>";
                                //             echo "<td>".getAllTableById($product_customer_bom['bom_id'],$listBoms,'fullname')."</td>";
                                //             // echo "<td>Kích thước</td>";
                                //             // echo "<td>Màu sắc</td>";
                                //             // echo "<td>Quy cách</td>";
                                //             echo "<td>Sl: ".$product_customer_bom['amount']." x ".$photoorder_product['amount']." = ".$TongSoLuong."</td>";
                                //         echo "</tr>";
                                //     }
                                // }

                            }

                        } else {
                            echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.";
                        }
                        // SAU KHI ĐÃ THÊM VÀO 1 MẢNG NHÁP VÀ ĐÃ CỘNG SỐ LƯỢNG THÌ GIỜ IN RA THÔI
                        foreach ($materialData as $material) {
                            echo "<tr>";
                            echo "<td>".$stt++."</td>";
                            // echo "<td>".$material['product_customer_id']."</td>";
                            // echo "<td>".getAllTableById($material['product_customer_id'],$product_customers,'product_customer_code')."</td>";
                            echo "<td>".getAllTableById($material['bom_id'], $listBoms, 'fullname')."</td>";
                            echo "<td>".getAllTableById($material['bom_id'], $listBoms, 'dimension_l')." x ".getAllTableById($material['bom_id'], $listBoms, 'dimension_w')." x ".getAllTableById($material['bom_id'], $listBoms, 'dimension_h')."</td>";
                            // echo "<td>".getAllTableById($material['bom_id'], $listBoms, 'bom_color_id')."</td>";
                            echo "<td>".getAllTableById(getAllTableById($material['bom_id'], $listBoms, 'bom_color_id'), $listColors, 'fullname')."</td>";
                            echo "<td>".number_format($material['amount']*$material['amount_So_Luong_San_Pham'], 0)." PCS </td>";
                            echo "</tr>";
                        }
                        ?>
                </tbody>
            </table>

        </div>
    </div>
</div>
<?php include '../footer.php'?>