<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
   
    // Dữ liệu cần gửi dưới dạng JSON
    $data = array(
        'email' => $email,
       
    );
    
    header("Location: ../index.php?page=active_account");
    exit;
    // Chuyển đổi dữ liệu thành JSON
    $json_data = json_encode($data);

    // Tạo yêu cầu POST đến API Spring Boot
    $api_url = 'http://localhost:8080/api/Forgot-password/forgot'; // Địa chỉ API của Spring Boot

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
   

    if ($http_code == 200) {
        $data = json_decode($response, true);
       
        header("Location: ../index.php?page=active_account.php");
            exit;
       
            
    } 
    if ($http_code == 404) {
        echo "<script type='text/javascript'>alert('Not Found');</script>";
       
    }
    else {
        // Xử lý lỗi HTTP
        echo "<script type='text/javascript'>alert('ERROR');</script>";
    }
}

?>
