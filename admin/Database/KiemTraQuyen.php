<?php 

$quyen = array();


$apiUrl = 'http://localhost:8080/api-admin/controller-user-admin/checkquyen/' . $_SESSION['user']['idUser'];
$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);
$data = json_decode($response, true);

// Kiểm tra xem trường "data" có tồn tại và là một mảng không
if (isset($data['data']) && is_array($data['data'])) {
    // Lặp qua các giá trị trong mảng "data" và thêm chúng vào mảng $quyen
    foreach ($data['data'] as $row) {
        array_push($quyen, $row);
    }
} else {
    // Xử lý trường hợp trường "data" không tồn tại hoặc không phải là mảng
    echo "Dữ liệu không hợp lệ hoặc trống.";
	exit;
}


function ktne($q, $quyen)
{
	if (in_array($q, $quyen)) {
		echo "style='display:block'";
	} else {
		echo "style='display:none'";
	}
}

function ktne11($q, $quyen)
{
	if (in_array($q, $quyen)) {
		return true;
	} else {
		return false;
	}
}

?>