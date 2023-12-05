<?php
$error_message = '';
$success_message = '';

if (isset($_POST['form1'])) {
	$valid = 1;

	if (empty($_POST['id_dm'])) {
		$valid = 0;
		$error_message .= "Tên danh mục không được trống<br>";
	}

	if (empty($_POST['id_nh'])) {
		$valid = 0;
		$error_message .= "Tên nhãn hiệu không được trống<br>";
	}

	if (empty($_POST['ten_pro'])) {
		$valid = 0;
		$error_message .= "Tên sản phẩm không được trống<br>";
	}

	if (empty($_POST['giamoi'])) {
		$valid = 0;
		$error_message .= "Giá mới không được trống<br>";
	}

	$path = $_FILES['hinhanh']['name'];
	$path_tmp = $_FILES['hinhanh']['tmp_name'];

	if ($path != '') {
		$ext = pathinfo($path, PATHINFO_EXTENSION);
		$file_name = basename($path, '.' . $ext);
		if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
			$valid = 0;
			$error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
		}
	}
	if ($valid == 1) {
		
		if ($path == '') {
			
			$statement = $pdo->prepare("UPDATE tbl_product SET 
        							ten_pro=?, 
									id_nh=?, 
									id_dm=?, 
        							giacu=?, 
        							giamoi=?,
        							mota=?
        							WHERE id_pro=?");
			$statement->execute(array(
				$_POST['ten_pro'],
				$_POST['id_nh'],
				$_POST['id_dm'],
				$_POST['giacu'],
				$_POST['giamoi'],
				$_POST['mota'],
				$_REQUEST['id']
			));
		} else {

			unlink('../../uploads/' . $_POST['current_photo']);

			$final_name = 'product-featured-' . $_REQUEST['id'] . '.' . $ext;
			move_uploaded_file($path_tmp, '../../uploads/' . $final_name);


			$statement = $pdo->prepare("UPDATE tbl_product SET 
        							ten_pro=?, 
									id_nh=?, 
									id_dm=?, 
        							giacu=?, 
        							giamoi=?, 
        							hinhanh=?,
        							mota=?     							
        							WHERE id_pro=?");
			$statement->execute(array(
				$_POST['ten_pro'],
				$_POST['id_nh'],
				$_POST['id_dm'],
				$_POST['giacu'],
				$_POST['giamoi'],
				$final_name,
				$_POST['mota'],
				$_REQUEST['id']
			));
		}
		$success_message = 'Product is updated successfully.';
	}
}
?>

<?php
if (!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE id_pro=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if ($total == 0) {
		header('location: ../View/logout.php');
		exit;
	}
}
?>
<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Product</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=product" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_product WHERE id_pro=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$ten_pro = $row['ten_pro'];
	$id_dm = $row['id_dm'];
	$id_nh = $row['id_nh'];
	$giacu = $row['giacu'];
	$giamoi = $row['giamoi'];
	$mota = $row['mota'];
	$hinhanh = $row['hinhanh'];
}
?>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php if ($error_message) : ?>
				<div class="callout callout-danger">
					<p>
						<?php echo $error_message; ?>
					</p>
				</div>
			<?php endif; ?>
			<?php if ($success_message) : ?>
				<div class="callout callout-success">

					<p><?php echo $success_message; ?></p>
				</div>
			<?php endif; ?>
			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Danh mục<span>*</span></label>
							<div class="col-sm-4">
								<select name="id_dm" class="form-control select2 top-cat">
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_danhmuc WHERE id_dm= $id_dm");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id_dm']; ?>"><?php echo $row['danhmuc']; ?></option>
									<?php
									}
									?>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_danhmuc WHERE id_dm <> $id_dm");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id_dm']; ?>"><?php echo $row['danhmuc']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Nhãn hiệu<span>*</span></label>
							<div class="col-sm-4">
								<select name="id_nh" class="form-control select2 mid-cat">
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_nhanhieu WHERE id_nh= $id_nh");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id_nh']; ?>"><?php echo $row['nhanhieu']; ?></option>
									<?php
									}
									?>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_nhanhieu WHERE id_nh <> $id_nh");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result as $row) {
									?>
										<option value="<?php echo $row['id_nh']; ?>"><?php echo $row['nhanhieu']; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Tên sản phẩm<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" name="ten_pro" class="form-control" value="<?php echo $ten_pro; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Giá cũ<br><span style="font-size:10px;font-weight:normal;">(VNĐ)</span></label>
							<div class="col-sm-4">
								<input type="text" name="giacu" class="form-control" value="<?php echo $giacu; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Giá hiện tại<span>*</span><br><span style="font-size:10px;font-weight:normal;">(VNĐ)</span></label>
							<div class="col-sm-4">
								<input type="text" name="giamoi" class="form-control" value="<?php echo $giamoi; ?>">
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Ảnh hiển thị<span></span></label>
							<div class="col-sm-4" style="padding-top:4px;">
								<img src="../../uploads/<?php echo $hinhanh ?>" alt="" width="80px">

								<input type="text" name="current_photo" value="<?php echo $hinhanh ?>" hidden>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Chọn ảnh khác<span>*</span></label>
							<div class="col-sm-4" style="padding-top:4px;">
								<input type="file" name="hinhanh" accept=".jpg, .png">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Mô tả</label>
							<div class="col-sm-8">
								<textarea name="mota" class="form-control" cols="30" rows="10" id="editor1"><?php echo $mota ?></textarea>
							</div>
						</div>

						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Hàng Mới</label>
							<div class="col-sm-8">
								<select name="pro_new" class="form-control" style="width:auto;">
									<option value="0">No</option>
									<option value="1">Yes</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Cập nhật</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>