<?php
$sodong = 3;
$p = isset($_GET['p']) ? $_GET['p'] : 1; // Trang hiện tại, mặc định là 1

$params = array(
    'page' => $p,
    'size' => $sodong
);

$query_string = http_build_query($params);

$url = "http://localhost:8080/api-admin/controller-sliders/search?" . $query_string;

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
        <td class="col-md-1"><?php echo $row['id_sliders']; ?></td>
        <td class="col-md-2">
            <div class="col-md-4"></div>
            <img src="../../uploads/<?php echo $row['photo']; ?>" alt="" class="col-md-4">
        </td>
        <td class="col-md-2">
            <a id="sua" href="index.php?page=slider-edit&id=<?php echo $row['id_sliders']; ?>" class="btn btn-primary btn-xs">Edit</a>
            <a id="xoa" href="#" class="btn btn-danger btn-xs" data-href="index.php?page=slider-delete&id=<?php echo $row['id_sliders']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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