<?php 
    include '../header.php';
    include '../function/function.php';
    $product_vendor_id = $_GET['sid'];
    $avatar = '1';
    $columValue = 'linkimage';
    $product_vendor_id = $_GET['sid'];
    // 
    $where = 'linkimage_avatar = 0 AND product_vendor_id';
    $product_vendor_ids = $_GET['sid'];
    // 
    $styles = getRecordTableById('tbl_product_vendor_style','status','0');
?>
<div class="container-fluid mx-md-auto custom-fixed-top">
    <div class="row">
    <div class="card-header font-weight-bold d-flex justify-content-between ">
                    <span>Thông tin chi tiết sản phẩm</span>
                    <a class="btn btn-info" href="/erpthinhcuong/product/product_update.php?product_vendor_id=<?php echo $product_vendor_id; ?>">Edit</a>

                </div>
    </div>
    <!-- chỗ này sẽ thêm button Export -->
    <div class="row">
        <div class="col-md-6">
            <div class="card my-4">
                <div class="card-body text-center">
                    <!-- Chỗ này là chỗ trình diễn hình ảnh sử dụng lightbox -->

                    <div class="gallery-item">
                        <?php 
                           $imageLink = getLinkImages($product_vendor_id, $avatar, $columValue);
                           if ($imageLink) {
                            // Hiển thị hình ảnh nếu có link
                            echo "<a class=\"lightbox\" href=\"".$imageLink."\"> <img class=\"imgproduct2\" src=\"".$imageLink."\" alt=\"Hình ảnh\"></a>";
                            } else {
                                // Hiển thị thông báo nếu không có link
                                echo "<a class=\"btn btn-info btn-sm\" href=\"#\">Add photo</a>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
       

        <div class="col-md-6">
            <div class="card my-4">
                <div class="card-header">
                    THÔNG TIN SẢN PHẨM
                </div>
                <?php 
                //   Lấy thông tin sản phẩm Thịnh Cường theo id get by url
                  $getProductVendors = getRecordTableById('tbl_product_vendor','id',$_GET['sid']);
                    if ($getProductVendors) {
                        foreach ($getProductVendors as $getProductVendor) {
                        }
                    }
                ?>
                <div class="card-body">
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Product code: </p><?php echo $getProductVendor['product_vendor_code'];?>
                      
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Dimension: </p>
                        <?php echo $getProductVendor['dimension_l'];?> cm x
                        <?php echo $getProductVendor['dimension_w'];?> cm x
                        <?php echo $getProductVendor['dimension_h'];?> cm
                    </div>
                    
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Net Weight: </p><?php echo $getProductVendor['netweight'];?> kg
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <!-- lấy Fullname của kiểu sản phẩm theo ID -->
                        <p class="fw-bold">Style:</p> <?php echo getAllTableById($getProductVendor['style_id'],$styles,'fullname') ;?>
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                        <p class="fw-bold">Notes:</p>
                    </div>
                    <div class="mb-3 phattriensanphammoi_space-between">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" disabled><?php echo $getProductVendor['note'];?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card my-4">
                <div class="card-header">
                    BỘ PHẬN KỸ THUẬT
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
                        //    $bomItems = getRecordTableById('tbl_product_customer_bom','product_vendor_id',$_GET['sid']);
                        //     if($bomItems){
                        //         foreach($bomItems as $bomItem){
                        //             echo "<p>".$bomItems['linkbom']."</p>";
                        //         }
                        //     }else{
                        //         echo "<p>Chưa có danh sách vật tư</p><a class=\"btn btn-info btn-sm\" href=\"#\">Thêm Danh Sách Vật Tư</a>";
                        //     }

                        ?>
                    </div>
                    <div class="mb-3">
                        <p class="fw-bold">File bản chi tiết: </p> <?php 
                           $bomItems = getRecordTableById('tbl_product_vendor_bomitem','product_vendor_id',$_GET['sid']);
                            if($bomItems){
                                foreach($bomItems as $bomItem){
                                    echo "<p>".$bomItems['linkbom']."</p>";
                                }
                            }else{
                                echo "<p>Chưa file bản vẽ chi tiết</p><a class=\"btn btn-info btn-sm\" href=\"#\">Thêm File Bản Vẽ Chi Tiết</a>";
                            }

                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card my-4">
                <div class="card-header">
                    BỘ PHẬN BÁO GIÁ
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <p class="fw-bold">File báo giá: </p>
                        <?php 
                           $bomItems = getRecordTableById('tbl_product_vendor_bomitem','product_vendor_id',$_GET['sid']);
                            if($bomItems){
                                foreach($bomItems as $bomItem){
                                    echo "<p>".$bomItems['linkbom']."</p>";
                                }
                            }else{
                                echo "<p>Chưa có file báo giá</p><a class=\"btn btn-info btn-sm\" href=\"#\">Thêm File Báo Giá</a>";
                            }

                        ?>
                    </div>
                </div>
            </div>
        </div>
       
    </div>

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
                        
                        $imageLinks = getRecordTableById('tbl_product_vendor_images', $where, $product_vendor_ids);
                        // Hiển thị hình ảnh nếu có link
                        if ($imageLinks) {
                            foreach($imageLinks as $imageLinka){
                                echo "<div class=\"gallery-item\">";
                                echo "<a class=\"lightbox\" href=".$imageLinka['linkimage'].">";
                                echo "<img src=".$imageLinka['linkimage'].">";
                                echo "</a>";
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