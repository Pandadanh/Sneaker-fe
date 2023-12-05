<?php

if (!function_exists('money')) {
    function money($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', ',') . "{$suffix}";
        }
    }
}
if (isset($_REQUEST['id_lay'])) {
    $id_lay = $_REQUEST['id_lay'];
} else {
    $id_lay = 0;
}
$stt = 1;



$apiUrl = 'http://localhost:8080/api/controller-page/show-chitet-px/' . $id_lay;
$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);
$data = json_decode($response, true);


$result = $data['data'];
// print_r($result);
// exit;
foreach ($result as $row) {

   
    $apiUrl = 'http://localhost:8080/api/controller-page/search-idpro-idsize/' . $row['product']['idPro'] . '/' . $row['size']['idSize'];
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);

    // print_r($data);
?>
    <tr>

        <td><?php echo $stt++; ?></td>
        <td><?php echo $data['data']['product']['tenPro'] ?></td>
        <td><?php echo $data['data']['size']['size'] ?></td>
        <td><?php echo $row['soLuong'] ?></td>
        <td><?php echo money($row['giaban']) ?></td>
    </tr>
<?php
}
?>