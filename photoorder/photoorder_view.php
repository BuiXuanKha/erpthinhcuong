<?php
include '../header.php';
include '../function/function.php';
?>
<div class="container-fluid mx-md-auto custom-fixed-top">
    <div class="row">
        <div class="col text-center">
            <h3>DANH SÁCH SẢN PHẨM TRONG ĐƠN HÀNG .....</h3>
            <hr>
        </div>
    </div>
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