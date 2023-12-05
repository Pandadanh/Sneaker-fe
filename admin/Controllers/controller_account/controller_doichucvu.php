<?php 

$data = array(
    'id_user' => $_REQUEST["id_tk"], // Thay thế bằng giá trị thực tế
    'nhomquyen' => $_REQUEST["nhomquyen"] // Thay thế bằng giá trị thực tế
);

// print_r($data);
$apiUrl = 'http://localhost:8080/api-admin/controller-user-admin/update-nhomquyen';

$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); // Đặt Content-Type thành application/json
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);




// $responseData = json_decode($response, true);

// if ($responseData === null) {
//     die('Invalid JSON data');
// }



header("location: ../Control/index.php?page=taikhoan"); 

?> 