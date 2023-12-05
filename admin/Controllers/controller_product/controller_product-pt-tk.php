<?php


include("../../Control/inc/config.php");


$sodong = $_GET['sodong'];
$search = $_GET['search'];
$id_nh = $_GET['id_nh'];
$id_dm = $_GET['id_dm'];
$p = isset($_GET['p']) ? $_GET['p'] : 1; // Trang hiện tại, mặc định là 1

$params = array(
    'page' => $p,
    'size' => $sodong,
    'search' => $search,
    'id_nh' => $id_nh,
    'id_dm' => $id_dm
);

$query_string = http_build_query($params);

$url = "http://localhost:8080/api-admin/controller-product/search?" . $query_string;

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
        <td class="text-center"><?php echo $row['idPro']; ?></td>
        <td style="text-align: center;"><img src="../../uploads/<?php echo $row['hinhAnh'] ?>" alt="" style="width:80px;"></td>
        <!-- <td style="text-align: center;"><img src="../assets/uploads/product-featured-86.jpg" style="width:80px;" alt=""></td> -->
        <td><?php echo $row['tenPro']; ?></td>
        <td><?php echo $row['danhmuc']['danhMuc']; ?></td>
        <td><?php echo $row['nhanhieu']['nhanhieu']; ?></td>
        <td class="text-center"><?php echo money($row['giaCu']); ?></td>
        <td class="text-center"><?php echo money($row['giaMoi']); ?></td>
        <td class="text-center"><?php echo $row['totalView']; ?></td>
        <td class="text-center"> <a href="#" class="btn btn-info btn-xs" onclick="soluongne(<?php echo $row['idPro'] ?>)" data-toggle="modal" data-target="#soluong">
                <?php
               
               $apiUrl = 'http://localhost:8080/api-admin/controller-product/sum-soluong/' . $row['idPro'];
               $curl = curl_init($apiUrl);
               curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
               $response = curl_exec($curl);
               curl_close($curl);
               $responseArray = json_decode($response, true);
                   $total = $responseArray['data'];
                   if ($total > 0) {
                       echo $total;
                   } else {
                       echo 0;
                   }
              
                ?></a></td>

        <td>
            <a id="sua" href="index.php?page=product-edit&id=<?php echo $row['idPro']; ?>" class="btn btn-primary btn-xs">Edit</a>
            <a id="xoa" href="#" class="btn btn-danger btn-xs" data-href="index.php?page=product-delete&id=<?php echo $row['idPro']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
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

<?php
