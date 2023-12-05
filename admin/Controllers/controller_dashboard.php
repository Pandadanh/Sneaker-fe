<?php

$apiUrl = 'http://localhost:8080/api-admin/controller-dashboard/show' ;
$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);
$data = json_decode($response, true);

$total_product = $data['data']['count_product'];

$total_customers =  $data['data']['count_user'];

$total_order =  $data['data']['count_donhang'];

$total_money = $data['data']['tongtien'];

?>