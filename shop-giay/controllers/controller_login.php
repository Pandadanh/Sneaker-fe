<?php
session_start();
ob_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Dữ liệu cần gửi dưới dạng JSON
    $data = array(
        'email' => $email,
        'matkhau' => $password
    );
    
    
    // Chuyển đổi dữ liệu thành JSON
    $json_data = json_encode($data);

    // Tạo yêu cầu POST đến API Spring Boot
    $api_url = 'http://localhost:8080/api/controller-user/login'; // Địa chỉ API của Spring Boot

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
    $_SESSION["ERROR"] = 2;

    // Kiểm tra và xử lý phản hồi từ API
    if ($http_code == 200) {
        $data = json_decode($response, true);
        if ($data["status"] == "ok") {
                    
          
            $_SESSION["error"] = "";
            $_SESSION["ERROR"] = "";

            $_SESSION["success"] = "Đăng nhập thành công";


            if ($data['data']["nhomQuyen"]["nhomquyen"] == "Admin" || $data['data']["nhomQuyen"]["nhomquyen"] == "Nhân viên" || $data['data']["nhomQuyen"]["nhomquyen"] == "Quản lý") {
              
                header("Location: /DOANWED/admin/View/login.php");
                 exit;
             }
           else{
          
          
            $_SESSION["user1"] = $data; 
            header("Location: ../index.php?page=home");
            exit;
           }
        } else {
            // Xử lý lỗi, hiển thị thông báo lỗi
            echo "Login failed. Please try again.";
        }
    }
    if ($http_code == 404) {
        $_SESSION["error"] = "Tài khoản không tồn tại";
      
        header("Location: ../index.php?page=login");
    } else {
        $_SESSION["error"] = "ERROR"; 
        header("Location: ../index.php?page=login");
    }
}

?>
