<?php 
    include '../header.php';
    include '../function/function.php';
    $product_customer_id = $_GET['sid'];

    $getProductCustomers = getRecordTableById('tbl_product_customer','id',$product_customer_id);
    if ($getProductCustomers) {
        foreach ($getProductCustomers as $getProductCustomer) {
        }
    }
    $getProductVendors = getRecordTableById('tbl_product_vendor','id',$getProductCustomer['product_vendor_id']);
    if ($getProductVendors) {
        foreach ($getProductVendors as $getProductVendor) {
        }
    }
    $colors = getRecordTableById('tbl_color','status','0');
    $frames = getRecordTableById('tbl_frame','status','0');
    $woods = getRecordTableById('tbl_wood','status','0');
    $fabrics = getRecordTableById('tbl_fabric','status','0');
    $ropes = getRecordTableById('tbl_rope','status','0');

    $ceramics = getRecordTableById('tbl_ceramic','status','0');
    $stylecategorys = getRecordTableById('tbl_product_vendor_style','status','0');
    $customers = getRecordTableById('tbl_customer','status','0');

    $where = 'product_customer_product_id';
    $product_vendor_ids = $_GET['sid'];
?>
<div class="container-fluid mx-md-auto custom-fixed-top">
    <div class="row">
        <div class="card-header font-weight-bold d-flex justify-content-between ">
            <span>Thông tin chi tiết sản phẩm
                <?php echo getAllTableById($getProductCustomer['customer_id'], $customers,'fullname'); ?> -
                <?php echo $getProductCustomer['product_customer_code'];?> </span>
            <a class="btn btn-info"
                href="/erpthinhcuong/product_customer/product_customer_update.php?sid=<?php echo $product_customer_id; ?>">Edit</a>
        </div>
    </div>
    <!-- HÌNH ẢNH ĐẠI DIỆN SẢN PHẨM VÀ THÔNG TIN SẢN PHẨM -->
    <div class="row">
        <div class="col-md-6">
            <div class="card my-4">
                <div class="card-body text-center">
                    <!-- Chỗ này là chỗ trình diễn hình ảnh sử dụng lightbox -->

                    <div class="gallery-item">
                        <?php 
                            $avatar = 1;
                            $columValue = 'linkimage';
                            // $product_customer_id = $_GET['sid'];
                            include '../connect.php';
                            $query = "SELECT linkimage FROM tbl_product_customer_image WHERE product_customer_product_id =".$product_customer_id." AND avatar = 1";
                            // echo $query;
                            $result = mysqli_query($conn, $query);
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $imageLink = $row['linkimage'];
                                echo "<a class=\"lightbox\" href=\"" . $imageLink . "\"><img class=\"imgproduct2\" src=\"" . $imageLink . "\"></a>";
                                mysqli_free_result($result); // Giải phóng bộ nhớ sau khi sử dụng kết quả
                            } else {
                                echo "<a class=\"btn btn-info btn-sm\" href=\"#\">Add photo</a>";
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- THÔNG TIN SẢN PHẨM -->
        <div class="col-md-6">
            <div class="card my-4">
                <div class="card-header">
                    THÔNG TIN SẢN PHẨM
                </div>
                <div class="card-body">
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Product name: </p><?php echo $getProductCustomer['fullname'];?>
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Product code: </p><?php echo $getProductVendor['product_vendor_code'];?>
                        <p class="fw-bold">Customer code: </p>
                        <?php echo $getProductCustomer['product_customer_code'];?>
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Dimension: </p>
                        <?php echo $getProductVendor['dimension_l'];?> cm x
                        <?php echo $getProductVendor['dimension_w'];?> cm x
                        <?php echo $getProductVendor['dimension_h'];?> cm
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Carton: </p>
                        <?php echo $getProductCustomer['carton_l'];?> cm x
                        <?php echo $getProductCustomer['carton_w'];?> cm x
                        <?php echo $getProductCustomer['carton_h'];?> cm
                        <p class="fw-bold">Loading:</p>Chưa có
                        <p class="fw-bold">CBM:</p>
                        <?php
                            $cbm = $getProductCustomer['carton_l'] * $getProductCustomer['carton_w'] * $getProductCustomer['carton_h'];
                            $cbm_in_cubic_meters = $cbm / 1000000; // Chuyển đổi thành mét khối
                            $formatted_cbm = number_format($cbm_in_cubic_meters, 2); // Định dạng với 2 chữ số sau dấu thập phân
                            echo $formatted_cbm." m3";
                        ?>
                        <p class="fw-bold">CTN:</p>
                        <p><?php echo $getProductCustomer['ctn_carton']?> per</p>

                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Dolly: </p>
                        <?php echo $getProductCustomer['dolly_l'];?> cm x
                        <?php echo $getProductCustomer['dolly_w'];?> cm x
                        <?php echo $getProductCustomer['dolly_h'];?> cm
                        <p class="fw-bold">Loading:</p>Chưa có
                        <p class="fw-bold">CBM:</p>
                        <?php
                            $cbm = $getProductCustomer['dolly_l'] * $getProductCustomer['dolly_w'] * $getProductCustomer['dolly_h'];
                            $cbm_in_cubic_meters = $cbm / 1000000; // Chuyển đổi thành mét khối
                            $formatted_cbm = number_format($cbm_in_cubic_meters, 2); // Định dạng với 2 chữ số sau dấu thập phân
                            echo $formatted_cbm." m3";
                        ?>
                        <p class="fw-bold">CTN:</p>
                        <p><?php echo $getProductCustomer['ctn_dolly']?> per</p>
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Pallet: </p>
                        <?php echo $getProductCustomer['pallet_l'];?> cm x
                        <?php echo $getProductCustomer['pallet_w'];?> cm x
                        <?php echo $getProductCustomer['pallet_h'];?> cm
                        <p class="fw-bold">Loading:</p>Chưa có
                        <p class="fw-bold">CBM:</p>
                        <?php
                            $cbm = $getProductCustomer['pallet_l'] * $getProductCustomer['pallet_w'] * $getProductCustomer['pallet_h'];
                            $cbm_in_cubic_meters = $cbm / 1000000; // Chuyển đổi thành mét khối
                            $formatted_cbm = number_format($cbm_in_cubic_meters, 2); // Định dạng với 2 chữ số sau dấu thập phân
                            echo $formatted_cbm." m3";
                        ?>
                        <p class="fw-bold">CTN:</p>
                        <p><?php echo $getProductCustomer['ctn_pallet']?> per</p>
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Net Weight: </p> <?php echo $getProductVendor['netweight'];?> kg
                        <p class="fw-bold">Gross Weight: </p> <?php echo $getProductCustomer['grossweight'];?> kg
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Khung: </p>
                        <?php echo getAllTableById($getProductCustomer['frame_id'], $frames,'name'); ?>
                        <p class="fw-bold">Gỗ: </p>
                        <?php echo getAllTableById($getProductCustomer['wood_id'], $woods,'name'); ?>
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Dây: </p>
                        <?php echo getAllTableById($getProductCustomer['rope_id'], $ropes,'name'); ?>
                        <p class="fw-bold">Vải: </p>
                        <?php echo getAllTableById($getProductCustomer['fabric_id'], $fabrics,'name'); ?>
                        <p class="fw-bold">Đá: </p>
                        <?php echo getAllTableById($getProductCustomer['ceramic_id'], $ceramics,'name'); ?>
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Color:</p>
                        <?php echo getAllTableById($getProductCustomer['color_id'], $colors,'color_code'); ?>
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Style:</p>

                        <?php echo getAllTableById($getProductVendor['style_id'], $stylecategorys,'fullname'); ?>
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Customer:</p>
                        <?php echo getAllTableById($getProductCustomer['customer_id'], $customers,'fullname'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- BỘ PHẬN KỸ THUẬT -->
        <div class="col-md-4">
            <div class="card my-4">
                <div class="card-header">
                    TÀI LIỆU KỸ THUẬT
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <?php 
                            // if ($getProductTechnicalFiles) {
                            //     echo "<p class=\"fw-bold\">Bản vẽ tổng thể: </p>";
                                
                            //     foreach ($getProductTechnicalFiles as $key => $getProductTechnicalFile) {
                            //         $version = count($getProductTechnicalFiles) - $key;
                                    
                            //         if ($key === 0) {
                            //             echo "<div><span style=\"opacity: 1;\"> Version " . $version . ".0: <a href=". $getProductTechnicalFile['linkfile'] .">Download</a></span>";
                            //             echo "<span style=\"opacity: 1;\"> Updated at " . $getProductTechnicalFile['create_at'] . " by " . $getProductTechnicalFiles_employee_fullname['fullname'] . "</span></div>";
                            //             echo "<div><span style=\"opacity: 1;\">Ghi chú: Thay đổi độ dày bản mã bắt vít từ 2.0mm sang 3.5mm </span></div>";
                            //             echo "<hr>";
                            //         } else {
                            //             echo "<div><span style=\"opacity: 0.5; pointer-events: none;\"> Version " . $version . ".0: <a href=\"#\">Liên hệ bộ phận Kỹ Thuật</a></span>";
                            //             echo "<span style=\"opacity: 0.5; pointer-events: none;\"> Updated at " . $getProductTechnicalFile['create_at'] . " by " . $getProductTechnicalFiles_employee_fullname['fullname'] . "</span></div>";
                            //             echo "<div><span style=\"opacity: 0.5; pointer-events: none;\">Ghi chú: Thay đổi độ dày bản mã bắt vít từ 2.0mm sang 3.5mm</span></div>";
                            //         }
                            //     }
                            // } else {
                            //     echo "Không thể lấy dữ liệu từ cơ sở dữ liệu.";
                            // }
                        ?>
                    </div>
                    <!-- Nếu là BỘ PHẬN KỸ THUẬT thì có thể hiện thông tin bản vẽ Chi tiết,
                        còn với phòng ban khác thì làm mờ đi thông tin này. -->
                    <div class="mb-3">
                        <p class="fw-bold">Bảng kê vật tư: </p>
                        <?php 
                            // Lấy danh sách vật tư theo ID sản phẩm và Btn Cập nhật vật tư
                            // $where = 'product_customer_id=';
                            // Lấy chỗ này làm ví dụ thôi
                            $where ='status = 0 AND product_customer_id';
                            $listBOMs = getRecordTableById('tbl_product_customer_bom',$where,$product_customer_id);
                            // Nếu không có thì hiện Btn Thêm Vật Tư
                            // href=\"product_customer_details.php?sid=".$product_customer["id"]."&menu=product\">Details</a>
                            if($listBOMs){
                                echo "<a class=\"btn btn-info\" href=\"/erpthinhcuong/product_customer/product_customer_bom.php?sid=".$_GET['sid']."\">Xem danh sách vật tư</a> ";
                                // echo "<a class=\"btn btn-info\" href=\"#\">Cập nhật vật tư</a>";
                            }else{
                                echo "<a class=\"btn btn-info\" href=\"/erpthinhcuong/product_customer/product_customer_bom.php?sid=".$_GET['sid']."\">Thêm vật tư</a>";
                            }
                            ?>
                    </div>
                    <!-- FILE BẢN VẼ CHI TIẾT -->
                    <div class="mb-3">
                        <p style="margin-bottom: 1px" class="fw-bold">File bản vẽ chi tiết: </p>
                        <?php 
                             $where ='status = 0 AND product_customer_id';
                             $listTechFiles = getRecordTableById('tbl_product_customer_techfile',$where,$product_customer_id);
                             $employees = getRecordTableById('tbl_employee','status','0');
                             if($listTechFiles){
                                 foreach($listTechFiles as $key => $listTechFile){
                                    $version = count($listTechFiles) - $key;
                                    if($key === 0){
                                        echo "<p style=\"margin-bottom: 1px\"> Version:".$version." | ".basename($listTechFile['linkfile'])." <a class=\"btn btn-info btn-sm\" href=\"#\">Download</a></p>";
                                        echo "<p style=\"margin-bottom: 1px\">Upload by: ".getAllTableById($listTechFile['employee_id'],$employees,'fullname')." | Created at: ".$listTechFile['create_at']."</p>";
                                        echo "<p style=\"margin-bottom: 1px\" class=\"fw-bold\">Ghi chú: </p>";
                                        echo "<p style=\"margin-bottom: 1px\">".$listTechFile['note']."</p>";
                                        echo "<hr>";
                                    }else{
                                        echo "<p style=\"margin-bottom: 1px;opacity: 0.8; pointer-events: none;\"> Version:".$version." | ".basename($listTechFile['linkfile'])." <a class=\"btn btn-secondary btn-sm\" href=\"#\">Download</a></p>";
                                        echo "<p style=\"margin-bottom: 1px;opacity: 0.8; pointer-events: none;\">Upload by: ".getAllTableById($listTechFile['employee_id'],$employees,'fullname')." | Created at: ".$listTechFile['create_at']."</p>";
                                        echo "<p style=\"margin-bottom: 1px;opacity: 0.8; pointer-events: none;\" class=\"fw-bold\">Ghi chú: </p>";
                                        echo "<p style=\"margin-bottom: 1px;opacity: 0.8; pointer-events: none;\">".$listTechFile['note']."</p>";
                                        echo "<hr>";
                                    }
                                }
                            }else{
                                echo "Chưa có thông tin file bản vẽ chi tiết của sản phẩm";
                                echo "<a class=\"btn btn-info btn-sm\" href=\"\">Update File</a>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- BỘ PHẬN QC -->
        <div class="col-md-4">
            <div class="card my-4">
                <div class="card-header">
                    TÀI LIỆU QC
                </div>
                <div class="card-body">
                    <!-- File QC0 -->
                    <div class="mb-3">
                        <p style="margin-bottom: 1px" class="fw-bold">File QC0: </p>
                        <?php 
                             $where ='status = 0 AND product_customer_id';
                             $listFileQC0s = getRecordTableById('tbl_product_customer_qcfile',$where,$product_customer_id);
                             $employees = getRecordTableById('tbl_employee','status','0');
                             if($listFileQC0s){
                                 foreach($listFileQC0s as $key => $listFileQC0){
                                    $version = count($listFileQC0s) - $key;
                                    if($key === 0){
                                        if(strval($listFileQC0['update_status']) === '1'){
                                            // Chuyển đổi ngày tạo bản ghi thành đối tượng DateTime
                                            $dateTimeCreated = new DateTime($listFileQC0['update_create_at']);
                                            // Ngày hiện tại
                                            $today = new DateTime();
                                            // Tính toán sự khác biệt giữa ngày tạo bản ghi và ngày hiện tại
                                            $interval = $today->diff($dateTimeCreated);
                                            // Lấy số ngày khác biệt
                                            $daysDifference = $interval->days;
                                            // Do $listFileQC0['update_employee_id'] có kiểu dữ liệu là integer lấy từ csdl ra,
                                            // nên cần dùng hàm strval() để chuyển về String giống kiểu dữ liệu của $_SESSION['sid_employee']
                                            if($_SESSION['sid_employee'] === strval($listFileQC0['update_employee_id'])){
                                                echo "Bạn đang chỉnh sửa file Layout [".$daysDifference." ngày] ";
                                                echo "<a href=\"#\" class=\"btn btn-info btn-sm\">Upload file</a>";
                                            }else{
                                                // echo "ID không trùng khớp";
                                                echo "<button style=\"pointer-events: none;\" class=\"btn btn-warning\">
                                                Bùi Xuân Khả</button> Đang chỉnh sửa file Layout [".$daysDifference." ngày]";
                                            }
                                            echo "<hr>";
                                        }else{
                                            echo "<p style=\"margin-bottom: 1px\"> Version:".$version." | ".basename($listFileQC0['linkfile'])." <a class=\"btn btn-info btn-sm\" href=\"#\">Download</a></p>";
                                            echo "<p style=\"margin-bottom: 1px\">Upload by: ".getAllTableById($listFileQC0['employee_id'],$employees,'fullname')." | Created at: ".$listFileQC0['create_at']."</p>";
                                            echo "<p style=\"margin-bottom: 1px\" class=\"fw-bold\">Ghi chú: </p>";
                                            echo "<p style=\"margin-bottom: 1px\">".$listFileQC0['note']."</p>";
                                            echo "<hr>";
                                        }
                                    }else{
                                        echo "<p style=\"margin-bottom: 1px;opacity: 0.8; pointer-events: none;\"> Version:".$version." | ".basename($listFileQC0['linkfile'])." <a class=\"btn btn-secondary btn-sm\" href=\"#\">Download</a></p>";
                                        echo "<p style=\"margin-bottom: 1px;opacity: 0.8; pointer-events: none;\">Upload by: ".getAllTableById($listFileQC0['employee_id'],$employees,'fullname')." | Created at: ".$listFileQC0['create_at']."</p>";
                                        echo "<p style=\"margin-bottom: 1px;opacity: 0.8; pointer-events: none;\" class=\"fw-bold\">Ghi chú: </p>";
                                        echo "<p style=\"margin-bottom: 1px;opacity: 0.8; pointer-events: none;\">".$listFileQC0['note']."</p>";
                                        echo "<hr>";
                                    }
                                }
                            }else{
                                echo "Chưa có thông tin file QC0 của sản phẩm ";
                                echo "<a class=\"btn btn-info btn-sm\" href=\"\">Update File</a>";
                            }
                        ?>
                    </div>
                    <!-- File layout -->
                    <div class="mb-3">
                        <p style="margin-bottom: 1px" class="fw-bold">File layout: </p>
                        <?php 
                            // Nháp isCheckEdit
                            $isCheckEdit = '1';
                             $where ='status = 0 AND product_customer_id';
                             $listFileQC0s = getRecordTableById('tbl_product_customer_qcfile',$where,$product_customer_id);
                             $employees = getRecordTableById('tbl_employee','status','0');
                             
                             if($listFileQC0s){
                                 foreach($listFileQC0s as $key => $listFileQC0){
                                    $version = count($listFileQC0s) - $key;
                                    if($key === 0){
                                        if(strval($listFileQC0['update_status']) === '1'){
                                            // Chuyển đổi ngày tạo bản ghi thành đối tượng DateTime
                                            $dateTimeCreated = new DateTime($listFileQC0['update_create_at']);
                                            // Ngày hiện tại
                                            $today = new DateTime();
                                            // Tính toán sự khác biệt giữa ngày tạo bản ghi và ngày hiện tại
                                            $interval = $today->diff($dateTimeCreated);
                                            // Lấy số ngày khác biệt
                                            $daysDifference = $interval->days;
                                            // Do $listFileQC0['update_employee_id'] có kiểu dữ liệu là integer lấy từ csdl ra,
                                            // nên cần dùng hàm strval() để chuyển về String giống kiểu dữ liệu của $_SESSION['sid_employee']
                                            if($_SESSION['sid_employee'] === strval($listFileQC0['update_employee_id'])){
                                                echo "Bạn đang chỉnh sửa file Layout [".$daysDifference." ngày] ";
                                                echo "<a href=\"#\" class=\"btn btn-info btn-sm\">Upload file</a>";
                                            }else{
                                                // echo "ID không trùng khớp";
                                                echo "<button style=\"pointer-events: none;\" class=\"btn btn-warning\">
                                                Bùi Xuân Khả</button> Đang chỉnh sửa file Layout [".$daysDifference." ngày]";
                                            }
                                            echo "<hr>";
                                        }else{
                                            echo "<p style=\"margin-bottom: 1px\"> Version:".$version." | ".basename($listFileQC0['linkfile'])." <a class=\"btn btn-info btn-sm\" href=\"#\">Download</a></p>";
                                            echo "<p style=\"margin-bottom: 1px\">Upload by: ".getAllTableById($listFileQC0['employee_id'],$employees,'fullname')." | Created at: ".$listFileQC0['create_at']."</p>";
                                            echo "<p style=\"margin-bottom: 1px\" class=\"fw-bold\">Ghi chú: </p>";
                                            echo "<p style=\"margin-bottom: 1px\">".$listFileQC0['note']."</p>";
                                            echo "<hr>";
                                        }
                                    }
                                    else{
                                        echo "<p style=\"margin-bottom: 1px;opacity: 0.8; pointer-events: none;\"> Version:".$version." | ".basename($listFileQC0['linkfile'])." <a class=\"btn btn-secondary btn-sm\" href=\"#\">Download</a></p>";
                                        echo "<p style=\"margin-bottom: 1px;opacity: 0.8; pointer-events: none;\">Upload by: ".getAllTableById($listFileQC0['employee_id'],$employees,'fullname')." | Created at: ".$listFileQC0['create_at']."</p>";
                                        echo "<p style=\"margin-bottom: 1px;opacity: 0.8; pointer-events: none;\" class=\"fw-bold\">Ghi chú: </p>";
                                        echo "<p style=\"margin-bottom: 1px;opacity: 0.8; pointer-events: none;\">".$listFileQC0['note']."</p>";
                                        echo "<hr>";
                                    }
                                }
                            }else{
                                echo "Chưa có thông tin file Layout của sản phẩm ";
                                echo "<a class=\"btn btn-info btn-sm\" href=\"\">Update File</a>";
                            }
                        ?>
                    </div>
                    <div class="mb-3">
                        <p class="fw-bold">File AI: </p> <a href="#">AI_OT020.pdf</a>
                    </div>
                    <div class="mb-3">
                        <p class="fw-bold">File Shiping Mark and Hangtag: </p> <a
                            href="#">Shiping_Mark_and_Hangtag_OT020.pdf</a>
                    </div>
                    <div class="mb-3">
                        <p class="fw-bold">File Testing Certificate: </p> <a
                            href="#">File_Testing_Certificate_OT020.pdf</a>
                    </div>
                    <div class="mb-3">
                        <p class="fw-bold">Packing Instructions: </p> <a href="#">Packing_Instructions.pdf</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card my-4">
                <div class="card-header">
                    TÀI LIỆU BÁO GIÁ
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="fw-bold">File báo giá: </p> <a href="#">bao_gia_OT020.pdf</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- HÌNH ẢNH SẢN PHẨM -->
    <div class="row">
        <div class="col-md-12">
            <div class="card my-4">
                <div class="card-header">
                    HÌNH ẢNH SẢN PHẨM
                </div>
                <div class="card-body">
                    <!-- Chỗ này sử dụng Light Box -->
                    <div class="tz-gallery">
                        <div class="image-gallery">
                            <?php 
                        // Nếu hình ảnh đó có product_vendor_id = ID và  linkimage_avatar = 0 thì lấy hình ảnh
                        // mục đích lấy hình ảnh của sản phẩm, nếu không có hình ảnh của sản phẩm thì có thể hiện nút Add thêm hình ảnh
                        $whereimages ='status = 0 AND product_customer_product_id';
                        // SELECT * FROM tbl_product_customer_image WHERE status = 0 AND product_customer_product_id = 46 ORDER BY create_at DESC
                        $imageLinks = getRecordTableById('tbl_product_customer_image', $whereimages, $product_vendor_ids);
                        // Hiển thị hình ảnh nếu có link
                        if ($imageLinks) {
                            foreach($imageLinks as $imageLinka){
                                echo "<div class=\"gallery-item d-flex flex-column align-items-center \">";
                                echo "<a class=\"lightbox\" href=\"".$imageLinka['linkimage']."\">";
                                echo "<img src=\"".$imageLinka['linkimage']."\">";
                                echo "</a>";
                                echo "<hr>";
                                if($imageLinka['avatar'] == 1){
                                    echo "<a class=\"btn btn-success \">Hình đại diện</a>";
                                }else{

                                    echo "<a class=\"btn btn-info \" href=\"/erpthinhcuong/product_customer/setAvatar.php?idSetAvatar=".$imageLinka['id']."&product_customer_id=".$product_customer_id."\" >Set hình đại diện</a>";
                                }
                                echo "</div>";
                            }
                        } else {
                            // Nếu không có hình ảnh nào thì có thể thêm add photo để nhân viên có thêm hình ảnh
                            echo "<a class=\"btn btn-info btn-sm\" href=\"#\">Add photo</a>";
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../footer.php'?>