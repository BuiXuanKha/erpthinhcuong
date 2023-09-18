<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Files</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container mt-5">
        <h1>Upload Files</h1>
        <form id="upload-form" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file_upload_image">Upload Images (PNG, JPG)</label>
                <input type="file" name="file_upload_image[]" id="file_upload_image" class="form-control-file" multiple
                    accept=".png, .jpg, .jpeg">
                <!-- accept=".png, .jpg, .jpeg" -->
            </div>

            <div class="mb-3">
                <label for="file_upload_file">Upload Files</label>
                <input type="file" name="file_upload_file[]" id="file_upload_file" class="form-control-file" multiple accept=".pdf, .docx, .xlsx, .pptx, .rar, .zip, .7z">
            </div>
            <button type="submit" class="btn btn-primary">Upload Files</button>
        </form>
        <!-- Cái này cho hình ảnh -->
        <div id="progress_container_image" class="mt-4" style="display: none;">
            <div id="progress_bar_image" class="progress">
                <div class="progress_bar_image" role="progressbar" style="width: 0%;" aria-valuenow="0"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div id="progress_text_image" class="mt-2">0%</div>
            <div id="countdown_image" class="mt-2">Countdown_image: 0 seconds</div>
        </div>
        <!-- Cái này cho tài liệu -->
        <div id="progress_container_file" class="mt-4" style="display: none;">
            <div id="progress_bar_file" class="progress">
                <div class="progress_bar_file" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                    aria-valuemax="100"></div>
            </div>
            <div id="progress_text_file" class="mt-2">0%</div>
            <div id="countdown_file" class="mt-2">Countdown_image: 0 seconds</div>
        </div>
    </div>
    </div>

    <script>
    document.getElementById('upload-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var formDataImage = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh
        var formDataFile = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh

        // Lấy DIV id = file-upload 
        var fileInputImage = document.getElementById('file_upload_image'); // Lấy phần tử input chứa tệp
        // Lấy danh sách file cho vào mảng selectedFiles
        var selectedFilesImages = fileInputImage.files; // Lấy danh sách tệp đã chọn
        for (var i = 0; i < selectedFilesImages.length; i++) {
            formDataImage.append('file_upload_image[]', selectedFilesImages[i]);
        }

        var fileInputFile = document.getElementById('file_upload_file'); // Lấy phần tử input chứa tệp
        // Lấy danh sách file cho vào mảng selectedFiles
        var selectedFilesFiles = fileInputFile.files; // Lấy danh sách tệp đã chọn
        for (var i = 0; i < selectedFilesFiles.length; i++) {
            formDataFile.append('file_upload_file[]', selectedFilesFiles[i]);
        }
        // Kiểm tra xem có tệp nào được chọn hay không
        if (selectedFilesImages.length > 0) {
            var xhr_image = new XMLHttpRequest();
            var startTime_image = Date.now(); // Lấy thời gian bắt đầu tải lên

            xhr_image.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    var percent_image = (e.loaded / e.total) * 100;
                    document.getElementById('progress_container_image').style.display = 'block';
                    document.getElementById('progress_bar_image').style.width = percent_image + '%';
                    document.getElementById('progress_text_image').textContent = Math.round(percent_image) +
                        '%';

                    // Tính thời gian đã trôi qua và thời gian còn lại
                    var currentTime_image = Date.now();
                    var elapsedTime_image = (currentTime_image - startTime_image) / 1000; // Đổi sang giây
                    var totalTime_image = (e.total - e.loaded) / (e.loaded / elapsedTime_image);

                    // Hiển thị thời gian đếm ngược
                    document.getElementById('countdown_image').textContent = "Countdown_image: " + Math
                        .round(
                            totalTime_image) + " seconds";
                }
            };

            xhr_image.onload = function() {
                if (xhr_image.status === 200) {
                    // document.getElementById('progress_container_image').style.display = 'none';
                    // alert('Upload completed.');
                    // window.location.href = 'index.php';

                } else {
                    alert('Upload image failed.');
                }
            };

            xhr_image.open('POST', 'uploadFileImages.php', true);
            xhr_image.send(formDataImage);
        }
        // UPLOAD FILE DOCUMENT
        if (selectedFilesFiles.length > 0) {
            var xhr_file = new XMLHttpRequest();
            var startTime_file = Date.now(); // Lấy thời gian bắt đầu tải lên

            xhr_file.upload.onprogress = function(b) {
                if (b.lengthComputable) {
                    var percent_file = (b.loaded / b.total) * 100;
                    document.getElementById('progress_container_file').style.display = 'block';
                    document.getElementById('progress_bar_file').style.width = percent_file + '%';
                    document.getElementById('progress_text_file').textContent = Math.round(percent_file) +
                        '%';
                    // Tính thời gian đã trôi qua và thời gian còn lại
                    var currentTime_file = Date.now();
                    var elapsedTime_file = (currentTime_file - startTime_file) / 1000; // Đổi sang giây
                    var totalTime_file = (b.total - b.loaded) / (b.loaded / elapsedTime_file);

                    // Hiển thị thời gian đếm ngược
                    document.getElementById('countdown_file').textContent = "Countdown_file: " + Math.round(
                        totalTime_file) + " seconds";
                }
            };

            xhr_file.onload = function() {
                if (xhr_file.status === 200) {
                    // document.getElementById('progress_container_file').style.display = 'none';
                    // alert('Upload completed.');
                    // window.location.href = 'index.php';
                } else {
                    alert('Upload document failed.');
                }
            };

            xhr_file.open('POST', 'uploadFileDocuments.php', true);
            xhr_file.send(formDataFile);
        }

    });
    </script>
</body>

</html>