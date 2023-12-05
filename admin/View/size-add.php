
<?php

if(isset($_POST['form1'])) {
	if(empty($_POST['size_name'])) {
        $valid = 0;
        $error_message .= "Size không được để trống<br>";
    } else {
		$data = array(
			'sizenew' => $_POST['size_name']
		);

		$apiUrl = 'http://localhost:8080/api-admin/controller-size/add';
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
			$success_message = 'Thêm Size thành công.';
		}


	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Thêm Size</h1>
	</div>
	<div class="content-header-right">
		<a href="index.php?page=size" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


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

			<form class="form-horizontal" action="" method="post">

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Size Name <span>*</span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="size_name">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>

			</form>


		</div>
	</div>

</section>
