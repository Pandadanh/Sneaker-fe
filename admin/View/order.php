<?php
if (isset($_POST['xacnhan'])) {

    $id_xuly = $_POST['id_xuly'];

    $data = array(
        'id_nv' => $_SESSION['user']['idUser'],
        'id_px' =>  $id_xuly
	);

	$apiUrl = 'http://localhost:8080/api-admin/controller-don-hang/xacnhan';
	$ch = curl_init($apiUrl);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$response = curl_exec($ch);
	curl_close($ch);
	
    
    echo "<script type='text/javascript'>alert('Xác nhận thành công');</script>";
}
if (isset($_POST['huydon'])) {

    $id_xuly = $_POST['id_xuly'];

    $data = array(
        'id_nv' => $_SESSION['user']['idUser'],
        'id_px' =>  $id_xuly
	);

	$apiUrl = 'http://localhost:8080/api-admin/controller-don-hang/huyxacnhan';
	$ch = curl_init($apiUrl);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	$response = curl_exec($ch);
	curl_close($ch);
    echo "<script type='text/javascript'>alert('Đã hủy đơn');</script>";
}

?>
<section class="content-header">
    <div class="content-header-left">
        <h1>Các đơn hàng</h1>
    </div>
</section>

<?php

if (ktne11("dh-xacnhan", $quyen) == false) {
	$css = "#dh-xacnhan{ display: none}";
	echo "<style>$css</style>";
}
   
?>

<section class="content">
    <div class="row">
        <div class="box box-info">
            <div class="box-body table-responsive" style=" overflow-x: scroll;">
                <div class="wrap col-md-12">
                    <div class="m-5 ">
                        <form>
                            <input type="hidden" name="p" value="1">
                            <div class="text-center" style="width: 1500px;">
                                Từ ngày <input type="date" name="" id="ngaymin" value="2020-01-01" style="margin-left:10px ;margin-right: 10px;">
                                đến ngày <input type="date" name="" id="ngaymax" style="margin-left:10px ; margin-right: 30px; " value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" style="margin-right: 50px;">
                                Tình Trạng <select name="" id="tinhtrang" onchange="show(1)" style="margin-right: 20px; height: 25px;">
                                    <option value="">Tất cả</option>
                                    <option value="0">Chờ xác nhận</option>
                                    <option value="1">Đã xác nhận</option>
                                    <option value="2">Đã hủy</option>
                                </select>
                                Số dòng / Trang <input type="number" value="5" min="1" max="100" required id="sodong" style="height: 25px; margin-right: 50px;">
                                <input type="button" id="tim" value="Tim" onclick="show(1)">
                            </div>
                        </form>
                    </div>
                    <table id="example1" class="table table-bordered table-hover table-striped" style="width: 1530px;">
                        <thead>
                            <tr>
                                <th class="col-md-1 text-center">ID Đơn Hàng</th>
                                <th class="col-md-2">Khách hàng</th>
                                <th class="col-md-2">Nhân viên</th>
                                <th class="col-md-2 text-center">Ngày đặt</th>
                                <th class="col-md-1 text-center">Số lượng</th>
                                <th class="col-md-1 text-right">Tổng tiền</th>
                                <th class="col-md-2 text-center">Trạng thái</th>
                                <th class="col-md-1 text-center">Hành động</th>
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
</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Sure you want to delete this item?
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
        var ngaymin = document.getElementById("ngaymin").value;
        var ngaymax = document.getElementById("ngaymax").value;
        var tinhtrang = document.getElementById("tinhtrang").value;
        var sodong = document.getElementById("sodong").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var inra = this.responseText.split("???");
                document.getElementById("dulieu").innerHTML = inra[0];
                document.getElementById("trang").innerHTML = inra[1];
            }
        }
        xmlhttp.open("GET", "../Controllers/controller_donhang/controller_order-pt-tk.php?p=" + p + "&ngaymin=" + ngaymin + "&ngaymax=" + ngaymax + "&tinhtrang=" + tinhtrang + "&sodong=" + sodong, true);
        xmlhttp.send();
    }
    window.onload = show(1);
</script>
<div class="modal fade"  id="chitiet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
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
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("dulieune").innerHTML = this.responseText;

			}
		}
		xmlhttp.open("GET", "../Controllers/controller_donhang/controller_chitietdh.php?id_lay=" + id_lay, true);
		xmlhttp.send();
	}
</script>