<section class="content-header">
	<h1>Dashboard</h1>
</section>
<style>
	.icon{
		margin-top: 15px;
	}
</style>
<?php
include("../Controllers/controller_dashboard.php");
?>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab_1" data-toggle="tab">Tổng quan</a></li>
					
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab_1">
						<div class="row">
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-primary">
									<div class="inner">
										<h3><?php echo $total_product; ?></h3>
										<p>Sản phẩm</p>
									</div>
									<div class="icon">
										<i class="fa fa-cubes"></i>
									</div>

								</div>
							</div>

							<!-- ./col -->
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-aqua">
									<div class="inner">
										<h3><?php echo $total_order; ?></h3>
										<p>Đơn hàng</p>
									</div>
									<div class="icon">
										<i class="fa fa-truck"></i>
									</div>

								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-3 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-red">
									<div class="inner">
										<h3><?php echo $total_customers; ?></h3>
										<p>Khách hàng</p>
									</div>
									<div class="icon">
										<i class="fa fa-users"></i>
									</div>

								</div>
							</div>

							<div class="col-lg-3 col-xs-6">
								<div class="small-box bg-info">
									<div class="inner">
										<h3><?php echo money($total_money) ?></h3>
										<p>Tổng thu nhập</p>
									</div>
									<div class="icon">
										<i class="fa fa-money"></i>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>