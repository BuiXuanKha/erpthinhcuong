<?php 
    include '../header.php'; 
    include '../function/function.php';
?>
<!-- Start -->
<div class="container custom-fixed-top">
    <form id="upload-form" method="POST" enctype="multipart/form-data">
        <div class="row text-center">
            <div class="col-md-12">
                <div class="mb-3">
                    <h1>THÊM VẬT TƯ TIÊU HAO</h1>
                    <hr>
                </div>
            </div>
        </div>
        <!-- TÊN VẬT TƯ -->
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="fullname">Tên vật tư:</label>
                    <input type="text" class="form-control" id="fullname" name="fullname">
                </div>
            </div>
        </div>
        <!-- KÍCH THƯỚC -->
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="dimension">Kích thước:</label>
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="dimension_l" name="dimension_l" step="0.1"
                                min="0">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="dimension_w" name="dimension_w" step="0.1"
                                min="0">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="dimension_h" name="dimension_h" step="0.1"
                                min="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ĐƠN VỊ TÍNH VÀ MÀU SẮC-->
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="unit_id">Đơn vị tính:</label>
                    <select class="form-control" id="unit_id" name="unit_id">
                        <?php
                          $units = getRecordTableById('tbl_unit','status','0');
                            if ($units) {
                                    foreach ($units as $unit) {
                                        echo '<option value="' . $unit["id"] . '">' . $unit["fullname"] . '</option>';
                                    }
                                } else {
                                    echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.";
                                }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="bom_color_id">Màu:</label>
                    <select class="form-control" id="bom_color_id" name="bom_color_id">
                        <?php
                          $units = getRecordTableById('tbl_bom_color','status','0');
                            if ($units) {
                                    foreach ($units as $unit) {
                                        echo '<option value="' . $unit["id"] . '">' . $unit["fullname"] . '</option>';
                                    }
                                } else {
                                    echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.";
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
                </div>
                <div class="mb-3">
                    <span class="errorFileImage error-message"></span>
                </div>
            </div>
        </div>
        <!-- GHI CHÚ -->
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="notes">Ghi chú:</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                </div>
            </div>
        </div>
        <div class="mb-3 text-center">
            <button id="addBomButton" type="submit" class="btn btn-primary ">Add</button>
        </div>
    </form>
</div>


<!-- End -->
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
document.addEventListener('DOMContentLoaded', function() {
    const maxFileSize = 500 * 1024 * 1024; // 500MB in bytes
    const maxImageCount = 50;
    const maxDocumentCount = 50;
    const imagesInput = document.getElementById('file_upload_image');
    const addBomButton = document.getElementById('addBomButton');
    const errorFileImage = document.querySelector('.errorFileImage');

    imagesInput.addEventListener('change', handleImagesChange);

    addBomButton.disabled = false;

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
            addBomButton.disabled = true;
        } else { // Nếu mà số lượng file nhỏ hơn 50 file
            if (addBomButton.disabled ==
                true) { // Nếu khi chọn lại file hình ảnh mà số lượng file < 50 và trạng thái bằng TRUE
                // Chỗ này Đúng Đúng Sai Sai mệt lắm đấy.
                addBomButton.disabled = false;
            }
        }
        // Nếu mảng oversizedFiles[].lenght lớn hơn 0 tức là có file không đạt yêu cầu, thì thông báo
        if (oversizedFiles.length > 0) {
            const oversizedFileMessages = oversizedFiles.map(file =>
                `${file.name}, dung lượng ${formatFileSize(file.size)}, file lớn 500MB không được upload`
            );
            const oversizedFileMessage =
                `Các file sau sẽ không được upload do vượt quá dung lượng: ${oversizedFileMessages.join('; ')}`;
            errorFileImage.textContent = oversizedFileMessage;
            addBomButton.disabled = true;
        } else { // Nếu mà số lượng file nhỏ hơn 50 file
            if (addBomButton.disabled ==
                true) { // Nếu khi chọn lại file hình ảnh mà số lượng file < 50 và trạng thái bằng TRUE
                // Chỗ này Đúng Đúng Sai Sai mệt lắm đấy.
                addBomButton.disabled = true;
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

document.getElementById('upload-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var formDataInput = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh
    var formDataImage = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh

    var fileInputImage = document.getElementById('file_upload_image'); // Lấy phần tử input chứa tệp

    var selectedFilesImages = fileInputImage.files; // Lấy danh sách tệp đã chọn
    for (var i = 0; i < selectedFilesImages.length; i++) {
        formDataImage.append('file_upload_image[]', selectedFilesImages[i]);
    }

    var fullname = document.getElementById('fullname').value;
    var dimension_l = document.getElementById('dimension_l').value;
    var dimension_w = document.getElementById('dimension_w').value;
    var dimension_h = document.getElementById('dimension_h').value;
    var bom_color_id = document.getElementById('bom_color_id').value;
    var notes = document.getElementById('notes').value;

    var unit_id = document.getElementById('unit_id').value;
    console.log(fullname);
    console.log(unit_id);


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
    formDataInput.append('dimension_l', dimension_l);
    formDataInput.append('dimension_w', dimension_w);
    formDataInput.append('dimension_h', dimension_h);
    formDataInput.append('fullname', fullname);
    formDataInput.append('unit_id', unit_id);
    formDataInput.append('bom_color_id', bom_color_id);
    formDataInput.append('currentDate', currentDate);
    formDataInput.append('notes', notes);

    var xhr_formDataInput = new XMLHttpRequest();

    xhr_formDataInput.open('POST', '/thinhcuong/bom/bom_add_process.php', true);
    xhr_formDataInput.send(formDataInput);

    xhr_formDataInput.onload = function() {
        if (xhr_formDataInput.status === 200) {
            // echo 'Xử lý nhập dữ liệu thành công và csdl';
            if (selectedFilesImages.length <= 0) {
                // window.location.href = '/thinhcuong/bom/bom.php';
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
                        // window.location.href = '/thinhcuong/bom/bom.php';
                    } else {
                        alert('Upload image failed.');
                    }
                };

                xhr_image.open('POST', '/thinhcuong/bom/bom_add_uploadImages.php',
                    true);
                xhr_image.send(formDataImage);
                // CẤM CHÍnH SỬA BÊN NGOÀI CHỖ NÀY
            }
        }
    };



});
</script>
<?php include '../footer.php'; ?>