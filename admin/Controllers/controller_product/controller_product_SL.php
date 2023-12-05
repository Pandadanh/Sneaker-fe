<?php

$id_pro = $_REQUEST['id_pro'];


$apiUrl = 'http://localhost:8080/api-admin/controller-product/show-chitiet-soluong?idPro=' . $id_pro;

$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

if ($data['data'] === null) {
    exit;
}

// print_r($response);
// try{

// }
// catch(Exception ea){

// }
$result = $data['data'];
foreach ($result as $row) {
?>
    <tr>
        <td><?php echo $row["size"]["size"] ?></td>
        <td><?php echo $row["soLuong"] ?></td>
    </tr>
<?php
}

?>
