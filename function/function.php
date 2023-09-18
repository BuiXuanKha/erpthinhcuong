
<?php
// Lấy toàn bộ thông tin 1 bảng
function getAllTable($tableName) {
    include '../connect.php';
    // Truy vấn dữ liệu từ bảng
    $query = "SELECT * FROM " . $tableName;
    $result = $conn->query($query);

    // Kiểm tra và xử lý kết quả
    if ($result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $result->close();
        $conn->close();
        return $rows;
    } else {
        $result->close();
        $conn->close();
        return false;
    }
}
/*
Hàm này lấy toàn bộ sản phẩm trong bảng tbl_product_vendor và sắp xếp theo trường product_vendor_code
để khi thêm sản phẩm mới cho Khách hàng, người dùng có thể chọn dễ hơn
*/
function getAllTableProductVendor($tableName) {
    include '../connect.php';
    // Truy vấn dữ liệu từ bảng
    // $query = "SELECT * FROM " . $tableName;
    $query = "SELECT * FROM ". $tableName . " ORDER BY product_vendor_code ASC;";
    $result = $conn->query($query);

    // Kiểm tra và xử lý kết quả
    if ($result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $result->close();
        $conn->close();
        return $rows;
    } else {
        $result->close();
        $conn->close();
        return false;
    }
}
// Hàm này truyền vào 3 biến:
//  - 1: tên bảng
//  - 2: Trường cần lấy thông tin
//  - 3: id (đã có từ bảng nào đó)
// getAllTableByID2 Replace by get
function getRecordTableById($tableName,$where,$id) {
    // Kết nối đến cơ sở dữ liệu
    include '../connect.php';

    // Sử dụng prepared statement để ngăn chặn tấn công SQL injection
    $stmt = $conn->prepare("SELECT * FROM ".$tableName." WHERE ".$where." = ? ORDER BY create_at DESC");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Lấy kết quả từ câu truy vấn
    $result = $stmt->get_result();

    // Kiểm tra xem có bản ghi nào được tìm thấy hay không
    if ($result->num_rows > 0) {
        // Lặp qua các bản ghi và lấy dữ liệu
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $result->close();
        $conn->close();
        $stmt->close();
        return $rows;
    } else {
        $stmt->close();
        $result->close();
        $conn->close();
    }
}

// Lấy thông tin bản ghi bằng ID
// - Id: id bản ghi 
// - dataTable là toàn bộ bản ghi được lấy ví dụ: SELECT * FROM TABLE  
function getAllTableById($id, $dataTables, $target) {
    foreach ($dataTables as $dataTable) {
        if ($dataTable['id'] == $id) {
            return $dataTable[$target];
        }
    }
    return "Không tìm thấy khách hàng a ";
}
function getAllTableByIds($id, $dataTables, $target) {
    if (empty($dataTables)) {
        return "khongcohinhanh";
    }

    foreach ($dataTables as $dataTable) {
        if ($dataTable['product_vendor_id'] == $id) {
            return $dataTable[$target];
        }
    }
}


function getLinkImages($productId, $avatar, $columValue) {
    // Truy vấn CSDL để lấy link hình ảnh
    include '../connect.php';
    $query = "SELECT $columValue FROM tbl_product_vendor_images WHERE product_vendor_id = $productId AND linkimage_avatar = '$avatar'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result); // Giải phóng biến $result
        mysqli_close($conn);
        return $row[$columValue];
    } else {
        mysqli_close($conn);
        return false;
    }
}
function getLinkImagesProductCustomer($productId, $avatar, $columValue) {
    // Truy vấn CSDL để lấy link hình ảnh
    include '../connect.php';
    $query = "SELECT $columValue FROM tbl_product_customer_image WHERE product_customer_product_id = $productId AND avatar = '$avatar'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result); // Giải phóng biến $result
        mysqli_close($conn);
        return $row[$columValue];
    } else {
        mysqli_close($conn);
        return false;
    }
}

// Đếm số công việc của nhân viên trong bảng tbl_qcteamjob
function countEmployeeJobs($table,$employeeId) {
    include '../connect.php';
    // Sử dụng Prepared Statement để tránh tấn công SQL Injection
    // Đếm số lượng job của 1 nhân viên ( bao gồm việc [Đang làm] và [Hoàn Thành], còn việc đã có status = 1 là đã xoá)
    $sql = "SELECT COUNT(*) AS job_count FROM ".$table." WHERE assignee_id = ? And status = 0";

    // Chuẩn bị và thực thi truy vấn
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Lấy kết quả từ truy vấn
    $row = $result->fetch_assoc();
    $jobCount = $row['job_count'];

    // Đóng kết nối
    $stmt->close();
    $conn->close();
    
    // Kiểm tra nếu giá trị nhỏ hơn 10 thì thêm số 0 phía trước
    if ($jobCount < 10) {
        $jobCount = str_pad($jobCount, 2, '0', STR_PAD_LEFT);
    }

    return $jobCount;
}
// Đếm số công việc HOÀN THÀNH của nhân viên trong bảng tbl_qcteamjob
function countCompletedJobs($table,$employeeId) {
    include '../connect.php';
    // Sử dụng Prepared Statement để tránh tấn công SQL Injection
    // Đếm số lượng job của 1 nhân viên ( bao gồm việc [Đang làm] và [Hoàn Thành], còn việc đã có status = 1 là đã xoá)
    $sql = "SELECT COUNT(*) AS completed_count FROM ".$table." WHERE statusjob = 'Hoàn thành' AND assignee_id = ? AND status = '0'";

    // Chuẩn bị và thực thi truy vấn
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Lấy kết quả từ truy vấn
    $row = $result->fetch_assoc();
    $completedCount = $row['completed_count'];

    // Đóng kết nối
    $stmt->close();
    $conn->close();
    
    // Kiểm tra nếu giá trị nhỏ hơn 10 thì thêm số 0 phía trước
    if ($completedCount < 10) {
        $completedCount = str_pad($completedCount, 2, '0', STR_PAD_LEFT);
    }

    return $completedCount;
}


// Hàm rút ngắn ký tự
function shortenText($text, $maxLength = 80) {
    if (strlen($text) > $maxLength) {
        $text = substr($text, 0, $maxLength); // Cắt chuỗi đến độ dài tối đa
        $text = substr($text, 0, strrpos($text, ' ')); // Cắt chuỗi đến khoảng trắng gần nhất để không bị cắt giữa từ
        $text .= '...'; // Thêm dấu "..." ở cuối
    }
    return $text;
}

// Hàm thêm bản ghi log vào bảng tbl_log
function addLog($logComments) {
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    // Kết nối đến cơ sở dữ liệu (sử dụng các thông số kết nối của bạn)
    include '../connect.php';
    $currentDate = date('Y-m-d H:i:s');
    // Escape dữ liệu trước khi thêm vào câu truy vấn để đảm bảo an toàn
    $logComments = mysqli_real_escape_string($conn, $logComments);
    // $status = mysqli_real_escape_string($conn, $status);

    // Tạo câu truy vấn INSERT
    $query = "INSERT INTO tbl_log (logComments, create_at) VALUES ('$logComments', '$currentDate')";

    // Thay đổi $connection thành $conn ở dòng sau:
    mysqli_query($conn, $query);

    // Đóng kết nối
    mysqli_close($conn);

}
// START - Hàm cắt bớt ký tự trong tên file nếu > 100 ký tự
function trimFilename($filename, $maxLength) {
    if (strlen($filename) > $maxLength) {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $basename = substr($filename, 0, $maxLength - strlen($extension) - 1);
        $filename = $basename . '.' . $extension;
    }
    return $filename;
}
function generateNewFileName($originalFileName, $maxFilenameLength = 100) {
    $trimmedFileName = trimFilename($originalFileName, $maxFilenameLength);
    $newFileName = time() . '_' . $trimmedFileName;
    return $newFileName;
}

// // THE END - Hàm cắt bớt ký tự trong tên file nếu > 100 ký tự

// function.php

// Hàm trả về danh sách sản phẩm với mã sản phẩm tương tự từ bảng tbl_product_vendor
function getSearchProduct($keyword) {
    
    include '../connect.php';
    // Truy vấn tìm kiếm sản phẩm với product_vendor_code tương tự
    $sql = "SELECT * FROM tbl_product_vendor WHERE product_vendor_code LIKE '%$keyword%'";
    $result = mysqli_query($conn, $sql);

    $products = array();

    // Kiểm tra và lấy dữ liệu từ kết quả truy vấn
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }
    }

    // Đóng kết nối
    mysqli_close($conn);

    return $products;
}
?>

