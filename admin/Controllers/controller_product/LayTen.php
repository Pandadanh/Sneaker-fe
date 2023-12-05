<?php 


$id_pro = $_REQUEST['id_pro'];


$apiUrl = 'http://localhost:8080/api-admin/controller-product/show-product?idPro=' . $id_pro;

$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

if ($data === null) {
    // Xử lý lỗi nếu có lỗi khi chuyển đổi JSON
    die('Lỗi khi chuyển đổi JSON thành mảng.');
}

$result = $data["data"];
echo $id_pro;
echo "???";
echo $result['tenPro'];
?>
