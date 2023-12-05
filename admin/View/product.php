<section class="content-header">
	<div class="content-header-left">
		<h1>Danh sách sản phẩm</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=product-add" class="btn btn-primary btn-sm" <?php ktne("sp-xoa", $quyen) ?>>Add new</a>
	</div>
</section>
<?php

if (ktne11("sp-xoa", $quyen) == false) {
	$css = "#xoa { display: none}";
	echo "<style>$css</style>";
}
if (ktne11("sp-sua", $quyen) == false) {
	$css = "#sua { display: none}";
	echo "<style>$css</style>";
}

?>

<section class="content" style="overflow-x: scroll;">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info" style="width: 1550px;">
				<div class="box-body table-responsive">
					<div class="wrap col-md-12">
						<div class="m-5 ">

							<?php

							$apiUrl = 'http://localhost:8080/api-admin/controller-product/show-dm-nh';
							$ch = curl_init($apiUrl);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

							$response = curl_exec($ch);

							curl_close($ch);

							if ($response === false) {
								die('CURL Error: ' . curl_error($ch));
							}
							if ($response) {
								$data = json_decode($response, true);

								if ($data === null) {
									die('Invalid JSON data');
								}
							}
							?>
							<form style="display:flex; margin: 30px 0 10px 0;">
								<div style="padding: 0 20px;">
									Search <input type="text" id="search" placeholder="ID or Name" style="height: 30px; width: 200px;">
								</div>
								<div style="padding: 0 20px;">
									Nhãn hiệu <select name="" onchange="show(1)" id="nhanhieu" style="height: 30px; width: 150px;">
										<option value="">Tất cả</option>
										<?php
									
										$result = $data['list_data']['list_nhanhieu'];
										foreach ($result as $row) {
										?>
											<option value="<?php echo $row['id_nh'] ?>"><?php echo $row['nhanhieu'] ?></option>
										<?php
										}
										?>
									</select>

								</div>
								<div style="padding: 0 20px;">
									Danh mục <select name="" onchange="show(1)" id="danhmuc" style="height: 30px; width: 150px;">
										<option value="">Tất cả</option>
										<?php
										$result = $data['list_data']['list_danhmuc'];
										foreach ($result as $row) {
										?>
											<option value="<?php echo $row['idDm'] ?>"><?php echo $row['danhMuc'] ?></option>
										<?php
										}
										?>
									</select>
								</div>
								<div style="padding: 0 20px;">
									Số Dòng / Trang <input type="number" value="5" onchange="show(1)" id="sodong" style="height: 30px; width: 50px;">
								</div>
								<div style="padding: 0 20px;"><input type="button" id="tim" value="Tìm" onclick="show(1)" style="height: 30px; width: 50px;"></div>

							</form>
						</div>
						<table id="example1" class="table table-bordered table-hover table-striped">
							<thead class="thead-dark">
								<tr>
									<th class="col-md-1 text-center">id</th>
									<th class="col-md-1">Hình ảnh</th>
									<th class="col-md-3">Tên sản phẩm</th>
									<th class="col-md-1">Danh mục</th>
									<th class="col-md-1">Nhãn hiệu</th>
									<th class="col-md-1 text-center">Giá cũ</th>
									<th class="col-md-1 text-center">Giá</th>
									<th class="col-md-1 text-center">Lượt xem</th>
									<th class="col-md-1 text-center">Số lượng</th>
									<th class="col-md-1">Hành động</th>
								</tr>
							</thead>
							<tbody id="dulieu">

							</tbody>
						</table>
					</div>
					<style>
					</style>
					<nav aria-label="Page navigation " style="width: 100%; display: flex; justify-content: center; padding-bottom: 20px;">

						<ul class="pagination mt-3 row " id="trang" style="width: 400px; display: flex; justify-content: center; overflow-x: scroll;">
						</ul>

					</nav>
				</div>
			</div>
		</div>
</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure want to delete this item?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok">Delete</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="soluong" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Số lượng từng kích thước</h4>
			</div>
			<div class="modal-body">
				<table class="table text-center">
					<thead>
						<tr>
							<th>Kích thước</th>
							<th>Số lượng</th>
						</tr>
					</thead>
					<tbody id="soluongsize">

					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<script defer>
	function show(p) {
		var search = document.getElementById("search").value;
		var id_nh = document.getElementById("nhanhieu").value;
		var id_dm = document.getElementById("danhmuc").value;
		var sodong = document.getElementById("sodong").value;
		if (sodong < 1) {
			alert("Số dòng không hợp lệ");
			document.getElementById("sodong").value = 5;
			return;
		}
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var inra = this.responseText.split("???");
				document.getElementById("dulieu").innerHTML = inra[0];
				document.getElementById("trang").innerHTML = inra[1];
			}
		}
		xmlhttp.open("GET", "../Controllers/controller_product/controller_product-pt-tk.php?p=" + p + "&search=" + search + "&id_nh=" + id_nh + "&id_dm=" + id_dm + "&sodong=" + sodong, true);
		xmlhttp.send();
	}
	window.onload = show(1);

	function soluongne(p) {
		var search = document.getElementById("search").value;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("soluongsize").innerHTML = this.responseText;

			}
		}
		xmlhttp.open("GET", "../Controllers/controller_product/controller_product_SL.php?id_pro=" + p, true);
		xmlhttp.send();


	}
</script>