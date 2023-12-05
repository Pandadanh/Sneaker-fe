<?php if (isset($_GET['tc'])) : ?>
	<?php echo "<script type='text/javascript'>alert('Đã xóa');</script>"; ?>
<?php endif; ?>

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
		<h1>Quản lý nhà cung cấp</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=nhacungcap-add" class="btn btn-primary btn-sm"  <?php ktne("cds-them", $quyen) ?>>Add New</a>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<div class="wrap col-md-12">
						<div class="m-5 ">
							<div class="">Search <input type="text" id="search" placeholder="ID or Name"> <input type="button" value="Tìm" onclick="show(1)"></div>
						</div>
						<table class="table align-middle mb-0 bg-white table-bordered text-center table-hover">
							<thead class="bg-light">
								<tr>
									<th class="col-md-2">ID</th>
									<th class="col-md-4">Tên nhà cung câp</th>
									<th class="col-md-4">Actions</th>
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
		xmlhttp.open("GET", "../Controllers/controller_nhacungcap/controller_nhacungcap-pt-pk.php?p=" + p + "&search=" + search, true);
		xmlhttp.send();
	}
	window.onload = show(1);
</script>