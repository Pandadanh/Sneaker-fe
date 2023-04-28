
<?php
include "../Database/Helper.php";
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['size_name'])) {
        $valid = 0;
        $error_message .= "Size Name can not be empty<br>";
    } else {
    	// Duplicate Category checking
    	$statement = "SELECT * FROM tbl_size WHERE size=?";
		$para=[$_POST['size_name']];
		$db = new Helper();
    	$total = $db->rowCount($statement,$para);
    	if($total)
    	{
    		$valid = 0;
        	$error_message .= "Size Name already exists<br>";
    	}
    }

    if($valid == 1) {
		$statement = "INSERT INTO tbl_size (size,daxoa) VALUES (?,1)";
		$para=[$_POST['size_name']];
		$db = new Helper();
		$db->execute($statement,$para);
    	$success_message = 'Size is added successfully.';
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
