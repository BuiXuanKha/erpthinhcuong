<?php
include '../connect.php';
$key = $_POST['key'];
$query = "SELECT product_vendor_code FROM tbl_product_vendor WHERE product_vendor_code LIKE '$key%'";
$result =  mysqli_query($conn, $query);

$matchingProducts = array();
while ($row = $result->fetch_assoc()) {
    $matchingProducts[] = $row['product_vendor_code'];
}

// Đóng kết nối
mysqli_close($conn);

if (count($matchingProducts) === 0) {
    $newSuffix = "0001";
} else {
    $maxSuffix = -1;
    $prefixLength = strlen($key);
    foreach ($matchingProducts as $productCode) {
        $prefix = substr($productCode, 0, $prefixLength);
        if ($prefix === $key) {
            $suffix = (int) substr($productCode, $prefixLength);
            if (is_numeric($suffix) && $suffix > $maxSuffix) {
                $maxSuffix = $suffix;
            }
        }
    }

    if ($maxSuffix === -1) {
        $newSuffix = "0001";
    } else {
        $newSuffix = str_pad(($maxSuffix + 1), 4, "0", STR_PAD_LEFT);
    }
}

echo json_encode(array("result" => $key . $newSuffix));
?>
