<section class="content-header">
	<div class="content-header-left">
		<h1>Sliders</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=slider-add" class="btn btn-primary btn-sm"  <?php ktne("slider-add", $quyen) ?> >Add Slider</a>
	</div>
</section>


<?php
if (ktne11("slider-xoa", $quyen) == false) {
	$css = "#xoa { display: none}";
	echo "<style>$css</style>";
}
if (ktne11("slider-sua", $quyen) == false) {
	$css = "#sua { display: none}";
	echo "<style>$css</style>";
}

?>

?>

<section class="content">
	<div class="row">
		<div class="box box-info">
			<div class="box-body table-responsive">
				<div class="wrap col-md-12">
					<div class="m-5 ">
					</div>
					<table id="example1" class="table table-bordered table-hover table-striped">
						<thead>
							<tr>
								<th class="col-md-1">ID</th>
								<th class="col-md-6">Hình ảnh</th>
								<th class="col-md-2">Hành động</th>
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

		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var inra = this.responseText.split("???");
				document.getElementById("dulieu").innerHTML = inra[0];
				document.getElementById("trang").innerHTML = inra[1];
			}
		}
		xmlhttp.open("GET", "../Controllers/controller_sliders/controller_sliders-pt-tk.php?p=" + p, true);
		xmlhttp.send();
	}
	window.onload = show(1);
</script>