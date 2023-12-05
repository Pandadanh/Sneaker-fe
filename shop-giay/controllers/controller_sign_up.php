<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten_user = $_POST["ten_user"];
    $matKhau = $_POST["matKhau"];
    $email = $_POST["email"];
    $sodth = $_POST["sodth"];
    $diaChi = $_POST["diaChi"];
   

    // Dữ liệu cần gửi dưới dạng JSON
    $data = array(
        'tenUser' => $ten_user,
        'matKhau' => $matKhau,
        'email' => $email,
        'soDienThoai' => $sodth,
        'diaChi' => $diaChi
    );

    
    // Chuyển đổi dữ liệu thành JSON
    $json_data = json_encode($data);

    // Tạo yêu cầu POST đến API Spring Boot
    $api_url = 'http://localhost:8080/api/controller-user/sign-up'; // Địa chỉ API của Spring Boot

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    
    // Đặt tiêu đề để chỉ định rằng dữ liệu được gửi dưới dạng JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_data)
    ));

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    // Kiểm tra và xử lý phản hồi từ API
    if ($http_code == 200) {
        $data = json_decode($response, true);
        if ($data["status"] == "ok") {
                    
            $_SESSION["user1"] = $data; // Lưu dữ liệu vào biến phiên
            //  print_r( $data);
            // Chuyển hướng đến trang index.php
            header("Location: ../index.php?page=home");
            exit;
        } else {
            // Xử lý lỗi, hiển thị thông báo lỗi
            echo "Login failed. Please try again.";
        }
    } else {
        // Xử lý lỗi HTTP
        $data = json_decode($response, true);
        echo "<script type='text/javascript'>alert('Email đã tồn tại'); setTimeout(function() { window.location.href = '../index.php?page=sign-up'; }, 0);</script>";


    }
}

?>
