<?php

// URL của API bạn muốn gọi
$apiUrl = "http://localhost:8080/api/controller-user/active-token";

// Dữ liệu bạn muốn gửi đến API (activeToken trong trường hợp này)
$data = array('activeToken' => $_GET['active_token']);

// Khởi tạo cURL
$ch = curl_init($apiUrl);

// Cấu hình cURL để gửi dữ liệu POST
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

// Thiết lập các tùy chọn khác nếu cần
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Thực hiện yêu cầu cURL và lưu kết quả vào biến $response
$response = curl_exec($ch);

// Kiểm tra lỗi cURL
if (curl_errno($ch)) {
    echo 'Lỗi cURL: ' . curl_error($ch);
}
$result = json_decode($response, true);
// Đóng phiên cURL
curl_close($ch);
?>

<style>
    a:hover {
        color: tomato;
        text-decoration: none;
    }

    #active_account {
        margin: 0px auto;
        min-height: 500px;
    }

    h1 {
        display: inline-block;
        padding: 15px;
        border-radius: 10px;
    }

    p {
        font-size: larger;
    }

    #message-success {
        color: darkgreen;
        border: 2px solid green;
    }

    #message-error {
        color: crimson;
        border: 2px solid red;
    }
</style>
<div id="active_account" class="col-lg-12 text-center mt-5">
    <?php if ($result) { ?>
        <h1 id="message-success">Kích hoạt tài khoản thành công</h1>
        <p>Vui lòng click vào link sau để đăng nhập <a href="index.php?page=login">Đăng nhập</a></p>
    <?php } else { ?>
        <h1 id="message-error">Kích hoạt tài khoản thất bại</h1>
        <p>Quay lại trang <a href="index.php?page=sign-up">Đăng ký</a></p>
    <?php } ?>
</div>