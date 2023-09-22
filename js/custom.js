// Tệp custom.js
baguetteBox.run('.tz-gallery');

$(document).ready(function() {
    var table = $('#myTable').DataTable({
        responsive: true,
        searching: true,
        lengthMenu: [10, 25, 50, 75, 100],
        pageLength: 50,
        buttons: [{
            extend: 'pdfHtml5',
            text: 'PDF',
            className: 'btn btn-info',
            customize: function(doc) {}
        },
        {
            extend: 'excelHtml5',
            text: 'Excel',
            className: 'btn btn-info',
            customize: function(win) {
                // Customization code for the print view
                // You can modify the print layout and content here
            }
        },
        ]
    });
    table.buttons().container().appendTo($('.kha_list .kha_list_item'));
});


function printPage() {
    window.print();
}
// Hàm xoá
function confirmDelete(info) {
    return confirm("Bạn có thực sự muốn xoá "+ info + " này không?");
}

// Hàm để ghi log khi người dùng click vào button "Add file" và chuyển đến trang mới
function logAddFile(link,userName, action) {
    // Ghi log bằng cách gửi yêu cầu Ajax
    $.ajax({
        url: '/erpthinhcuong/log/add_log.php', // Đường dẫn đến tệp xử lý PHP
        type: 'POST',
        data: {logComments: userName + ' ' + action, status: 'Thành công'}, // Thông tin log cần ghi
        success: function(response) {
            // Log đã được ghi thành công, thực hiện các hành động bổ sung nếu cần
            console.log('Log ghi thành công.');

            // Sau khi ghi log, chuyển đến trang mới
            window.location.href = link;
        },
        error: function(xhr, status, error) {
            // Xảy ra lỗi khi ghi log, xử lý lỗi nếu cần
            console.error('Lỗi khi ghi log:', status, error);
        }
    });
}

// HÀM NÀY GỌI GỬI DỮ LIỆU LÀ INPUT VÀO FILE product_customer_bom_livesearch.PHP ĐỂ TÌM KIẾM DỮ LIỆU TRONG BẢNG TBL_BOM
function performAjaxSearch() {
    var input = $("#searchBom").val();
    // console.log(input);
    if (input != "") {
        console.log("Starting AJAX call");
        $.ajax({
            url: "/erpthinhcuong/product_customer/bom_livesearch.php",
            method: "POST",
            data: { input: input },
            success: function (data) {
                $("#searchresult").html(data);
                $("#searchresult").css("display", "block");
                // Cái này khắc phục lỗi:
                    // Khi người dùng tìm kiếm xong --> Đã chọn Vật Tư ( khi chọn thì Bom_id đã có giá trị)
                    // Nhưng lại không nhập Vật tư vào bảng Vật tư sản phẩm, mà lại đi tìm vật tư khác.
                    // Nên cần Reset Bom_id = null;
                document.getElementById("bom_id").value = '';
                // var bom_idInput = document.getElementById("bom_id").value;
                // alert(bom_idInput);
            },
            error: function (xhr, status, error) {
                console.log("AJAX error:", error);
            }
        });
    } else {
        $("#searchresult").css("display", "none");
    }
}
// KHI GÕ TỪNG PHÍM VÀO INPUT THÌ SẼ TÌM KIẾM THÔNG TIN VẬT TƯ
$(document).ready(function () {
    $("#searchBom").keyup(performAjaxSearch);
    
});

// HÀM LẤY THỜI GIAN HIỆN TẠI ĐỂ LƯU VÀO CSDL KIỂU DATETIME
function getCurrentTime() {
    var currentDate = new Date(); // Lấy thời gian hiện tại
    var year = currentDate.getFullYear();
    var month = String(currentDate.getMonth() + 1).padStart(2, '0');
    var day = String(currentDate.getDate()).padStart(2, '0');
    var hours = String(currentDate.getHours()).padStart(2, '0');
    var minutes = String(currentDate.getMinutes()).padStart(2, '0');
    var seconds = String(currentDate.getSeconds()).padStart(2, '0');

    var currentTimeFormatted = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
    
    return currentTimeFormatted;
}
// HÀM NÀY KHI TÌM THẤY VẬT TƯ THÌ ADD ID VÀ UNIT VÀO THẺ INPUT
// PAGE: http://localhost/thinhcuong/product_customer/product_customer_bom.php
function clickAddBom(fullname,bom_id){
    document.getElementById("searchBom").value = fullname;
    document.getElementById("bom_id").value = bom_id;
    var amountInput = document.getElementById("amount");
    amountInput.value = '0';
    amountInput.focus(); // Đặt con trỏ chuột vào input
}

// HÀM NÀY ADD VẬT TƯ KHI TÌM KIẾM THẤY
// PAGE: http://localhost/thinhcuong/product_customer/product_customer_bom.php
function CheckInput(){
    var product_customer_id = document.getElementById('product_customer_id').value;
    if (product_customer_id === 'undefined' || product_customer_id === '') {
        alert("Bạn chưa chọn nguyên vật liệu");
        // Tìm phần tử input bằng ID (thay thế 'yourInputId' bằng ID của phần tử input thực tế)
        var inputElement = document.getElementById('searchBom');
        // Kiểm tra xem phần tử input có tồn tại không
        if (inputElement) {
            // Đặt con trỏ vào phần tử input
            inputElement.focus();
        }
    }else{
        var amount = document.getElementById('amount').value;
        if(amount>0){
            checkBomOfListBomCustomer(product_customer_id);
        }else{
            alert("Bạn chưa nhập số lượng");
            // Tìm phần tử input bằng ID (thay thế 'yourInputId' bằng ID của phần tử input thực tế)
            var inputElementamount = document.getElementById('amount');
            // Kiểm tra xem phần tử input có tồn tại không
            if (inputElementamount) {
                // Đặt con trỏ vào phần tử input
                inputElementamount.focus();
            }
        }

    }            
}
// KIỂM TRA XEM VẬT TƯ ĐƯỢC CHỌN ĐÃ CÓ TRONG DANH SÁCH VẬT TƯ SẢN PHẨM CHƯA?
// Nếu có rồi thì Update thông tin trường số lượng
// Nếu chưa có thì thêm vật tư đó vào dánh sách Vật tư sản phẩm

// Để kiểm tra được thì cần
// - ID của Sản phẩm ( ID này lấy từ $_GET['sid'])
// - ID của Vật tư (ID này lấy từ ID vật tư người dùng đã chọn)
function checkBomOfListBomCustomer(product_customer_id){
    // Đây là ID của vật tư
    var bom_id = document.getElementById('bom_id').value;
    // Đây là ID SẢN PHẨM 
        // Do lấy ID SẢN PHẨM từ URL nên cần chuyển từ PHP sang JS, 
        // vậy nên cần gán ID đó vào 1 trường INPUT ẩn, và giờ getElementByID của JS
    // var product_customer_id = document.getElementById('product_customer_id').value;
    var product_customer_id = product_customer_id;
    var dataSearch = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh
    dataSearch.append('bom_id', bom_id);
    dataSearch.append('product_customer_id', product_customer_id);
    var xhr_dataSearch = new XMLHttpRequest();

    // Gửi dữ liệu đến file bom_search.php để tìm kiếm xem nào, xem có thấy nó xuất hiện ở đó không?
    // KẾT QUẢ: nhận được sẽ nhận qua response nhé
        // 1. Cần trả lại giá trị $product_customer_id (để gửi hàm khác)
        // 2. Cần trả lại $VatTuDaTonTai
    xhr_dataSearch.open('POST', '/erpthinhcuong/product_customer/bom_search.php', true);
    xhr_dataSearch.send(dataSearch);

    xhr_dataSearch.onload = function() {
        if (xhr_dataSearch.status === 200) {
            console.log('Đã xử lý file searchBom.php thành công. Dưới đây là kết quả nhận được từ file bom_search.php:')
            var response = JSON.parse(xhr_dataSearch.responseText);
            var $VatTuDaTonTai = response[0].VatTuDaTonTai;

            //  $product_customer_id giá trị biến này sẽ truyền cho file update để nó update số lượng
            var $product_customer_bom_id = response[0].product_customer_bom_id;
            // Lấy cái này để cho vào URL
            var $product_customer_id = response[0].product_customer_id;

            // console.log('VatTuDaTonTai:' + $VatTuDaTonTai);
            console.log('product_customer_id:' + $product_customer_id);
            // console.log('product_customer_bom_id:' + $product_customer_bom_id);
            // // var $productCustomerBom_id = response[0].productCustomerBom_id;
            // console.log('Đây là số ID vật tư có trong bảng tbl_product_customer_bom:' + $productCustomerBom_id);
            if($VatTuDaTonTai > 0){
                // Nếu tồn tại thì gọi trang Update
                // Cập nhật SỐ LƯỢNG cho bản ghi có product_customer_bom_id tồn tại trong bảng product_customer_bom
                UpdateBom($product_customer_bom_id,$product_customer_id);
            }else{
                // Nếu không tồn tại thì gọi hàm thêm mới
                // Nếu chưa chọn vật tư thì hiện thông báo
                if(bom_id === ""){
                    alert("Bạn chưa Chọn vật tư");
                }else{
                    AddNewBom($product_customer_id,bom_id);
                }
            }
        };
    }
}

// HÀM CẬP NHẬT THÔNG TIN NÀY CẦN CÓ:
    // 1. ID của bản ghi cần cập nhật
function UpdateBom(product_customer_bom_id,product_customer_id){
    var dataUpdateSoLuong = new FormData();
    var amount = document.getElementById('amount').value;
    var product_customer_bom_id = product_customer_bom_id;
    dataUpdateSoLuong.append("amount",amount)
    dataUpdateSoLuong.append('product_customer_bom_id', product_customer_bom_id);

    var xhr_dataUpdateSoLuong = new XMLHttpRequest();

    xhr_dataUpdateSoLuong.open('POST', '/erpthinhcuong/product_customer/bom_update.php', true);
    xhr_dataUpdateSoLuong.send(dataUpdateSoLuong);

    xhr_dataUpdateSoLuong.onload = function() {
        if (xhr_dataUpdateSoLuong.status === 200) {
            // echo 'Xử lý nhập dữ liệu thành công và csdl';
            window.location.href =
                '/erpthinhcuong/product_customer/product_customer_bom.php?sid='+ product_customer_id;
        }
    };            
}
// THÊM MỚI VÂT TƯ VÀO BẢNG DANH SÁCH VẬT TƯ CỦA SẢN PHẨM
// Cần thông tin gì?
    // ID vật tư, Số lượng
function AddNewBom(product_customer_id,bom_id){
    var formDataInput = new FormData()

    var amount = document.getElementById('amount').value;
    formDataInput.append('amount', amount);

    formDataInput.append('product_customer_id', product_customer_id);
    formDataInput.append('bom_id', bom_id);
    formDataInput.append('currentDate', getCurrentTime());

    var xhr_formDataInput = new XMLHttpRequest();

    xhr_formDataInput.open('POST', '/erpthinhcuong/product_customer/bom_add.php', true);
    xhr_formDataInput.send(formDataInput);

    xhr_formDataInput.onload = function() {
        if (xhr_formDataInput.status === 200) {
            window.location.href =
                '/erpthinhcuong/product_customer/product_customer_bom.php?sid='+ product_customer_id;
        }
    };
}
