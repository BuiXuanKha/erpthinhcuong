<?php 
    include '../header.php'; 
    include '../function/function.php';
    $productCustomers = getRecordTableById('tbl_product_customer','status','0');
    $customers = getRecordTableById('tbl_customer','status','0');
    $sid = $_GET['sid'];
    $product_customer_id = $_GET['sid'];
?>
<!-- Start -->
<div class="container custom-fixed-top">
    <form id="upload-form" method="POST" enctype="multipart/form-data">
        <div class="row text-center">
            <div class="col-md-12">
                <div class="mb-3">
                    <h1>THÊM VẬT TƯ TIÊU HAO SẢN PHẨM 
                    <?php 
                        echo getAllTableById(getAllTableById($sid,$productCustomers,'customer_id'),$customers,'fullname'). ' ';
                        echo getAllTableById($sid,$productCustomers,'product_customer_code');
                    ?>
                    </h1>
                    <hr>
                </div>
            </div>
        </div>
        <!-- TÊN VẬT TƯ -->
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="bom_id">Tìm kiếm danh sách vật tư:</label>
                    <select class="form-control" id="bom_id" name="bom_id">
                        <?php
                          $boms = getRecordTableById('tbl_bom','status','0');
                          $bom_colors = getRecordTableById('tbl_bom_color','status','0');
                        //   getAllTableById($bom["bom_color_id"],$bom_colors,'fullname')
                            if ($boms) {
                                    foreach ($boms as $bom) {
                                        echo '<option value="' . $bom["id"] . '">' . $bom["fullname"] .' | '.$bom["dimension_l"].' x '.$bom["dimension_w"].' x '.$bom["dimension_h"]. ' | '.getAllTableById($bom["bom_color_id"],$bom_colors,'fullname').'</option>';
                                    }
                                } else {
                                    echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.";
                                }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <!-- KÍCH THƯỚC -->
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="amount">Số lượng:</label>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="number" class="form-control" id="amount" name="amount" step="1"
                                min="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- GHI CHÚ
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="notes">Ghi chú:</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>
            </div>
        </div> -->
        <div class="mb-3 text-center">
            <button id="addBomButton" type="submit" class="btn btn-primary ">Add</button>
        </div>
    </form>
    <!-- HÌNH ẢNH SẢN PHẨM -->
    <div class="row">
        <div class="col-md-12">
            <div class="card my-4">
                <div class="card-header">
                    HÌNH ẢNH SẢN PHẨM KHI ĐƯỢC CHỌN
                </div>
                <div class="card-body">
                    <!-- Chỗ này sử dụng Light Box -->
                    <div class="tz-gallery">
                        <div class="image-gallery">
                        <?php 
                        // // Nếu hình ảnh đó có product_vendor_id = ID và  linkimage_avatar = 0 thì lấy hình ảnh
                        // // mục đích lấy hình ảnh của sản phẩm, nếu không có hình ảnh của sản phẩm thì có thể hiện nút Add thêm hình ảnh
                        // $whereimages ='status = 0 AND product_customer_product_id';
                        // // SELECT * FROM tbl_product_customer_image WHERE status = 0 AND product_customer_product_id = 46 ORDER BY create_at DESC
                        // $imageLinks = getRecordTableById('tbl_product_customer_image', $whereimages, $product_vendor_ids);
                        // // Hiển thị hình ảnh nếu có link
                        // if ($imageLinks) {
                        //     foreach($imageLinks as $imageLinka){
                        //         echo "<div class=\"gallery-item d-flex flex-column align-items-center \">";
                        //         echo "<a class=\"lightbox\" href=\"".$imageLinka['linkimage']."\">";
                        //         echo "<img src=\"".$imageLinka['linkimage']."\">";
                        //         echo "</a>";
                        //         echo "<hr>";
                        //         if($imageLinka['avatar'] == 1){
                        //             echo "<a class=\"btn btn-success \">Hình đại diện</a>";
                        //         }else{

                        //             echo "<a class=\"btn btn-info \" href=\"/thinhcuong/product_customer/setAvatar.php?idSetAvatar=".$imageLinka['id']."&product_customer_id=".$product_customer_id."\" >Set hình đại diện</a>";
                        //         }
                        //         echo "</div>";
                        //     }
                        // } else {
                        //     // Nếu không có hình ảnh nào thì có thể thêm add photo để nhân viên có thêm hình ảnh
                        //     echo "<a class=\"btn btn-info btn-sm\" href=\"#\">Add photo</a>";
                        // }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

document.getElementById('upload-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var formDataInput = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh
    
    var product_customer_id = <?php echo $product_customer_id;?>;
    var bom_id = document.getElementById('bom_id').value;
    var amount = document.getElementById('amount').value;
    console.log(product_customer_id);
    console.log(bom_id);
    console.log(amount);
    // var style_category_id = document.getElementById('style_category_id').value;

    var currentDate = new Date(); // Lấy thời gian hiện tại
    var year = currentDate.getFullYear();
    var month = String(currentDate.getMonth() + 1).padStart(2, '0');
    var day = String(currentDate.getDate()).padStart(2, '0');
    var hours = String(currentDate.getHours()).padStart(2, '0');
    var minutes = String(currentDate.getMinutes()).padStart(2, '0');
    var seconds = String(currentDate.getSeconds()).padStart(2, '0');

    var currentDate = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

    // formDataInput.append('style_category_id', style_category_id);
    formDataInput.append('product_customer_id', product_customer_id);
    formDataInput.append('bom_id', bom_id);
    formDataInput.append('amount', amount);
    formDataInput.append('currentDate', currentDate);

    var xhr_formDataInput = new XMLHttpRequest();
    // PHẦN NÀY QUAN TRỌNG
    // TRƯỚC KHI GỬI DỮ LIỆU ĐỂ THÊM VÀO CSDL DANH SÁCH VẬT TƯ DÙNG CHO SẢN PHẨM THÌ HÃY KIỂM TRA
    // XEM TRONG DANH SÁCH VẬT TƯ ĐÃ CÓ VẬT TƯ DỰ ĐỊNH THÊM VÀO CHƯA?
    // NẾU CÓ RỒI THÌ HÃY CẬP NHẬP SỐ LƯỢNG CHO SẢN
    xhr_formDataInput.open('POST', '/thinhcuong/product_customer/product_customer_bom_process.php', true);
    xhr_formDataInput.send(formDataInput);

    xhr_formDataInput.onload = function() {
        if (xhr_formDataInput.status === 200) {
            // echo 'Xử lý nhập dữ liệu thành công và csdl';
            
        }
    };



});
</script>
<?php include '../footer.php'; ?>