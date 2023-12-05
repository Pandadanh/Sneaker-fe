<?php
// print_r($_SESSION);
if (isset($_POST['form1'])) {

	// if ($_SESSION['user']['role'] == 'Super Admin') {

	$valid = 1;

	if (empty($_POST['full_name'])) {
		$valid = 0;
		$error_message .= "Name can not be empty<br>";
	}
	if (empty($_POST['sodth'])) {
		$valid = 0;
		$error_message .= "Phone Number can not be empty<br>";
	}

	if (empty($_POST['email'])) {
		$valid = 0;
		$error_message .= 'Email address can not be empty<br>';
	} else {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			$valid = 0;
			$error_message .= 'Email address must be valid<br>';
		} else {
			// current email address that is in the database
			$statement = $pdo->prepare("SELECT * FROM tbl_users WHERE id_user=?");
			$statement->execute(array($_SESSION['user']['id_user']));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach ($result as $row) {
				$current_email = $row['email'];
			}

			$statement = $pdo->prepare("SELECT * FROM tbl_users WHERE email=? and email!=?");
			$statement->execute(array($_POST['email'], $current_email));
			$total = $statement->rowCount();
			if ($total) {
				$valid = 0;
				$error_message .= 'Email address already exists<br>';
			}
		}
	}

	if ($valid == 1) {

		$_SESSION['user']['full_name'] = $_POST['full_name'];
		$_SESSION['user']['email'] = $_POST['email'];

		// updating the database
		$statement = $pdo->prepare("UPDATE tbl_users SET ten_user=?, email=?, sodth=? WHERE id_user=?");
		$statement->execute(array($_POST['full_name'], $_POST['email'], $_POST['sodth'], $_SESSION['user']['id_user']));

		$success_message = 'User Information is updated successfully.';
	}
	// } else {
	// 	$_SESSION['user']['sodth'] = $_POST['sodth'];

	// 	// updating the database
	// 	$statement = $pdo->prepare("UPDATE tbl_users SET sodth=? WHERE id_user=?");
	// 	$statement->execute(array($_POST['sodth'], $_SESSION['user']['id_user']));

	// 	$success_message = 'User Information is updated successfully.';
	// }
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
			$error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
		}
	}

	if ($valid == 1) {

		// removing the existing avatar
		if ($_SESSION['user']['avatar'] != '') {
			unlink('../../uploads/' . $_SESSION['user']['avatar']);
		}

		// updating the data
		$final_name = 'user-' . $_SESSION['user']['id_user'] . '.' . $ext;
		move_uploaded_file($path_tmp, '../../uploads/' . $final_name);
		$_SESSION['user']['avatar'] = $final_name;

		// updating the database
		$statement = $pdo->prepare("UPDATE tbl_users SET avatar=? WHERE id_user=?");
		$statement->execute(array($final_name, $_SESSION['user']['id_user']));

		$success_message = 'User avatar is updated successfully.';
	}
}

if (isset($_POST['form3'])) {
	$valid = 1;

	if (empty($_POST['password']) || empty($_POST['re_password'])) {
		$valid = 0;
		$error_message .= "Password can not be empty<br>";
	}

	if (!empty($_POST['password']) && !empty($_POST['re_password'])) {
		if ($_POST['password'] != $_POST['re_password']) {
			$valid = 0;
			$error_message .= "Passwords do not match<br>";
		}
	}

	if ($valid == 1) {

		$_SESSION['user']['matkhau'] = $_POST['password'];

		// updating the database
		$statement = $pdo->prepare("UPDATE tbl_users SET matkhau=? WHERE id_user=?");
		$statement->execute(array($_POST['password'], $_SESSION['user']['id_user']));

		$success_message = 'User Password is updated successfully.';
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Profile</h1>
	</div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_users WHERE id_user=?");
$statement->execute(array($_SESSION['user']['idUser']));
$statement->rowCount();
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$full_name = $row['ten_user'];
	$email     = $row['email'];
	$sodth     = $row['sodth'];
	$avatar     = $row['avatar'];
	$role      = $row['nhomquyen'];
}
?>


<section class="content">

	<div class="row">
		<div class="col-md-12">
		<?php if($error_message): ?>
			<div class="callout callout-danger">
			
			<p>
			<?php echo $error_message; ?>
			</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
			
			<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_1" data-toggle="tab">Update Information</a></li>
					<li><a href="#tab_2" data-toggle="tab">Update avatar</a></li>
					<li><a href="#tab_3" data-toggle="tab">Update Password</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1">
						<form class="form-horizontal" action="" method="post">
							<div class="box box-info">
								<div class="box-body">
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Name <span>*</span></label>
										<div class="col-sm-4" style="padding-top:7px;">
											<!-- <?php echo $full_name; ?> -->
											<input type="text" name="full_name" id="" value="<?php echo $full_name; ?>">
										</div>

									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Existing avatar</label>
										<div class="col-sm-6" style="padding-top:6px;">
											<img src="../../uploads/<?php echo $avatar; ?>" class="existing-avatar" width="140">
										</div>
									</div>

									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Email Address <span>*</span></label>

										<div class="col-sm-4">
											<input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">sodth </label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="sodth" value="<?php echo $sodth; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-2 control-label">Quyền<span>*</span></label>
										<div class="col-sm-4" style="padding-top:7px;">
											<select name="quyen" id="" style="height:30px; padding:5px;" disabled>
												<option value=""><?php echo $role; ?></option>
											</select>
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
					<div class="tab-pane" id="tab_2">
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
					<div class="tab-pane" id="tab_3">
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
				</div>
			</div>

		</div>
	</div>
</section>