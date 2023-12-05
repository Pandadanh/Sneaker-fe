<?php
if (isset($_POST['form1'])) {

	$valid = 1;

	if (empty($_POST['ten_user'])) {
		$valid = 0;
		echo "<script type='text/javascript'>alert('Name can not be empty');</script>";
	}

	if (empty($_POST['diachi'])) {
		$valid = 0;
		echo "<script type='text/javascript'>alert('Địa Chỉ address can not be empty');</script>";
	}

	if (empty($_POST['email'])) {
		$valid = 0;
		echo "<script type='text/javascript'>alert('Email address can not be empty');</script>";
	} else {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			$valid = 0;
			echo "<script type='text/javascript'>alert('Email address must be valid');</script>";
		} else {

			$apiUrl = 'http://localhost:8080/api/controller-page/check-UserEmail/';

			// print_r($_SESSION);
			$data = array(
				'id_user' => $_SESSION['user1']['data']['idUser'],
				'email' => $_POST['email']
			);

			$options = array(
				'http' => array(
					'header' => "Content-type: application/x-www-form-urlencoded\r\n",
					'method' => 'POST',
					'content' => http_build_query($data)
				)
			);

			$context = stream_context_create($options);
			$response = file_get_contents($apiUrl, false, $context);

			if ($response === false) {
				// Xử lý lỗi khi không thể kết nối đến API
				echo "<script type='text/javascript'>alert('ERROR');</script>";
			} else {
				 // Xử lý phản hồi từ API
				 $responseData = json_decode($response, true);

				 // Kiểm tra phản hồi có chứa dữ liệu không
				 if (isset($responseData['data'])) {
					 // Trích xuất dữ liệu từ phản hồi
					 $data = $responseData['data'];
			 
					 if($data['mes'] == "Invalid userId or email"){
						$valid = 0;
						echo "<script type='text/javascript'>alert('Invalid userId or email');</script>";
					 }
					 if( $data['mes'] == "exist email"){
						$valid = 0;
						echo "<script type='text/javascript'>alert('Email address already exists');</script>";
					 }
					
				 } else {
					echo "<script type='text/javascript'>alert('ERROR - data');</script>";
				 }
			}

		}
	}

	if ($valid == 1) {

		$_SESSION['user1']['ten_user'] = $_POST['ten_user'];
		$_SESSION['user1']['email'] = $_POST['email'];
		$_SESSION['user1']['diachi'] = $_POST['diachi'];
		$_SESSION['user1']['sodth'] = $_POST['sodth'];

		// updating the database


		$apiUrl = 'http://localhost:8080/api/controller-page/update-user/';

		$data = array(
			'id_user' => $_SESSION['user1']['data']['idUser'],
			'ten_user' => $_POST['ten_user'],
			'email' => $_POST['email'],
			'diachi' => $_POST['diachi'],
			'sodth' => $_POST['sodth']
		);

		$options = array(
			'http' => array(
				'header' => "Content-type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($data)
			)
		);

		$context = stream_context_create($options);
		$response = file_get_contents($apiUrl, false, $context);

		if ($response === false) {
			// Xử lý lỗi khi không thể kết nối đến API
			echo "<script type='text/javascript'>alert('ERROR');</script>";
		} else {

			echo "<script type='text/javascript'>alert('User Information is updated successfully');</script>";
		}

	}

}

if (isset($_POST['form2'])) {

	$valid = 1;

	$path = $_FILES['avatar']['name'];
	$path_tmp = $_FILES['avatar']['tmp_name'];

	if ($path != '') {
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$file_name = basename($path, '.' . $ext);
		if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
			$valid = 0;
			echo "<script type='text/javascript'>alert('You must have to upload jpg, jpeg, gif or png file');</script>";
		}
	}

	if ($valid == 1) {

		// removing the existing avatar
		if ($_SESSION['user1']['avatar'] != '') {
			unlink('../uploads/' . $_SESSION['user1']['avatar']);
		}

		// updating the data
		$final_name = 'user-' . $_SESSION['user1']['id_user'] . '.' . $ext;
		move_uploaded_file($path_tmp, '../uploads/' . $final_name);
		$_SESSION['user1']['avatar'] = $final_name;



		$apiUrl = 'http://localhost:8080/api/controller-page/update-avatar-user/';
		$data = array(
			'id_user' => $_SESSION['user1']['id_user'],
			'avatar' => $final_name
			
		);
		$options = array(
			'http' => array(
				'header' => "Content-type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context = stream_context_create($options);
		$response = file_get_contents($apiUrl, false, $context);
		if ($response === false) {
			// Xử lý lỗi khi không thể kết nối đến API
			echo "<script type='text/javascript'>alert('ERROR');</script>";
		} else {

			echo "<script type='text/javascript'>alert('User avatar is updated successfully');</script>";
		}
	
	}
}

if (isset($_POST['form3'])) {
	$valid = 1;

	if (empty($_POST['password']) || empty($_POST['re_password'])) {
		$valid = 0;
		echo "<script type='text/javascript'>alert('Password can not be empty');</script>";
	}

	if (!empty($_POST['password']) && !empty($_POST['re_password'])) {
		if ($_POST['password'] != $_POST['re_password']) {
			$valid = 0;
			echo "<script type='text/javascript'>alert('Passwords do not match');</script>";
		}
	}

	if ($valid == 1) {

		$_SESSION['user1']['matkhau'] = $_POST['password'];



		$apiUrl = 'http://localhost:8080/api/controller-page/update-password-user/';
		$data = array(
			'id_user' => $_SESSION['user1']['id_user'],
			'password' => $_POST['password']
			
		);
		$options = array(
			'http' => array(
				'header' => "Content-type: application/x-www-form-urlencoded\r\n",
				'method' => 'POST',
				'content' => http_build_query($data)
			)
		);
		$context = stream_context_create($options);
		$response = file_get_contents($apiUrl, false, $context);
		if ($response === false) {
			// Xử lý lỗi khi không thể kết nối đến API
			echo "<script type='text/javascript'>alert('ERROR');</script>";
		} else {

			echo "<script type='text/javascript'>alert('User Password is updated successfully');</script>";
		}

	}
}

?>

<section class="content-header container mt-2">
	<div class="content-header">
		<h1>Edit Profile</h1>
	</div>
</section>

<?php
// print_r($_SESSION);
$ten_user = $_SESSION['user1']['data']['tenUser'];
$email     = $_SESSION['user1']['data']['email'];
$sodth     = $_SESSION['user1']['data']['soDienThoai'];
$avatar     = $_SESSION['user1']['data']['avatar'];
$diachi = $_SESSION['user1']['data']['diaChi'];
?>
<style>
	.tabne {
		margin-right: 20px;
		margin-bottom: 10px;
	}
</style>

<section class="content container">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs mt-2 mb-2">
					<li class="tabne"><a href="#tab_1" class="title-nav-tab nav-item nav-link active" data-toggle="tab" style="font-size: medium;">Update Information</a></li>
					<li class="tabne"><a href="#tab_2" class="title-nav-tab nav-item nav-link" data-toggle="tab" style="font-size: medium;">Update avatar</a></li>
					<li class="tabne"><a href="#tab_3" class="title-nav-tab nav-item nav-link" data-toggle="tab" style="font-size: medium;">Update Password</a></li>
					<li class="tabne"><a href="#tab_4" class="title-nav-tab nav-item nav-link" data-toggle="tab" style="font-size: medium;">History</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade show active" id="tab_1">
						<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<div class="form-group">
											<label for="" class="col-sm-2 control-label">Ảnh đại diện</label>
											<div class="col-sm-6" style="padding-top:6px;">
												<img src="../uploads/<?php echo $avatar ?>" class="existing-avatar" style="width:200px;height:200px">
											</div>
										</div>
										<label for="" class="col-sm-2 control-label">Họ Tên<span>*</span></label>

										<div class="col-sm-4" style="padding-top:7px;">
											<input type="text" class="form-control" name="ten_user" id="" value="<?php echo $ten_user ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Email<span>*</span></label>

										<div class="col-sm-4">
											<input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Số điện thoại</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="sodth" value="<?php echo $sodth; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Địa Chỉ</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="diachi" value="<?php echo $diachi; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form1">Update Information</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane fade show" id="tab_2">
						<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">New avatar</label>
										<div class="col-sm-6" style="padding-top:6px;">
											<input type="file" name="avatar">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form2">Update avatar</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="tab-pane fade show" id="tab_3">
						<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Password </label>
										<div class="col-sm-4">
											<input type="password" class="form-control" name="password">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Retype Password </label>
										<div class="col-sm-4">
											<input type="password" class="form-control" name="re_password">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label"></label>
										<div class="col-sm-6">
											<button type="submit" class="btn btn-success pull-left" name="form3">Update Password</button>
										</div>
									</div>
								</div>
							</div>
						</form>

					</div>
					<div class="tab-pane fade show" id="tab_4">
						<table class="table align-middle mb-0 bg-white text-center  table-bordered table-hover table-striped" id="example1">
							<thead class="bg-light">
								<tr>
									<th class="col-md-1">ID Đơn Hàng</th>
									<th class="col-md-2">Ngày đặt</th>
									<th class="col-md-2">Số lượng</th>
									<th class="col-md-2">Tổng tiền</th>
									<th class="col-md-2">Tình trạng</th>
									<th class="col-md-1">Hành Động</th>
								</tr>
							</thead>
							<tbody id="dulieu">
								<?php
								// print_r($_SESSION);

								$apiUrl = 'http://localhost:8080/api/controller-page/show-user/' . $_SESSION["user1"]['data']["idUser"];
								$curl = curl_init($apiUrl);
								curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
								$response = curl_exec($curl);
								curl_close($curl);

								$data_user = json_decode($response, true);

								$result = $data_user['list_data']['list_phieuXuat'];


								foreach ($result as $row) {
								?>
									<tr>
										<td><?php echo $row['idPx'] ?></td>
										<td><?php echo $row['ngayDat'] ?></td>
										<td><?php echo $row['tongSoLuong'] ?></td>
										<td><?php echo money($row['tongTien']) ?></td>
										<td><?php
											if ($row['trangThai'] == 0) {
												echo  "Chờ xác nhận";
											?>
											
											<?php
											}
											if ($row['trangThai'] == 1) {
												echo  "Đã xác nhận";
											}
											if ($row['trangThai'] == 2) {
												echo  "Đã Hủy";
											}
											?>
										</td>
										<td>
											<a href="#" class="btn btn-warning" data-href="" data-toggle="modal" onclick="chitietne(<?php echo $row['idPx'] ?>)" data-target="#chitiet">Chi Tiết</a>
										</td>
									</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<div class="modal fade" id="chitiet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Chi Tiết Đơn Hàng</h4>
			</div>
			<div class="modal-body">
				<table class="table align-middle mb-0 bg-white text-center  table-bordered table-hover table-striped" id="example1">
					<thead class="bg-light">
						<tr>
							<th class="col-md-1">STT</th>
							<th class="col-md-4">Tên sản phẩm</th>
							<th class="col-md-1">Size</th>
							<th class="col-md-1">Số lượng</th>
							<th class="col-md-2">Giá bán</th>
						</tr>
					</thead>
					<tbody id="dulieune">

					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
<script>
	function chitietne(id_lay) {
		var search = document.getElementById("search").value;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("dulieune").innerHTML = this.responseText;

			}
		}
		xmlhttp.open("GET", "./controllers/controller_chitietdh.php?id_lay=" + id_lay, true);
		xmlhttp.send();


	}
</script>