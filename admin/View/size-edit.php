<?php

if (isset($_POST['form1'])) {
	$valid = 1;

	if (empty($_POST['size'])) {
		$valid = 0;
		$error_message .= "Size can not be empty<br>";
	} else {
		if (empty($_POST['size'])) {
			$valid = 0;
			$error_message .= "Tên Size không được để trống<br>";
		} else {



			$data = array(
				'sizenew' => $_POST['size'],
				'id' => $_REQUEST['id']
			);

			$apiUrl = 'http://localhost:8080/api-admin/controller-size/edit';
			$ch = curl_init($apiUrl);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			$response = curl_exec($ch);
			curl_close($ch);
			$responseData = json_decode($response, true);

			if ($responseData === null) {

				$error_message .= "Error<br>";
			} else {
				$success_message = 'Thay đổi Size thành công.';
			}
		}
	}
}
?>


<section class="content-header">
	<div class="content-header-left">
		<h1>Chỉnh sửa Size</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=size" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<?php


$apiUrl = 'http://localhost:8080/api-admin/controller-size/show-id';
$data = array(
	'id' => $_REQUEST['id']
);
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$responseData = json_decode($response, true);

if ($responseData === null) {
    die('Invalid JSON data');
}

// print_r( $responseData);
	$size = $responseData['data']['size'];

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

			<form class="form-horizontal" action="" method="post">

				<div class="box box-info">

					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Size<span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="size" value="<?php echo $size; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Update</button>
							</div>
						</div>

					</div>

				</div>

			</form>



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