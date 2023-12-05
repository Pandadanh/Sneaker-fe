<?php
include("../../Control/inc/config.php");


$sodong = $_GET['sodong'];
$id_nh = $_GET['id_nh'];
$id_dm = $_GET['id_dm'];
$ngaymin = $_GET['ngaymin'];
$ngaymax = $_GET['ngaymax'];
$p = isset($_GET['p']) ? $_GET['p'] : 1; // Trang hiện tại, mặc định là 1

$params = array(
    'page' => $p,
    'size' => $sodong,
    'id_nh' => $id_nh,
    'id_dm' => $id_dm,
    'ngaymin' => $ngaymin,
    'ngaymax' => $ngaymax
);

$query_string = http_build_query($params);

$url = "http://localhost:8080/api-admin/controller-phieuxuat/thong-ke?" . $query_string;

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

foreach ($result as $row) {
?>
    <tr>
        <td class="text-center"><?php echo $row['product']['idPro'] ?></td>
        <td>
            <?php echo $row['product']['tenPro'] ?>
        </td>
        <td class="text-center">
            <?php echo $row['Tongsoluong'] ?>
        </td>
        <td class="text-right">
            <?php echo money($row['Tonggiatien'] ) ?>
        </td>
        <td class="text-center">
           <?php
            echo $row['Soluongconcai'];
           ?>
        </td>
    </tr>
<?php
}

echo "???";
?>
<?php
for ($i = 1; $i <= $sotrang; $i++) {
    if($sotrang==1){break;}
?>
    <li class="page-item <?php if ($p == $i) echo "active"; ?>"><a class="page-link" onclick="show(<?php echo $i; ?>)"><?php echo $i; ?></php></a></li>
<?php
}
?>