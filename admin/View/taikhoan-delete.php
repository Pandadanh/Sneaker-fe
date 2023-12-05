<?php
if (!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not

	$id_pro = $_REQUEST['id'];

	$apiUrl = 'http://localhost:8080/api-admin/controller-user-admin/xoa-tk?id=' . $id_pro;

	$curl = curl_init($apiUrl);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($curl);
	curl_close($curl);
	header('location: ../Control/index.php?page=taikhoan');
}
