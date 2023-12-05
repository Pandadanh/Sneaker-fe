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

$apiUrl = 'http://localhost:8080/api-admin/controller-don-hang/chitiet-donhang/' . $id_lay;
$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);
$data = json_decode($response, true);
$result = $data['data'];
$stt= 1 ;


// print_r($data);
if (isset($result) && is_array($result)) {
    foreach ($result as $row) {
        ?>
            <tr>
                <td><?php echo $stt++; ?></td>
                <td><?php echo $row['product']['tenPro'] ?></td>
                <td><?php echo $row['size']['size'] ?></td>
                <td><?php echo $row['soLuong'] ?></td>
                <td><?php echo money($row['giaban']) ?></td>
            </tr>
        <?php
        }
} else {
    // Xử lý trường hợp biến $result là null hoặc không phải là một mảng
}


?>