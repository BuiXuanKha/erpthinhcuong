    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
   
        <style>
        .selected {
            width: 100%;
            height: 5px;
            background-color: #333;
            position: relative;
        }

        .search {
            display: none;
            /* Ẩn div search ban đầu */
            width: 100%;
            height: 200px;
            background-color: #f3f3f3;
            position: absolute;
            top: 39px;
            bottom: 0;
            right: 0;
            left: 0;
        }
        </style>
    </head>

    <body>


        <body>
            <div class="container mt-5 custom-fixed-top">
                <div class="row">

                    <div class="selected" id="selectedDiv">
                        <select name="selected_kha" id="productDropdown" class="form-control" placeholder="Nhập mã sản phẩm">
                        </select>

                        <div class="search" id="searchDiv">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Nhập từ khóa tìm kiếm">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button">Tìm kiếm</button>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Product Code (Thịnh Cường)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $stt=1;
                                            include '../function/function.php';
                                            
                                            $product_vendors = getRecordTableById('tbl_product_vendor','status','0');

                                            if ($product_vendors) {
                                                foreach ($product_vendors as $product_vendor) {
                                                    echo "<tr>";
                                                    echo "<td>" . $stt++ . "</td>";
                                                    // Lấy link hình ảnh từ CSDL sử dụng hàm getLinkImages
                                                
                                                    echo "<td>" . $product_vendor['product_vendor_code'] . "</td>";

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
                </div>
                <div class="row">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. In sint delectus tempore laborum harum
                    voluptatibus, nesciunt laboriosam eaque perferendis eligendi nemo sequi debitis? Quam minima nisi
                    fuga omnis iusto ipsa.
                </div>
            </div>

            <!-- Bao gồm các tệp JavaScript của Bootstrap -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

            <script>
            $(document).ready(function() {
                $('#selectedDiv').click(function(event) {
                    event.stopPropagation(); // Ngăn chặn sự kiện click từ lan ra các phần tử cha khác
                    $('#searchDiv').show(); // Hiển thị div search khi nhấp vào div selected
                });

                $(document).click(function(event) {
                    if (!$(event.target).closest('#selectedDiv').length) {
                        $('#searchDiv').hide(); // Ẩn div search khi nhấp ra ngoài div selected
                    }
                });
            });
            </script>

        </body>

    </html>