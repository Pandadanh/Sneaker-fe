


<?php

if (ktne11("cds-xoa", $quyen) == false) {
	$css = "#xoa { display: none}";
	echo "<style>$css</style>";
}
if (ktne11("cds-sua", $quyen) == false) {
	$css = "#sua { display: none}";
	echo "<style>$css</style>";
}

?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Quản lý Nhãn hiệu</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=nhanhieu-add" class="btn btn-primary btn-sm"  <?php ktne("cds-xoa", $quyen) ?>>Add New</a>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<div class="wrap col-md-12">
						<div class="m-5 ">
							<form>
								<div class="">Search <input type="text" id="search" placeholder="ID or Name"><input type="button" value="Tim" id="tim" onclick="show(1)"></div>
							</form>
						</div>
						<table id="example1" class="table align-middle mb-0 bg-white text-center table-hover  table-bordered  table-striped">
							<thead class="bg-light">
								<tr>
									<th class="col-md-2">ID</th>
									<th class="col-md-4">Nhãn hiệu</th>
									<th class="col-md-6">Actions</th>
								</tr>
							</thead>
							<tbody id="dulieu">

							</tbody>
						</table>
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
				Are you sure want to delete this item?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<a class="btn btn-danger btn-ok">Delete</a>
			</div>
		</div>
	</div>
</div>

<script defer>
	function show(p) {
		var search = document.getElementById("search").value;
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var inra = this.responseText.split("???");
				document.getElementById("dulieu").innerHTML = inra[0];
				document.getElementById("trang").innerHTML = inra[1];
			}
		}
		xmlhttp.open("GET", "../Controllers/controller_nhanhieu/controller_nhanhieu-pt-tk.php?p=" + p + "&search=" + search, true);
		xmlhttp.send();
	}
	window.onload = show(1);
</script>