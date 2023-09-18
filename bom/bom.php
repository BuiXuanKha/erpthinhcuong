<?php include '../header.php'?>
<div class="container-fluid mx-md-auto custom-fixed-top">
    <div class="row">
        <div class="col text-center">
            <h3>DANH SÁCH VẬT TƯ TIÊU HAO</h3>
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
                <a href="./bom_add.php" class="btn btn-info">Add</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên vật tư</th>
                        <th>Kích thước</th>
                        <th>Màu sắc</th>
                        <th>Đơn vị tính</th>
                        <th>Ghi chú</th>
                        <th class="mobile-hidden">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stt=1;
                        include '../function/function.php';
                        
                        $boms = getRecordTableById('tbl_bom','status','0');
                        $units =  getRecordTableById('tbl_unit','status','0');
                        $employees = getRecordTableById('tbl_employee','status','0');
                        $customers = getRecordTableById('tbl_customer','status','0');
                        $bom_colors = getRecordTableById('tbl_bom_color','status','0');
                        
                        // Hiển thị dữ liệu
                        if ($boms) {
                            foreach ($boms as $bom) {
                                echo "<tr>";
                                echo "<td>" . $stt++ . "</td>";
                                echo "<td>" . $bom['fullname'] . "</td>";
                                echo "<td>" . $bom['dimension_l'] ." x ".$bom['dimension_w']." x ".$bom['dimension_h']. "</td>";
                                echo "<td>" . getAllTableById($bom['bom_color_id'], $bom_colors,'fullname') . "</td>";
                                echo "<td>" . getAllTableById($bom['unit_id'], $units,'fullname') . "</td>";
                                echo "<td>" . $bom['note'] . "</td>";
                                
                                echo "<td>
                                <a class=\"btn btn-info btn-sm\"
                                href=\"color_edit.php?sid=".$bom["id"]."&menu=product\">Edit</a> 
                                <a class=\"btn btn-info btn-sm\"
                                href=\"color_delete.php?sid=".$bom["id"]."&menu=product\">Delete</a>
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