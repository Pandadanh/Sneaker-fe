
<?php

$sodong = 7;

// $sodong = $_GET['sodong'];
$search = $_GET['search'];
$id_dm = $_GET['search'];
$p = isset($_GET['p']) ? $_GET['p'] : 1; // Trang hiện tại, mặc định là 1

$params = array(
    'page' => $p,
    'size' => $sodong,
    'search' => $search,
    'id_nh' => $id_dm
);

$query_string = http_build_query($params);

$url = "http://localhost:8080/api-admin/controller-nhanhieu/search?" . $query_string;

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
    <tr class="dong">
        <td><?php echo $row['id_nh']; ?></td>
        <td><?php echo $row['nhanhieu']; ?></td>
        <td>
            <a id="sua" href="index.php?page=nhanhieu-edit&id=<?php echo $row['id_nh']; ?>" class="btn btn-primary btn-xs" >Edit</a>
            <a id="xoa" href="#" class="btn btn-danger btn-xs" data-href="../Model/nhanhieu-delete-xl.php?id=<?php echo $row['id_nh']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
        </td>
    </tr>

<?php
    // break;
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
