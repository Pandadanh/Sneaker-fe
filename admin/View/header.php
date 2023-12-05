<?php
ob_start();
session_start();
include("inc/config.php");
include("inc/functions.php");
// $csrf = new CSRF_Protect();
$error_message = '';
$success_message = '';
$error_message1 = '';
$success_message1 = '';

// Check if the user is logged in or not
if (!isset($_SESSION['user'])) {
	header('location: ../View/login.php');
	exit;
}
?>
<?php
 include("../Database/KiemTraQuyen.php");

$result1 = null;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Trang Quản Trị</title>
	<link rel="icon" type="image/x-icon" href="../../uploads/<?php echo $result1['favicon'] ?>">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/ionicons.min.css">
	<link rel="stylesheet" href="css/datepicker3.css">
	<link rel="stylesheet" href="css/all.css">
	<link rel="stylesheet" href="css/select2.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">
	<link rel="stylesheet" href="css/AdminLTE.min.css">
	<link rel="stylesheet" href="css/_all-skins.min.css">
	<link rel="stylesheet" href="css/on-off-switch.css" />
	<link rel="stylesheet" href="css/summernote.css">
	<link rel="stylesheet" href="../View/style.css">

</head>
<style>
	.annha {
		display: none;
	}
</style>

<body class="hold-transition fixed skin-blue sidebar-mini">

	<div class="wrapper">

		<header class="main-header">

			<a href="index.php?page=dashboard" class="logo">
				<span class="logo-lg">Shoes Shop</span>
			</a>

			<nav class="navbar navbar-static-top">

				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>

				<span style="float:left;line-height:50px;color:#fff;padding-left:15px;font-size:18px;">Trang quản trị</span>
				<div class="navbar-custom-menu">
					<ul class="nav navbar-nav">
						<li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<img src="../../uploads/<?php echo $_SESSION['user']['avatar'];  ?>" class="user-image" alt="User Image" style="border-radius:100%">
								<span class="hidden-xs"><?php echo $_SESSION['user']['tenUser']; ?></span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-footer">
									<div>
										<a href="index.php?page=profile-edit" class="btn btn-default btn-flat">Edit Profile</a>
									</div>
									<div>
									
										<a href="/DOANWED/admin/View/logout.php" class="btn btn-default btn-flat">Log out</a>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>

			</nav>
		</header>

		<?php $cur_page = $_GET['page'] ?>
		<!-- Side Bar to Manage Shop Activities -->
		<aside class="main-sidebar">
			<section class="sidebar">

				<ul class="sidebar-menu">

					<li class="treeview <?php if ($cur_page == 'dashboard') {
											echo 'active';
										} ?>" <?php ktne("dabo-xem", $quyen) ?>>
						<a href="index.php?page=dashboard">
							<i class="fa fa-dashboard "></i> <span>Dashboard</span>
						</a>
					</li>


					<li class="treeview <?php if (($cur_page == 'settings')) {
											echo 'active';
										} ?>" <?php ktne("cdw-xem", $quyen) ?>>
						<a href="index.php?page=settings">
							<i class="fa fa-sliders"></i> <span>Cài đặt Website</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'size') || ($cur_page == 'size-add') || ($cur_page == 'size-edit') || ($cur_page == 'nhanhieu') || ($cur_page == 'nhanhieu-add') || ($cur_page == 'nhanhieu-edit') ||  ($cur_page == 'danhmuc') || ($cur_page == 'danhmuc-add') || ($cur_page == 'danhmuc-edit') || ($cur_page == 'nhacungcap') || ($cur_page == 'nhacungcap-add') || ($cur_page == 'nhacungcap-edit')) {
											echo 'active';
										} ?>" <?php ktne("cds-xem", $quyen) ?>>
						<a href="#">
							<i class="fa fa-cogs"></i>
							<span>Cài đặt Shop</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php if ($cur_page == 'size') echo 'active' ?>"><a href="index.php?page=size"><i class="fa fa-circle-o "></i> Size</a></li>
							<li class="<?php if ($cur_page == 'nhanhieu') echo 'active' ?>"><a href="index.php?page=nhanhieu"><i class="fa fa-circle-o"></i> Nhãn Hiệu</a></li>
							<li class="<?php if ($cur_page == 'danhmuc') echo 'active' ?>"><a href="index.php?page=danhmuc"><i class="fa fa-circle-o"></i> Danh Mục</a></li>
							<li class="<?php if ($cur_page == 'nhacungcap') echo 'active' ?>"><a href="index.php?page=nhacungcap"><i class="fa fa-circle-o"></i> Nhà Cung Cấp</a></li>


						</ul>
					</li>


					<li class="treeview <?php if (($cur_page == 'product') || ($cur_page == 'product-add') || ($cur_page == 'product-edit')) {
											echo 'active';
										} ?>" <?php ktne("sp-xem", $quyen) ?>>
						<a href="index.php?page=product">
							<i class="fa fa-shopping-bag"></i> <span>QL Sản phẩm</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'nhaphang')) {
											echo 'active';
										} ?>">
						<a href="index.php?page=nhaphang">
							<i class="fa fa-shopping-bag"></i> <span>Nhập Hàng</span>
						</a>
					</li>


					<li class="treeview <?php if (($cur_page == 'order')) {
											echo 'active';
										} ?>" <?php ktne("dh-xem", $quyen) ?>>
						<a href="index.php?page=order">
							<i class="fa fa-sticky-note"></i> <span>QL Đơn hàng</span>
						</a>
					</li>


					<li class="treeview <?php if (($cur_page == 'thongke')) {
											echo 'active';
										} ?>" <?php ktne("tke-xem", $quyen) ?>>
						<a href="index.php?page=thongke">
							<i class="fa fa-database"></i> <span>Thống kê</span>
						</a>
					</li>


					<li class="treeview <?php if (($cur_page == 'slider')) {
											echo 'active';
										} ?>" <?php ktne("slider-xem", $quyen) ?>>
						<a href="index.php?page=slider">
							<i class="fa fa-picture-o"></i> <span>QL Sliders</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'quyen') || ($cur_page == 'quyen-add') || ($cur_page == 'quyen-edit')) {
											echo 'active';
										} ?>" <?php if ($_SESSION['user']['nhomQuyen']['nhomquyen']!= "Admin") echo "style='display:none;'" ?>>
						<a href="index.php?page=quyen">
							<i class="fa fa-shield"></i> <span>QL Quyền</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'taikhoan') || ($cur_page == 'taikhoan-add') || ($cur_page == 'taikhoan-edit')) {
											echo 'active';
										} ?>" <?php ktne("tk-xem", $quyen) ?>>
						<a href="index.php?page=taikhoan">
							<i class="fa fa-user-plus"></i> <span>QL Tài khoản</span>
						</a>
					</li>

					<li class="treeview <?php if (($cur_page == 'social-media')) {
											echo 'active';
										} ?>" <?php ktne("mxh-xem", $quyen) ?>>
						<a href="index.php?page=social-media">
							<i class="fa fa-globe"></i> <span>Mạng xã hội</span>
						</a>
					</li>

				</ul>
			</section>
		</aside>

		<div class="content-wrapper">