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
        url: '/thinhcuong/log/add_log.php', // Đường dẫn đến tệp xử lý PHP
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
            url: "/thinhcuong/product_customer/bom_livesearch.php",
            method: "POST",
            data: { input: input },
            success: function (data) {
                $("#searchresult").html(data);
                $("#searchresult").css("display", "block");
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
function clickAddBom(fullname,bom_id2){
    document.getElementById("searchBom").value = fullname;
    document.getElementById("bom_id2").value = bom_id2;
    // Đặt vị trí con trỏ chuột vào input "amount"
    var amountInput = document.getElementById("amount");
    amountInput.value = '0';
    amountInput.focus(); // Đặt con trỏ chuột vào input
}

// HÀM NÀY ADD VẬT TƯ KHI TÌM KIẾM THẤY
// PAGE: http://localhost/thinhcuong/product_customer/product_customer_bom.php
function addBomLiveSearch(){
    // CHÚ Ý QUAN TRỌNG - NGÀY 14/09/2023 CHƯA HOÀN THÀNH
    // TRƯỚC KHI THÊM VẬT TƯ VÀO BẢNG VẬT TƯ SẢN PHẨM
    // CẦN KIỂM TRA XEM SẢN PHẨM ĐỊNH THÊM VÀO ĐÃ CÓ TRONG DANH SÁCH VẬT TƯ SẢN PHẨM CHƯA?
    // NẾU CÓ RỒI THÌ THÌ CHỈ UPDATE THÔNG TIN LÀ THAY ĐỔI SỐ LƯỢNG SẢN PHẨM.
    // NẾU CHƯA CÓ THÌ HÃY THÊM VẬT TƯ VÀO DANH SÁCH VẬT TƯ CỦA SẢN PHẨM
    var formDataInput = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh
    var bom_id2 = document.getElementById('bom_id2').value;
    var product_customer_id = document.getElementById('product_customer_id').value;
    // 15/9: Lấy thêm giá trị product_customer_id
    console.log("Số ID BOM 2:" + bom_id2);
    var dataSearch = new FormData(); // Tạo đối tượng FormData riêng cho hình ảnh
    dataSearch.append('bom_id2', bom_id2);
    dataSearch.append('product_customer_id', product_customer_id);
    var xhr_dataSearch = new XMLHttpRequest();

    xhr_dataSearch.open('POST', '/thinhcuong/product_customer/bom_search.php', true);
    xhr_dataSearch.send(dataSearch);

    xhr_dataSearch.onload = function() {
        if (xhr_dataSearch.status === 200) {
            console.log('Đã xử lý file searchBom.php thành công. Dưới đây là kết quả nhận được từ file searchBom.php:')
            // echo 'Xử lý nhập dữ liệu thành công và csdl';
            // window.location.href =
            //     '/thinhcuong/product_customer/product_customer_bom.php?sid='+ product_customer_id;
            var response = JSON.parse(xhr_dataSearch.responseText);
            // Lại bắt đầu chết nhục với chỗ nào đây.
            
            var $VatTuDaTonTai = response[0].VatTuDaTonTai;
            console.log('Đây là số lượng vật tư có trong bảng tbl_product_customer_bom:' + $VatTuDaTonTai);
            var $productCustomerBom_id = response[0].productCustomerBom_id;
            console.log('Đây là số ID vật tư có trong bảng tbl_product_customer_bom:' + $productCustomerBom_id);
            if($VatTuDaTonTai > 0){
                console.log('CÓ - Có tồn tại vật tư trong bảng tbl_product_customer_bom nên gọi file bom_update.php');
                // GỌI TỚI FILE UPDATE SỐ LƯỢNG VẬT TƯ ĐÃ TỒN TẠI TRONG DANH SÁCH BOM CỦA SẢN PHẨM
                var dataUpdateSoLuong = new FormData();
                var amount = document.getElementById('amount').value;
                dataUpdateSoLuong.append("amount",amount)
                dataUpdateSoLuong.append('bom_id2', bom_id2);

                var xhr_dataUpdateSoLuong = new XMLHttpRequest();
                xhr_dataUpdateSoLuong.open('POST', '/thinhcuong/product_customer/bom_update.php', true);
                xhr_dataUpdateSoLuong.send(dataUpdateSoLuong);

                xhr_formDataInput.onload = function() {
                    if (xhr_formDataInput.status === 200) {
                        // echo 'Xử lý nhập dữ liệu thành công và csdl';
                        window.location.href =
                            '/thinhcuong/product_customer/product_customer_bom.php?sid='+ product_customer_id;
                    }
                };
            }else{
                    console.log('KHÔNG - Không có vật tư tồn tại trong bảng nên thêm mới gọi file bom_add.php ');
                    var product_customer_id = document.getElementById('product_customer_id').value;
                    var amount = document.getElementById('amount').value;
                    var currentDate = new Date(); // Lấy thời gian hiện tại
                    var year = currentDate.getFullYear();
                    var month = String(currentDate.getMonth() + 1).padStart(2, '0');
                    var day = String(currentDate.getDate()).padStart(2, '0');
                    var hours = String(currentDate.getHours()).padStart(2, '0');
                    var minutes = String(currentDate.getMinutes()).padStart(2, '0');
                    var seconds = String(currentDate.getSeconds()).padStart(2, '0');
    
                    var currentDate = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
                    formDataInput.append('product_customer_id', product_customer_id);
                    formDataInput.append('bom_id2', bom_id2);
                    formDataInput.append('amount', amount);
                    formDataInput.append('currentDate', getCurrentTime());
                    var xhr_formDataInput = new XMLHttpRequest();
                    // PHẦN NÀY QUAN TRỌNG
                    // TRƯỚC KHI GỬI DỮ LIỆU ĐỂ THÊM VÀO CSDL DANH SÁCH VẬT TƯ DÙNG CHO SẢN PHẨM THÌ HÃY KIỂM TRA
                    // XEM TRONG DANH SÁCH VẬT TƯ ĐÃ CÓ VẬT TƯ DỰ ĐỊNH THÊM VÀO CHƯA?
                    // NẾU CÓ RỒI THÌ HÃY CẬP NHẬP SỐ LƯỢNG CHO SẢN
                    xhr_formDataInput.open('POST', '/thinhcuong/product_customer/bom_add.php', true);
                    xhr_formDataInput.send(formDataInput);
    
                    xhr_formDataInput.onload = function() {
                        if (xhr_formDataInput.status === 200) {
                            // echo 'Xử lý nhập dữ liệu thành công và csdl';
                            window.location.href =
                                '/thinhcuong/product_customer/product_customer_bom.php?sid='+ product_customer_id;
                        }
                    };
                }
        }
    };
    

}