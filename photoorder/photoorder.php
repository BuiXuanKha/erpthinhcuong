<?php include '../header.php'?>
<div class="container-fluid mx-md-auto">
    <div class="row">
        <div class="col text-center">
            <h3>DANH SÁCH PHOTO ORDER <?php echo date('Y'); ?></h3>
            <hr>
        </div>
    </div>

    <div class="row">

        <div class="kha_list">
            <div class="kha_list_item">
            </div>
            <div class="kha_list_item1">
                <button type="button" class="btn btn-info">Add</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Customer</th>
                        <th>Date Inspection</th>
                        <th>Date Loading</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Employee</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stt=1;
                        include '../function/function.php';
                        
                        $photoorders = getAllTable('tbl_photoorder');
                        $employees = getAllTable('tbl_employee');
                        $customers = getAllTable('tbl_customer');
                        // Hiển thị dữ liệu
                        if ($photoorders) {
                            foreach ($photoorders as $photoorder) {
                                echo "<tr>";
                                echo "<td>" . $stt++ . "</td>";
                                echo "<td>" . getAllTableById($photoorder['customer_id'], $customers,'fullname') . "</td>";
                                echo "<td>" . $photoorder['date_inspection'] . "</td>";
                                echo "<td>" . $photoorder['date_loading'] . "</td>";
                                echo "<td>" . $photoorder['status'] . "</td>";
                                echo "<td>" . $photoorder['note'] . "</td>";
                                echo "<td>" . getAllTableById($photoorder['employee_id'], $employees,'fullname') . "</td>";
                                echo "<td><a class=\"btn btn-info\"
                                href=\"photoorder_view.php?sid=".$photoorder["id"]."\">View</a></td>";
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