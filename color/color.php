<?php include '../header.php'?>
<div class="container-fluid mx-md-auto">
    <div class="row">
        <div class="col text-center">
            <h3>DANH SÁCH BẢNG MÃ MÀU THỊNH CƯỜNG</h3>
            <hr>
        </div>
    </div>

    <div class="row">

        <div class="kha_list">
            <div class="kha_list">
                <!-- <button onclick="printPage()" class="btn btn-info">Print</button><br> -->
                <div class="kha_list_item">
                </div>
            </div>
            <div class="kha_list_item1">
                <a href="./color_add.php" class="btn btn-info">Add</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name Color</th>
                        <th>Color Code</th>
                        <th>Spectro</th>
                        <th>Customers</th>
                        <th>Images</th>
                        <th class="mobile-hidden">Employees</th> 
                        <th class="mobile-hidden">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stt=1;
                        include '../function/function.php';
                        
                        $colors = getRecordTableById('tbl_color','status','0');
                        $employees = getAllTable('tbl_employee');
                        $customers = getAllTable('tbl_customer');
                        
                        // Hiển thị dữ liệu
                        if ($colors) {
                            foreach ($colors as $color) {
                                echo "<tr>";
                                echo "<td>" . $stt++ . "</td>";
                                echo "<td>" . $color['name'] . "</td>";
                                echo "<td>" . $color['color_code'] . "</td>";
                                echo "<td>" . $color['spectrophotometer'] . "</td>";
                                echo "<td>" . getAllTableById($color['customer_id'], $customers,'fullname') . "</td>";
                                if($color['linkimage']==null){
                                    echo "<td> Chưa có hình ảnh </td>";
                                }else{
                                    echo "<td> <img class=\"imagesColor\" src=\"". $color['linkimage'] ."\" alt=\"Hình ảnh màu\"> </td>";
                                }
                                
                                // echo "<td>" . $color['linkimage'] . "</td>";
                                echo "<td class=\"mobile-hidden\">" . getAllTableById($color['employee_id'], $employees,'fullname') . "</td>";
                                echo "<td><a class=\"btn btn-info btn-sm\"
                                href=\"color_delete.php?sid=".$color["id"]."&menu=product\">Delete</a></td>";
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