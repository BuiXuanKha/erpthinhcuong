<?php include '../header.php'; ?>
<div class="container-fluid mx-md-auto custom-fixed-top">
    <div class="row">
        <div class="col text-center">
            <h3>THÊM MÃ MÀU MỚI </h3>
            <hr>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <form action="color_add_process.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="sid_employee" name="sid_employee" value="<?php echo $_SESSION['sid_employee'];?>">

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="color_code">Color code:</label>
                    <input type="text" class="form-control" id="color_code" name="color_code" required>
                </div>
                <div class="form-group">
                    <label for="customer_id">Khách hàng:</label>
                    <select class="form-control" id="customer_id" name="customer_id">
                        <?php
                          include '../function/function.php';
                          $getAllTableCustomers = getRecordTableById('tbl_customer','status','0');
                            if ($getAllTableCustomers) {
                                    foreach ($getAllTableCustomers as $getAllTableCustomer) {
                                        echo '<option value="' . $getAllTableCustomer["id"] . '">' . $getAllTableCustomer["fullname"] . '</option>';
                                    }
                                } else {
                                    echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.";
                                }
                        
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="spectrophotometer">Spectro:</label>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="spectrophotometer1" name="spectrophotometer1">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="spectrophotometer2" name="spectrophotometer2">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="spectrophotometer3" name="spectrophotometer3">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                <label class="form-label">File image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>