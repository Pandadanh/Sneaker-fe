<?php
include("../../Control/inc/config.php");
$sodong = 7;

$sodong = $_GET['sodong'];
$ngaymin = $_GET['ngaymin'];
$ngaymax = $_GET['ngaymax'];
$trangthai = $_GET['tinhtrang'];
$p = isset($_GET['p']) ? $_GET['p'] : 1; // Trang hiện tại, mặc định là 1

$params = array(
    'page' => $p,
    'size' => $sodong,
    'ngaymin' => $ngaymin,
    'ngaymax' => $ngaymax,
    'trangthai' => $trangthai
);

$query_string = http_build_query($params);

$url = "http://localhost:8080/api-admin/controller-don-hang/search?" . $query_string;

$response = file_get_contents($url);

if ($response === false) {
    echo 'Lỗi khi gửi yêu cầu.';
    exit;
}
$responseArray = json_decode($response, true);

if ($responseArray === null) {
    // echo 'Lỗi khi chuyển đổi JSON thành mảng.';
    exit;
}
$result = $responseArray['data'];

$sotrang = round($responseArray['trans_page'] / $sodong + 0.4);


// print_r($result);
foreach ($result as $row) {

    $khachhang = $row['khachHang'];
    $nhanvien = null;
    if ($row['trangThai'] != 0) {
        $nhanvien = $row['nhanvien'];
    }
?>
    <tr class="<?php if ($row['trangThai'] == '1') {
                    echo 'bg-g';
                } else if ($row['trangThai'] == '2') {
                    echo 'bg-r';
                } ?>">
        <td class="text-center"><?php echo $row['idPx']; ?></td>
        <td>
            <b>Id:</b> <?php echo $khachhang['idUser'] ?><br>
            <b>Name:</b> <?php echo $khachhang['tenUser'] ?><br>
            <b>Email:</b> <?php echo $khachhang['email'] ?><br>
            <b>Số điện thoại:</b> <?php echo $khachhang['soDienThoai'] ?><br>
        </td>
        <td>
            <?php
            if ($nhanvien != null) {
            ?>
                <b>Id:</b> <?php echo $nhanvien['idUser'] ?><br>
                <b>Name:</b> <?php echo $nhanvien['tenUser'] ?><br>
                <b>Email:</b> <?php echo $nhanvien['email'] ?><br>
                <b>Số điện thoại:</b> <?php echo $nhanvien['soDienThoai'] ?><br>
            <?php
            }
            ?>
        </td>
        <td class="text-center"><?php echo $row['ngayDat'] ?></td>
        <td class="text-center"><?php echo $row['tongSoLuong'] ?></td>
        <td class="text-right"><?php echo money($row['tongTien']); ?></td>
        <td class="text-center">
            <?php
            if ($row['trangThai'] == 0) {
            ?>
                <form method="post" id="dh-xacnhan">
                    <input type="text" name="id_xuly" hidden value="<?php echo $row['idPx']; ?>">
                    <button type="submit" onclick="return confirm('Bạn có muốn xác nhận đơn hàng không')" name="xacnhan" class="btn btn-warning btn-xs ">Xác nhận </button>
                    <button type="submit" onclick="return confirm('Bạn có muốn hủy đơn hàng không')" name="huydon" class="btn btn-danger btn-xs">Hủy Đơn </button>
                </form>
            <?php
            } else if ($row['trangThai'] == 1) {
            ?>
                Đã Xác Nhận
            <?php
            } else {
            ?>
                Đã hủy
            <?php
            }
            ?>
        </td>
        <td>
            <a href="#" class="btn btn-warning" data-href="" data-toggle="modal" onclick="chitietne(<?php echo $row['idPx'] ?>)" data-target="#chitiet">Chi Tiết</a>
        </td>
    </tr>
<?php
}
echo "???";
?>
<?php
for ($i = 1; $i <= $sotrang; $i++) {
    if ($sotrang == 1) {
        break;
    }
?>
    <li class="page-item <?php if ($p == $i) echo "active"; ?>"><a class="page-link" onclick="show(<?php echo $i; ?>)"><?php echo $i; ?></php></a></li>
<?php
}
?>