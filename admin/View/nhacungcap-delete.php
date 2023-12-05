

<?php
include("../Control/inc/config.php");
	// Preventing the direct access of this page.
if(!isset($_REQUEST['id'])) {
	header('location: ../View/logout.php');
	exit;
} else {
	
	$data = array(
		'id' => $_REQUEST['id']
	);

	$apiUrl = 'http://localhost:8080/api-admin/controller-nhacungcap/delete';
	$ch = curl_init($apiUrl);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$response = curl_exec($ch);
	curl_close($ch);

	header('location: ../Control/index.php?page=nhacungcap&tc');
}
?>