<?php

session_start();
if (!function_exists('money')) {
    function money($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', ',') . "{$suffix}";
        }
    }
}
// print_r($_SESSION);
$id_pro =$_GET['id_pro'];
$size = $_GET['size'];
$soluong = $_GET['soluong'];

$array = $_SESSION['cart'];

$co = 0;
foreach ($array as $index => $spgh) {
    if ($spgh['idPro'] == $id_pro && $spgh['size'] == $size) {
        // Kiểm tra và cập nhật số lượng sản phẩm trong giỏ hàng
        $array[$index]['soluong'] += $soluong;

        // Đảm bảo số lượng sản phẩm không nhỏ hơn 1
        if ($array[$index]['soluong'] >= 1) {
            $co = 1;
            $_SESSION['cart'] = $array; // Cập nhật giỏ hàng
            break;
        }
    }
}

$tongTien = 0;
$tongSoLuong = 0;

if (isset($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $row) {
        $tongSoLuong += $row['soluong'] * 1;
        $tongTien += $row['giaMoi'] * $row['soluong'];
    }
}

echo money($tongTien);
echo "???";
echo $tongSoLuong;


