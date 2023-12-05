<?php
session_start();
include("../Control/inc/config.php");
include("../Control/inc/functions.php");
$error_message = '';

// echo "<script type='text/javascript'>alert('Xin đăng nhập lại bằng tài khoản Admin');</script>";
if (isset($_POST['form1'])) {

	if (empty($_POST['email']) || empty($_POST['password'])) {
		$error_message = 'Email and/or Password can not be empty<br>';
	} else {

		$email = strip_tags($_POST['email']);
		$password = strip_tags($_POST['password']);

		$data = array(
			'email' => $email,
			'matkhau' => $password
		);

		$json_data = json_encode($data);
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

		if ($http_code == 200) {
			$data = json_decode($response, true);
			if ($data["status"] == "ok") {

				$row_password = $data['data']['matKhau'];
				$id_loaitk = $data['data']['nhomQuyen']["nhomquyen"];
				$trangthai = $data['data']['trangThai'];

				if ($row_password != ($password)) {
					$error_message .= 'Password does not match<br>';
				} else {
					if ($id_loaitk == "Admin" || $id_loaitk == "Nhân viên" || $id_loaitk == "Quản lý") {
						$_SESSION['user'] = $data['data'];
						header("location: ../Control/index.php?page=profile-edit");
					} else {
						echo "<script type='text/javascript'>alert('Tài khoản của bạn không có quyền truy cập');</script>";
						echo "<meta http-equiv='refresh' content='0;url=../View/login.php'>";
					}
				}
				exit;
			}
		} else {
			// echo "<script type='text/javascript'>alert('Login failed. Please try again');</script>";
		}
	}
	if ($http_code == 404) {
		$error_message .= 'Login failed. Please try again<br>';;
		// header("Location: ../Control/index.php?page=login");
	} else {
		$error_message .= 'Email Address does not match<br>';;
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" href="../Control/css/bootstrap.min.css">
	<link rel="stylesheet" href="../Control/css/font-awesome.min.css">
	<link rel="stylesheet" href="../Control/css/ionicons.min.css">
	<link rel="stylesheet" href="../Control/css/datepicker3.css">
	<link rel="stylesheet" href="../Control/css/all.css">
	<link rel="stylesheet" href="../Control/css/select2.min.css">
	<link rel="stylesheet" href="../Control/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../Control/css/AdminLTE.min.css">
	<link rel="stylesheet" href="../Control/css/_all-skins.min.css">

	<link rel="stylesheet" href="style.css">
	<script>
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>
</head>

<body class="hold-transition login-page sidebar-mini">

	<div class="login-box">
		<div class="login-logo">
			<b>Admin Panel</b>
		</div>
		<div class="login-box-body">
			<p class="login-box-msg">Log in to start your session</p>

			<?php
			if ((isset($error_message)) && ($error_message != '')) :
				echo '<div class="error">' . $error_message . '</div>';
			endif;
			?>

			<form action="" method="post">
				<div class="form-group has-feedback">
					<input class="form-control" placeholder="Email address" name="email" type="email" autocomplete="off" autofocus>
				</div>
				<div class="form-group has-feedback">
					<input class="form-control" placeholder="Password" name="password" type="password" autocomplete="off" value="">
				</div>
				<div class="row">
					<div class="col-xs-8"></div>
					<div class="col-xs-4">
						<input type="submit" class="btn btn-success btn-block btn-flat login-button" name="form1" value="Log In">
					</div>
				</div>
			</form>
		</div>
	</div>


</body>

</html>