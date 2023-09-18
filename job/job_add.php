<?php 
    include '../header.php'; 
    include '../function/function.php';
    $idDepartment = $_SESSION['department_id'];
?>
<div class="container custom-fixed-top">
    <form id="upload-form" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="jobtitles" class="form-label">Job Titles:</label>
                    <textarea class="form-control" id="jobtitles" name="jobtitles" style="height: 20px;"
                        required></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3">
                    <label for="jobdetails" class="form-label">Job Details:</label>
                    <textarea class="form-control" id="jobdetails" name="jobdetails" style="height: 250px;"
                        required></textarea>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <div class="itemSelected">
                        <!-- Đây là vùng hiển thị các nút đã được chọn -->
                        <p>Hãy lựa chọn #tag bên dưới</p>
                        <input type="hidden" id="notes" value="">
                    </div>
                    <div class="listItem">
                        <button type="button" class="btn btn-light btn-info-custom tagButton">Ship gấp</button>
                        <button type="button" class="btn btn-light btn-info-custom tagButton">Quan Trọng</button>
                        <button type="button" class="btn btn-light btn-info-custom tagButton">Cẩn Thận</button>
                        <button type="button" class="btn btn-light btn-info-custom tagButton">Lưu ý</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="file_upload_image">Upload Images (PNG, JPG)</label>
                    <input type="file" name="file_upload_image[]" id="file_upload_image" class="form-control" multiple
                        accept=".png, .jpg, .jpeg">
                    <!-- accept=".png, .jpg, .jpeg" -->
                </div>
                <div class="mb-3">
                    <span class="errorFileImage error-message"></span>
                </div>


                <div class="mb-3">
                    <label for="file_upload_file">Upload Files (PDF, DOCX, XLSX, PPTX, RAR, ZIP, 7Z)</label>
                    <input type="file" name="file_upload_file[]" id="file_upload_file" class="form-control" multiple
                        accept=".pdf, .docx, .xlsx, .pptx, .rar, .zip, .7z">
                </div>
                <div class="mb-3">
                    <span class="errorFileDocument error-message"></span>
                </div>

                <div class="mb-3">

                    <label for="assignee" class="form-label">Assignee:</label>
                    <select class="form-select" name="assignee" id="assignee">
                        <?php
                        $getEmployees = getRecordTableById('tbl_employee','department_id',$idDepartment);
                        if ($getEmployees) {
                                foreach ($getEmployees as $getEmployee) {
                                    echo "<option value=".$getEmployee['id'].">".$getEmployee['fullname']."</option>";
                                }
                            } 
                    ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deadline" class="form-label">Deadline:</label>
                    <input type="date" class="form-control" id="deadline" name="deadline"
                        min="<?php echo date('Y-m-d');?>" max="" required>
                </div>
            </div>
            <div class="mb-3 text-center">
                <button id="addJobButton" type="submit" class="btn btn-primary ">Add Job</button>
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
    <!-- Cái này cho tài liệu -->
    <div id="progress_container_file" class="mt-4" style="display: none;">
        <span>File tài liệu đang được tải lên máy chủ...</span>
        <div id="progress_bar_file" class="progress">
            <div class="progress_bar_file" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0"
                aria-valuemax="100"></div>

        </div>
        <div id="progress_text_file" class="mt-2">0%</div>
        <div id="countdown_file" class="mt-2">Countdown_image: 0 seconds</div>
    </div>

</div>

<script>

// START - xử lý phần upload vượt quá 50 file, và dung lượng vượt quá 500mb của
// http://localhost/thinhcuong/job
document.addEventListener('DOMContentLoaded', function() {
    const maxFileSize = 500 * 1024 * 1024; // 500MB in bytes
    const maxImageCount = 50;
    const maxDocumentCount = 50;
    const imagesInput = document.getElementById('file_upload_image');
    const filenameInput = document.getElementById('file_upload_file');
    const addJobButton = document.getElementById('addJobButton');
    const errorFileImage = document.querySelector('.errorFileImage');
    const errorFileDocument = document.querySelector('.errorFileDocument');

    imagesInput.addEventListener('change', handleImagesChange);
    filenameInput.addEventListener('change', handleFilenameChange);

    addJobButton.disabled = false;

    function handleImagesChange(event) {
        console.log(addJobButton.disabled);
        errorFileImage.textContent = '';

        const files = event.target.files;
        let totalImageSize = 0;
        let imageCount = 0;
        let oversizedFiles = [];

        for (const file of files) {
            if (file.type.startsWith('image/')) {
                totalImageSize += file.size;
                imageCount++;
                if (file.size > maxFileSize) {
                    oversizedFiles.push(file);
                }
            }
        }
        // nếu mà số lượng file lớn hơn 50 file thì bằng TRUE
        if (imageCount > maxImageCount) {
            errorFileImage.textContent = 'Số lượng file vượt quá quy định 50 file hình ảnh.';
            addJobButton.disabled = true;
        }else{ // Nếu mà số lượng file nhỏ hơn 50 file
            if(addJobButton.disabled == true){ // Nếu khi chọn lại file hình ảnh mà số lượng file < 50 và trạng thái bằng TRUE
                // Chỗ này Đúng Đúng Sai Sai mệt lắm đấy.
                addJobButton.disabled = true;
            }
        }

        if (oversizedFiles.length > 0) {
            const oversizedFileMessages = oversizedFiles.map(file => `${file.name}, dung lượng ${formatFileSize(file.size)}, file lớn 500MB không được upload`);
            const oversizedFileMessage = `Các file sau sẽ không được upload do vượt quá dung lượng: ${oversizedFileMessages.join('; ')}`;
            errorFileImage.textContent = oversizedFileMessage;
            addJobButton.disabled = true;
        }else{ // Nếu mà số lượng file nhỏ hơn 50 file
            if(addJobButton.disabled == true){ // Nếu khi chọn lại file hình ảnh mà số lượng file < 50 và trạng thái bằng TRUE
                // Chỗ này Đúng Đúng Sai Sai mệt lắm đấy.
                addJobButton.disabled = true;
            }
        }
    }

    function handleFilenameChange(event) {
        errorFileDocument.textContent = '';
        addJobButton.disabled = false;

        const files = event.target.files;
        let totalDocumentSize = 0;
        let documentCount = 0;
        let oversizedFiles = [];

        for (const file of files) {
            if (!file.type.startsWith('image/')) {
                totalDocumentSize += file.size;
                documentCount++;
                if (file.size > maxFileSize) {
                    oversizedFiles.push(file);
                }
            }
        }

        if (documentCount > maxDocumentCount) {
            errorFileDocument.textContent = 'Số lượng file vượt quá quy định 50 file tài liệu.';
            addJobButton.disabled = true;
        }else{ // Nếu mà số lượng file nhỏ hơn 50 file
            if(addJobButton.disabled == true){ // Nếu khi chọn lại file hình ảnh mà số lượng file < 50 và trạng thái bằng TRUE
                // Chỗ này Đúng Đúng Sai Sai mệt lắm đấy.
                addJobButton.disabled = true;
            }
        }


        if (oversizedFiles.length > 0) {
            const oversizedFileMessages = oversizedFiles.map(file => `${file.name}, dung lượng ${formatFileSize(file.size)}, file lớn 500MB không được upload`);
            const oversizedFileMessage = `Các file sau sẽ không được upload do vượt quá dung lượng: ${oversizedFileMessages.join('; ')}`;
            errorFileDocument.textContent = oversizedFileMessage;
            addJobButton.disabled = true;
        }else{ // Nếu mà số lượng file nhỏ hơn 50 file
            if(addJobButton.disabled == true){ // Nếu khi chọn lại file hình ảnh mà số lượng file < 50 và trạng thái bằng TRUE
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


// START - xử lý vấn đề liên quan tới #tag trong form nhập Job mới
const itemSelected = document.querySelector('.itemSelected');
const listItem = document.querySelector('.listItem');
const notesInput = document.getElementById('notes');
const tagButtons = listItem.querySelectorAll('.tagButton');
const viewNotesButton = document.getElementById('viewNotesButton');
const notesValue = document.getElementById('notesValue');

tagButtons.forEach(tagButton => {
    // Xử lý sự kiện khi người dùng bấm vào nút gợi ý
    tagButton.addEventListener('click', function() {
        const tagText = tagButton.textContent;
        const currentNotes = notesInput.value;

        if (!currentNotes.includes(tagText)) {
            // Thêm nội dung nút vào biến notes nếu chưa tồn tại
            notesInput.value = currentNotes === '' ? tagText : currentNotes + ', ' + tagText;
        }

        // Di chuyển nút từ listItem sang itemSelected
        itemSelected.appendChild(tagButton);
    });
});

itemSelected.addEventListener('click', function(event) {
    // Kiểm tra nút được bấm có class 'tagButton' không
    if (event.target.classList.contains('tagButton')) {
        const tagText = event.target.textContent;
        const currentNotes = notesInput.value;

        // Xóa nội dung nút khỏi biến notes nếu đã tồn tại
        let newNotes = currentNotes.split(',').filter(tag => tag.trim() !== tagText).join(', ');

        // Cập nhật biến notes
        notesInput.value = newNotes;

        // Di chuyển nút từ itemSelected sang listItem
        listItem.appendChild(event.target);
    }
});
// THE END - xử lý vấn đề liên quan tới #tag trong form nhập Job mới


 // START - NHẬP DỮ LIỆU CỦA CÁC INPUT VÀO CSDL
document.getElementById('upload-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var formDataImage = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh
    var formDataFile = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh
    var formDataInput = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh

    var ischeckImage = false;
    var ischeckFile = false;
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
   
    //Lấy giá trị từ các trường input
    var jobtitles = document.getElementById('jobtitles').value;
    var jobdetails = document.getElementById('jobdetails').value;
    var assignee = document.getElementById('assignee').value;
    var deadline = document.getElementById('deadline').value;
    var notes = notesInput.value;

    var currentDate = new Date(); // Lấy thời gian hiện tại
    var year = currentDate.getFullYear();
    var month = String(currentDate.getMonth() + 1).padStart(2, '0');
    var day = String(currentDate.getDate()).padStart(2, '0');
    var hours = String(currentDate.getHours()).padStart(2, '0');
    var minutes = String(currentDate.getMinutes()).padStart(2, '0');
    var seconds = String(currentDate.getSeconds()).padStart(2, '0');

    var currentDate = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

    formDataInput.append('jobtitles', jobtitles);
    formDataInput.append('jobdetails', jobdetails);
    formDataInput.append('assignee', assignee);
    formDataInput.append('deadline', deadline);
    formDataInput.append('notes', notes);
    formDataInput.append('currentDate', currentDate);

    var xhr_formDataInput = new XMLHttpRequest();

    xhr_formDataInput.open('POST', '/thinhcuong/job/uploadDataInput.php', true);
    xhr_formDataInput.send(formDataInput);

    xhr_formDataInput.onload = function() {
        if (xhr_formDataInput.status === 200) {
            // Nếu mà 2 trường nhập file không có nhập file nào thì 2 biến này sẽ  bằng 0 hoặc nhỏ hơn.
            // Nên nếu vậy thì khi Nhập bản ghi JOB vào cơ sở dữ liệu thì chuyển hướng sang trang JOB
            // Còn nếu ngược lại thì việc chuyển hướng để cho bộ phận Upload file xử lý
            var response = JSON.parse(xhr_formDataInput.responseText);
            // Lại bắt đầu chết nhục với chỗ nào đây.

            var jobId = response[0].jobId; // Giả sử bạn đã có jobId từ phản hồi trước đó
            formDataImage.append('jobId', jobId);
            formDataFile.append('jobId', jobId);
            if (selectedFilesImages.length <= 0 && selectedFilesImages.length <= 0) {
                window.location.href = '/thinhcuong/job/job.php';
            }
            // START - THÊM FILE HÌNH ẢNH LÊN SERVER VÀ LƯU LINK VÀO CSDL
            if (selectedFilesImages.length > 0) {
                var xhr_image = new XMLHttpRequest();
                var startTime_image = Date.now(); // Lấy thời gian bắt đầu tải lên
                xhr_image.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        var percent_image = (e.loaded / e.total) * 100;
                        // document.getElementById('upload_title.text-center').style.display = 'block';
                        document.getElementById('progress_container_image').style.display = 'block';
                        document.getElementById('progress_bar_image').style.width = percent_image + '%';
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
                        // document.getElementById('progress_container_image').style.display = 'none';
                        // alert('Upload completed.');
                        // window.location.href = 'index.php';
                        // Lấy phần tử div có class "container custom-fixed-top"
                        ischeckImage = true;
                        if (ischeckImage && ischeckFile) {
                            window.location.href = '/thinhcuong/job/job.php';
                        }
                        var divToHide = document.querySelector('.container.custom-fixed-top');
                        // Ẩn phần tử bằng cách thiết lập style.display thành "none"
                        divToHide.style.display = "none";
                    } else {
                        alert('Upload image failed.');
                    }
                };

                xhr_image.open('POST', '/thinhcuong/job/uploadFileImages.php', true);
                xhr_image.send(formDataImage);
            } else {
                ischeckImage = true;
            }
            // THE END - THÊM FILE HÌNH ẢNH LÊN SERVER VÀ LƯU LINK VÀO CSDL
            // START - UPLOAD FILE DOCUMENT NẾU CÓ FILE DOCUMENT ĐƯỢC CHỌN
            if (selectedFilesFiles.length > 0) {
                var xhr_file = new XMLHttpRequest();
                var startTime_file = Date.now(); // Lấy thời gian bắt đầu tải lên

                xhr_file.upload.onprogress = function(b) {
                    if (b.lengthComputable) {
                        var percent_file = (b.loaded / b.total) * 100;
                        // document.getElementById('upload_title.text-center').style.display = 'block';
                        document.getElementById('progress_container_file').style.display = 'block';
                        document.getElementById('progress_bar_file').style.width = percent_file + '%';
                        document.getElementById('progress_text_file').textContent = Math.round(
                                percent_file) +
                            '%';
                        // Tính thời gian đã trôi qua và thời gian còn lại
                        var currentTime_file = Date.now();
                        var elapsedTime_file = (currentTime_file - startTime_file) /
                            1000; // Đổi sang giây
                        var totalTime_file = (b.total - b.loaded) / (b.loaded / elapsedTime_file);

                        // Hiển thị thời gian đếm ngược
                        document.getElementById('countdown_file').textContent =
                            "Thời gian tải file tài liệu còn: " + Math.round(
                                totalTime_file) + " seconds";
                    }
                };

                xhr_file.onload = function() {
                    if (xhr_file.status === 200) {
                        // document.getElementById('progress_container_file').style.display = 'none';
                        // alert('Upload completed.');
                        // window.location.href = 'index.php';
                        // Lấy phần tử div có class "container custom-fixed-top"
                        ischeckFile = true;
                        if (ischeckImage && ischeckFile) {
                            window.location.href = '/thinhcuong/job/job.php';
                        }
                        var divToHide = document.querySelector('.container.custom-fixed-top');

                        // Ẩn phần tử bằng cách thiết lập style.display thành "none"
                        divToHide.style.display = "none";

                    } else {
                        alert('Upload document failed.');
                    }

                };

                xhr_file.open('POST', '/thinhcuong/job/uploadFileDocuments.php', true);
                xhr_file.send(formDataFile);
            } else {
                ischeckFile = true;
            }
            // THE END - UPLOAD FILE DOCUMENT NẾU CÓ FILE DOCUMENT ĐƯỢC CHỌN
        } else {
            alert('Không nhập được cơ dữ liệu.');
        }
    };
    // THE END - NHẬP DỮ LIỆU CỦA CÁC INPUT VÀO CSDL

});
</script>


<?php include '../footer.php'; ?>