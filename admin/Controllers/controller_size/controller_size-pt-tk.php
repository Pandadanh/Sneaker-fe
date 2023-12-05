<?php
$sodong = 7;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$page = isset($_GET['p']) ? $_GET['p'] : 1; // Trang hiện tại


if (empty($_GET['search'])) {
    $api_url = 'http://localhost:8080/api-admin/controller-size/show/'. $page;
} else {
    $search = $_GET['search'];
    $api_url = "http://localhost:8080/api-admin/controller-size/show-search/" . urlencode($search) . "/" . $page;

}

$curl = curl_init($api_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);
$data = json_decode($response, true);

$dataList = $data['data'];

// Tính tổng số dòng dữ liệu
$sokq = $data['trans_page'];
$sotrang = ceil($sokq / $sodong);
if (!empty($_GET['p'])) {
    $p = $_GET['p'];
} else {
    $p = 1;
}

$min = $sodong * ($p - 1);
$result = $data['data'];

foreach ($result as $row) {
?>
    <tr class="dong">
    <td><?php echo $row['idSize']; ?></td>
        <td><?php echo $row['size']; ?></td>
        <td>
            <a id="sua"  href="index.php?page=size-edit&id=<?php echo $row['idSize']; ?>" class="btn btn-primary btn-xs" >Edit</a>
            <a  id="xoa" href="#" class="btn btn-danger btn-xs" data-href="../Model/size-delete-xl.php?id=<?php echo $row['idSize']; ?>" data-toggle="modal" data-target="#confirm-delete" >Delete</a>
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