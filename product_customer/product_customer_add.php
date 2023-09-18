<?php 
    include '../header.php'; 
    include '../function/function.php';
    $idDepartment = $_SESSION['department_id'];
    $product_vendorss = getRecordTableById('tbl_product_vendor','status','0');

    if($product_vendorss){
       foreach($product_vendorss as $product_vendorsa){
           
       }
    }
    
?>

<div class="container custom-fixed-top">
    <form id="upload-form" method="POST" enctype="multipart/form-data">
        <div class="row text-center">
            <div class="col-md-12">
                <div class="mb-3">
                    <h1>THÊM SẢN PHẨM MỚI CỦA KHÁCH HÀNG</h1>
                    <hr>
                </div>
            </div>
        </div>
        <!-- Product Thịnh Cường -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="product_vendor_id" class="form-label">List sản phẩm TC để chọn:</label>


                    <select name="product_vendor_id" class="form-select" id="product_vendor_id"
                        onchange="getSelectedValue()">
                        <!-- <option value="">Chọn Mã Sản Phẩm TC</option> -->
                        <?php 
                            // $productVendors = getRecordTableById('tbl_product_vendor','status','0');
                            $product_vendors = getRecordTableById('tbl_product_vendor','status','0');
                            $styles = getRecordTableById('tbl_product_vendor_style','status','0');
                            if($product_vendors){
                                // <option value="a">a</option>
                               foreach($product_vendors as $product_vendor){
                                    echo "<option value=\"".$product_vendor['id']."\">".$product_vendor['product_vendor_code']." | ".getAllTableById($product_vendor['style_id'], $styles,'fullname')."</option>";
                               }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class=" col-md-6">
                <div class="mb-3">
                    <label for="product_customer_code" class="form-label">Product Customer Code:</label>
                    <input type="text" class="form-control" id="product_customer_code" name="product_customer_code"
                        required>
                </div>
            </div>
        </div>
        <!-- Product Name and Customers-->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="product_customer_fullname" class="form-label">Product Name:</label>
                    <input type="text" class="form-control" id="product_customer_fullname"
                        name="product_customer_fullname" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="product_customer_id" class="form-label">Customers:</label>
                    <select name="product_customer_id" class="form-select" id="product_customer_id">
                        <!-- <option value="">Chọn Khách Hàng</option> -->
                        <?php 
                            $customers = getRecordTableById('tbl_customer','status','0');
                            
                            if($customers){
                                // <option value="a">a</option>
                               foreach($customers as $customer){
                                    echo "<option value=\"".$customer['id']."\">".$customer['fullname']."</option>";
                               }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <!-- Weight product -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <!-- Cái này lấy bên Vendor -->
                    <label for="netweight" class="form-label">Net Weight:</label>
                    <input type="number" class="form-control" id="netweight" name="netweight" value="<?php echo $product_vendorsa['netweight']; ?>" required min="0"
                        step="0.1" disabled>

                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="grossweight" class="form-label">Gross Weight:</label>
                    <input type="number" class="form-control" id="grossweight" name="grossweight" required min="0"
                        step="0.1">
                </div>
            </div>
        </div>
        <!-- Dimension product -->
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="dimension" class="form-label">Dimension:</label>
                    <div class="form-row">
                        <div class="col">
                            <input type="number" class="form-control" id="dimension_l" name="dimension_l"
                                value="<?php echo $product_vendorsa['dimension_l']; ?>" required min="0" step="0.1"
                                disabled>
                        </div>cm
                        <div class="col">
                            <input type="number" class="form-control" id="dimension_w" name="dimension_w"
                                value="<?php echo $product_vendorsa['dimension_w']; ?>" required min="0" step="0.1"
                                disabled>
                        </div>cm
                        <div class="col">
                            <input type="number" class="form-control" id="dimension_h" name="dimension_h"
                                value="<?php echo $product_vendorsa['dimension_h']; ?>" required min="0" step="0.1"
                                disabled>
                        </div>cm
                    </div>

                </div>
            </div>
        </div>
        <!-- Dimension carton -->
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="dimension" class="form-label">Dimension Carton:</label>
                    <div class="form-row">
                        <div class="col">
                            <input type="number" class="form-control" id="carton_l" name="carton_l" required min="0"
                                step="0.1">
                        </div>cm
                        <div class="col">
                            <input type="number" class="form-control" id="carton_w" name="carton_w" required min="0"
                                step="0.1">
                        </div>cm
                        <div class="col">
                            <input type="number" class="form-control" id="carton_h" name="carton_h" required min="0"
                                step="0.1">
                        </div>cm
                    </div>

                </div>
            </div>
        </div>
        <!-- Dimension dolly -->
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="dimension" class="form-label">Dimension Dolly:</label>
                    <div class="form-row">
                        <div class="col">
                            <input type="number" class="form-control" id="dolly_l" name="dolly_l" required min="0"
                                step="0.1">
                        </div>cm
                        <div class="col">
                            <input type="number" class="form-control" id="dolly_w" name="dolly_w" required min="0"
                                step="0.1">
                        </div>cm
                        <div class="col">
                            <input type="number" class="form-control" id="dolly_h" name="dolly_h" required min="0"
                                step="0.1">
                        </div>cm
                    </div>

                </div>
            </div>
        </div>
        <!-- Dimension pallet -->
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="dimension" class="form-label">Dimension Pallet:</label>
                    <div class="form-row">
                        <div class="col">
                            <input type="number" class="form-control" id="pallet_l" name="pallet_l" required min="0"
                                step="0.1">
                        </div>cm
                        <div class="col">
                            <input type="number" class="form-control" id="pallet_w" name="pallet_w" required min="0"
                                step="0.1">
                        </div>cm
                        <div class="col">
                            <input type="number" class="form-control" id="pallet_h" name="pallet_h" required min="0"
                                step="0.1">
                        </div>cm
                    </div>

                </div>
            </div>
        </div>
        <!-- Cái ba lăng nhăng -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="frame_id" class="form-label">Farme:</label>
                    <select name="frame_id" class="form-select" id="frame_id">
                        <!-- <option value="">Chọn Khách Hàng</option> -->
                        <?php 
                            $frames = getRecordTableById('tbl_frame','status','0');
                            if($frames){
                                // <option value="a">a</option>
                               foreach($frames as $frame){
                                    echo "<option value=\"".$frame['id']."\">".$frame['name']."</option>";
                               }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="wood_id" class="form-label">Wood:</label>
                    <select name="wood_id" class="form-select" id="wood_id">
                        <!-- <option value="">Chọn Khách Hàng</option> -->
                        <?php 
                            $woods = getRecordTableById('tbl_wood','status','0');
                            if($woods){
                                // <option value="a">a</option>
                               foreach($woods as $wood){
                                    echo "<option value=\"".$wood['id']."\">".$wood['name']."</option>";
                               }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="rope_id" class="form-label">Rope:</label>
                    <select name="rope_id" class="form-select" id="rope_id">
                        <!-- <option value="">Chọn Khách Hàng</option> -->
                        <?php 
                            $ropes = getRecordTableById('tbl_rope','status','0');
                            if($ropes){
                                // <option value="a">a</option>
                               foreach($ropes as $rope){
                                    echo "<option value=\"".$rope['id']."\">".$rope['name']."</option>";
                               }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="fabric_id" class="form-label">Fabric:</label>
                    <select name="fabric_id" class="form-select" id="fabric_id">
                        <!-- <option value="">Chọn Khách Hàng</option> -->
                        <?php 
                            $fabrics = getRecordTableById('tbl_fabric','status','0');
                            if($fabrics){
                                // <option value="a">a</option>
                               foreach($fabrics as $fabric){
                                    echo "<option value=\"".$fabric['id']."\">".$fabric['name']."</option>";
                               }
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <!-- Color -->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ceramic_id" class="form-label">Ceramic:</label>
                    <select name="ceramic_id" class="form-select" id="ceramic_id">
                        <!-- <option value="">Chọn Khách Hàng</option> -->
                        <?php 
                            // $ceramics = getAllTable('tbl_ceramic');
                            $ceramics = getRecordTableById('tbl_ceramic','status','0');
                            if($ceramics){
                                // <option value="a">a</option>
                               foreach($ceramics as $ceramic){
                                    echo "<option value=\"".$ceramic['id']."\">".$ceramic['name']."</option>";
                               }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="color_id" class="form-label">Color:</label>
                    <select name="color_id" class="form-select" id="color_id">
                        <!-- <option value="">Chọn màu sản phẩm</option> -->
                        <?php 
                            $colors = getRecordTableById('tbl_color','status','0');
                            
                            if($colors){
                                // <option value="a">a</option>
                               foreach($colors as $color){
                                    echo "<option value=\"".$color['id']."\">".getAllTableById($color['customer_id'],$customers,'fullname')." - ".$color['color_code']."</option>";
                               }
                            }
                        ?>
                    </select>
                </div>
            </div>
            
        </div>
        <!-- Upload photo -->
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="file_upload_image">Upload Images (PNG, JPG)</label>
                    <input type="file" name="file_upload_image[]" id="file_upload_image" class="form-control" multiple
                        accept=".png, .jpg, .jpeg">
                    <!-- accept=".png, .jpg, .jpeg" -->
                </div>
                <div class="mb-3">
                    <span class="errorFileImage error-message"></span>
                </div>
            </div>
            <div class="mb-3 text-center">
                <button id="addJobButton" type="submit" class="btn btn-primary ">Add Product</button>
            </div>
        </div>
    </form>
</div>
<!-- Chỗ này cần cách Top 72px để có thể nhìn thấy -->
<div class="container custom-fixed-top">
    <div id="progress_container_image" class="mt-4" style="display: none;">
        <span>File hình ảnh đang được tải lên máy chủ...</span>
        <div id="progress_bar_image" class="progress">
            <div class="progress_bar_image" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                aria-valuemax="100"></div>
        </div>
        <div id="progress_text_image" class="mt-2">0%</div>
        <div id="countdown_image" class="mt-2">Thời gian tải file còn: 0 seconds</div>
    </div>
</div>

<script>
function getSelectedValue() {
    var selectElement = document.getElementById("product_vendor_id");
    var selectedValue = selectElement.value;

    $.ajax({
        type: "POST",
        url: "getIdProductVendor.php",
        data: {
            selectedValue: selectedValue
        },
        success: function(response) {
            // Kiểm tra xem response có dữ liệu hay không
            if (response) {
                // Giải mã JSON trả về thành mảng
                var data = JSON.parse(response);
                // In ra cấu trúc mảng data trên console để xem
                // console.log(data);
                // Kiểm tra xem có dữ liệu trong mảng không
                if (data.length > 0) {
                    // Lấy giá trị netweight từ mảng data (giả sử netweight là một trường trong mảng)
                    var netweight = data[0].netweight;
                    var dimension_l = data[0].dimension_l;
                    var dimension_w = data[0].dimension_w;
                    var dimension_h = data[0].dimension_h;
                    // Gán giá trị vào trường input
                    document.getElementById("netweight").value = netweight;
                    document.getElementById("dimension_l").value = dimension_l;
                    document.getElementById("dimension_w").value = dimension_w;
                    document.getElementById("dimension_h").value = dimension_h;
                } else {
                    // Nếu không có dữ liệu, bạn có thể xử lý tùy ý, ví dụ: đặt giá trị mặc định
                    document.getElementById("netweight").value = "";
                    document.getElementById("dimension_l").value = "";
                    document.getElementById("dimension_w").value = "";
                    document.getElementById("dimension_h").value = "";
                }
            } else {
                // Xử lý khi không có dữ liệu được trả về
                console.log("Không có dữ liệu được trả về từ máy chủ.");
            }
        }

    });
}


// START - xử lý phần upload vượt quá 50 file, và dung lượng vượt quá 500mb của
// http://localhost/erpthinhcuong/product
document.addEventListener('DOMContentLoaded', function() {
    getSelectedValue();
    const maxFileSize = 500 * 1024 * 1024; // 500MB in bytes
    const maxImageCount = 50;
    const maxDocumentCount = 50;
    const imagesInput = document.getElementById('file_upload_image');
    const addJobButton = document.getElementById('addJobButton');
    const errorFileImage = document.querySelector('.errorFileImage');

    imagesInput.addEventListener('change', handleImagesChange);

    addJobButton.disabled = false;

    function handleImagesChange(event) {
        errorFileImage.textContent = '';

        const files = event.target.files;
        let totalImageSize = 0;
        let imageCount = 0;
        let oversizedFiles = [];

        for (const file of files) {
            if (file.type.startsWith('image/')) {
                // Cổng tổng dung lượng file
                totalImageSize += file.size;
                imageCount++;
                // Nếu duyệt qua các file, nếu file nào có dung lượng lớn hơn 500MB thì PUSH vào mảng oversizedFiles[]
                if (file.size > maxFileSize) {
                    oversizedFiles.push(file);
                }
            }
        }
        // nếu mà số lượng file lớn hơn 50 file thì bằng TRUE
        if (imageCount > maxImageCount) {
            errorFileImage.textContent = 'Số lượng file vượt quá quy định 50 file hình ảnh.';
            addJobButton.disabled = true;
        } else { // Nếu mà số lượng file nhỏ hơn 50 file
            if (addJobButton.disabled ==
                true) { // Nếu khi chọn lại file hình ảnh mà số lượng file < 50 và trạng thái bằng TRUE
                // Chỗ này Đúng Đúng Sai Sai mệt lắm đấy.
                addJobButton.disabled = false;
            }
        }
        // Nếu mảng oversizedFiles[].lenght lớn hơn 0 tức là có file không đạt yêu cầu, thì thông báo
        if (oversizedFiles.length > 0) {
            const oversizedFileMessages = oversizedFiles.map(file =>
                `${file.name}, dung lượng ${formatFileSize(file.size)}, file lớn 500MB không được upload`);
            const oversizedFileMessage =
                `Các file sau sẽ không được upload do vượt quá dung lượng: ${oversizedFileMessages.join('; ')}`;
            errorFileImage.textContent = oversizedFileMessage;
            addJobButton.disabled = true;
        } else { // Nếu mà số lượng file nhỏ hơn 50 file
            if (addJobButton.disabled ==
                true) { // Nếu khi chọn lại file hình ảnh mà số lượng file < 50 và trạng thái bằng TRUE
                // Chỗ này Đúng Đúng Sai Sai mệt lắm đấy.
                addJobButton.disabled = true;
            }
        }
    }



    function formatFileSize(size) {
        const units = ['B', 'KB', 'MB', 'GB'];
        let index = 0;
        while (size >= 1024 && index < units.length - 1) {
            size /= 1024;
            index++;
        }
        return `${size.toFixed(2)} ${units[index]}`;
    }
});

// THE END - xử lý phần upload vượt quá 50 file, và dung lượng vượt quá 500mb của

// START - NHẬP DỮ LIỆU CỦA CÁC INPUT VÀO CSDL
document.getElementById('upload-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var formDataInput = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh
    var formDataImage = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh

    var fileInputImage = document.getElementById('file_upload_image'); // Lấy phần tử input chứa tệp

    var selectedFilesImages = fileInputImage.files; // Lấy danh sách tệp đã chọn
    for (var i = 0; i < selectedFilesImages.length; i++) {
        formDataImage.append('file_upload_image[]', selectedFilesImages[i]);
    }

    var product_vendor_id = document.getElementById('product_vendor_id').value.toUpperCase();
    var product_customer_code = document.getElementById('product_customer_code').value.toUpperCase();
    product_customer_code = product_customer_code.replace(/\s+/g, '');

    var product_customer_fullname = document.getElementById('product_customer_fullname').value;
    var product_customer_id = document.getElementById('product_customer_id').value;

    var grossweight = document.getElementById('grossweight').value;
    var dimension_l = document.getElementById('dimension_l').value;
    var dimension_w = document.getElementById('dimension_w').value;
    var dimension_h = document.getElementById('dimension_h').value;

    var carton_l = document.getElementById('carton_l').value;
    var carton_w = document.getElementById('carton_w').value;
    var carton_h = document.getElementById('carton_h').value;

    var dolly_l = document.getElementById('dolly_l').value;
    var dolly_w = document.getElementById('dolly_w').value;
    var dolly_h = document.getElementById('dolly_h').value;

    var pallet_l = document.getElementById('pallet_l').value;
    var pallet_w = document.getElementById('pallet_w').value;
    var pallet_h = document.getElementById('pallet_h').value;

    var frame_id = document.getElementById('frame_id').value;
    var rope_id = document.getElementById('rope_id').value;
    var fabric_id = document.getElementById('fabric_id').value;
    var wood_id = document.getElementById('wood_id').value;
    var ceramic_id = document.getElementById('ceramic_id').value;

    var color_id = document.getElementById('color_id').value;
    // var style_category_id = document.getElementById('style_category_id').value;

    var currentDate = new Date(); // Lấy thời gian hiện tại
    var year = currentDate.getFullYear();
    var month = String(currentDate.getMonth() + 1).padStart(2, '0');
    var day = String(currentDate.getDate()).padStart(2, '0');
    var hours = String(currentDate.getHours()).padStart(2, '0');
    var minutes = String(currentDate.getMinutes()).padStart(2, '0');
    var seconds = String(currentDate.getSeconds()).padStart(2, '0');

    var currentDate = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

    formDataInput.append('product_vendor_id', product_vendor_id);
    formDataInput.append('product_customer_code', product_customer_code);
    formDataInput.append('product_customer_fullname', product_customer_fullname);
    formDataInput.append('product_customer_id', product_customer_id);

    formDataInput.append('grossweight', grossweight);
    formDataInput.append('dimension_l', dimension_l);
    formDataInput.append('dimension_w', dimension_w);
    formDataInput.append('dimension_h', dimension_h);

    formDataInput.append('carton_l', carton_l);
    formDataInput.append('carton_w', carton_w);
    formDataInput.append('carton_h', carton_h);

    formDataInput.append('dolly_l', dolly_l);
    formDataInput.append('dolly_w', dolly_w);
    formDataInput.append('dolly_h', dolly_h);

    formDataInput.append('pallet_l', pallet_l);
    formDataInput.append('pallet_w', pallet_w);
    formDataInput.append('pallet_h', pallet_h);

    formDataInput.append('frame_id', frame_id);
    formDataInput.append('rope_id', rope_id);
    formDataInput.append('fabric_id', fabric_id);
    formDataInput.append('wood_id', wood_id);
    formDataInput.append('ceramic_id', ceramic_id);

    formDataInput.append('color_id', color_id);
    // formDataInput.append('style_category_id', style_category_id);
    formDataInput.append('currentDate', currentDate);

    var xhr_formDataInput = new XMLHttpRequest();

    xhr_formDataInput.open('POST', '/erpthinhcuong/product_customer/product_customer_add_process.php', true);
    xhr_formDataInput.send(formDataInput);

    xhr_formDataInput.onload = function() {
        if (xhr_formDataInput.status === 200) {
            // echo 'Xử lý nhập dữ liệu thành công và csdl';
            if (selectedFilesImages.length <= 0) {
                window.location.href = '/erpthinhcuong/product_customer/product_customer.php';
            } else {
                // CẤM CHÍnH SỬA BÊN NGOÀI CHỖ NÀY

                var response = JSON.parse(xhr_formDataInput.responseText);
                // Lại bắt đầu chết nhục với chỗ nào đây.

                var $product_customer_product_Id = response[0]
                    .product_customer_product_Id; // Giả sử bạn đã có productId từ phản hồi trước đó
                formDataImage.append('product_customer_product_Id', $product_customer_product_Id);
                console.log('Day la Product ID: ' + $product_customer_product_Id);
                // START - THÊM FILE HÌNH ẢNH LÊN SERVER VÀ LƯU LINK VÀO CSDL
                var xhr_image = new XMLHttpRequest();
                var startTime_image = Date.now(); // Lấy thời gian bắt đầu tải lên

                xhr_image.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        var percent_image = (e.loaded / e.total) * 100;
                        // document.getElementById('upload_title.text-center').style.display = 'block';
                        document.getElementById('progress_container_image').style.display = 'block';
                        document.getElementById('progress_bar_image').style.width = percent_image +
                            '%';
                        document.getElementById('progress_text_image').textContent = Math.round(
                                percent_image) +
                            '%';

                        // Tính thời gian đã trôi qua và thời gian còn lại
                        var currentTime_image = Date.now();
                        var elapsedTime_image = (currentTime_image - startTime_image) /
                            1000; // Đổi sang giây
                        var totalTime_image = (e.total - e.loaded) / (e.loaded / elapsedTime_image);

                        // Hiển thị thời gian đếm ngược
                        document.getElementById('countdown_image').textContent =
                            "Thời gian tải file hình ảnh còn: " + Math
                            .round(
                                totalTime_image) + " seconds";
                    }
                };

                xhr_image.onload = function() {
                    if (xhr_image.status === 200) {
                        var divToHide = document.querySelector('.container.custom-fixed-top');

                        // Ẩn phần tử bằng cách thiết lập style.display thành "none"
                        divToHide.style.display = "none";
                        window.location.href = '/erpthinhcuong/product_customer/product_customer.php';
                    } else {
                        alert('Upload image failed.');
                    }
                };

                xhr_image.open('POST', '/erpthinhcuong/product_customer/product_customer_add_uploadImages.php',
                    true);
                xhr_image.send(formDataImage);
                // CẤM CHÍnH SỬA BÊN NGOÀI CHỖ NÀY
            }
        }
    };



});
</script>
<?php include '../footer.php'; ?>