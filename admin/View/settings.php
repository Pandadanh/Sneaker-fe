<?php
//Change Logo


if (isset($_POST['form1'])) {
    $valid = 1;

    $path = $_FILES['photo_logo']['name'];
    $path_tmp = $_FILES['photo_logo']['tmp_name'];

    if ($path == '') {
        $valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if ($valid == 1) {
        $apiUrl = 'http://localhost:8080/api-admin/controller-setting/show';
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);

        
        $logo = $data['data']['logo'];
        unlink('../../uploads/' . $logo);
        // updating the data
        $final_name = 'logo' . '.' . $ext;
        move_uploaded_file($path_tmp, '../../uploads/' . $final_name);
        // updating the database

        $api_url = 'http://localhost:8080/api-admin/controller-setting/update-page';
        $image_path = '/path/to/your/image.jpg';
        $curl = curl_init($api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        $data = array(
            'filename_logo' =>array($final_name)
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);
        curl_close($curl);

        $success_message = 'Logo is updated successfully.';
    }
}
// Change Favicon
if (isset($_POST['form2'])) {
    $valid = 1;

    $path = $_FILES['photo_favicon']['name'];
    $path_tmp = $_FILES['photo_favicon']['tmp_name'];

    if ($path == '') {
        $valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    } else {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = basename($path, '.' . $ext);
        if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

    if ($valid == 1) {
       
            $favicon = $data['data']['favicon'];
            unlink('../../uploads/' . $favicon);
        
        // updating the data
        $final_name = 'favicon' . '.' . $ext;
        move_uploaded_file($path_tmp, '../../uploads/' . $final_name);

        // updating the database
        $api_url = 'http://localhost:8080/api-admin/controller-setting/update-page';
        $image_path = '/path/to/your/image.jpg';
        $curl = curl_init($api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        $data = array(
            'filename_favicon' =>array($final_name)
        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);
        curl_close($curl);

        $success_message = 'Favicon is updated successfully.';
    }
}
//Footer & Contact us page
if (isset($_POST['form3'])) {

        // updating the database
        $api_url = 'http://localhost:8080/api-admin/controller-setting/update-page';
        $image_path = '/path/to/your/image.jpg';
        $curl = curl_init($api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        $data = array(
            'footer_copyright' =>$_POST['footer_copyright'],
            'contact_address' =>$_POST['contact_address'],
            'footer_copyright' =>$_POST['footer_copyright'],
            'contact_email' =>$_POST['contact_email'],
            'contact_map_iframe' =>$_POST['contact_map_iframe']

        );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curl);
        curl_close($curl);
    $success_message = 'General content settings is updated successfully.';
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Cài đặt Websites</h1>
    </div>
</section>

<?php
$apiUrl = 'http://localhost:8080/api-admin/controller-setting/show';
$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);
$data = json_decode($response, true);


$logo                            = $data['data']['logo'];
$favicon                         = $data['data']['favicon'];
$footer_about                    = $data['data']['footerAbout'];
$footer_copyright                = $data['data']['footerCopyright'];
$contact_address                 = $data['data']['contactAddress'];
$contact_email                   = $data['data']['contactEmail'];
$contact_phone                   = $data['data']['contactPhone'];
$contact_map_iframe              = $data['data']['contactMapIframe'];
?>


<section class="content" style="min-height:auto;margin-bottom: -30px;">
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
        </div>
    </div>
</section>

<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Logo</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Favicon</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Existing Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../../uploads/<?php echo $logo; ?>" class="existing-photo" style="height:80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">New Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <input type="file" name="photo_logo">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form1">Update Logo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab_2">
                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Existing Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../../uploads/<?php echo $favicon; ?>" class="existing-photo" style="height:40px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">New Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <input type="file" name="photo_favicon">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form2">Update Favicon</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="tab_3">
                        <form class="form-horizontal" action="" method="post">
                            <div class="box box-info">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Footer - Copyright </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="footer_copyright" style="height:50px;width:1000px"><?php echo $footer_copyright; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Contact Address </label>
                                        <div class="col-sm-6">
                                            <textarea class="form-control" name="contact_address" style="height:140px;width:1000px"><?php echo $contact_address; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Contact Email </label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="contact_email" value="<?php echo $contact_email; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Contact Phone Number </label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" name="contact_phone" value="<?php echo $contact_phone; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Contact Map iFrame </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="contact_map_iframe" style="height:200px;width:1000px"><?php echo $contact_map_iframe; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label"></label>
                                        <div class="col-sm-6">
                                            <button type="submit" class="btn btn-success pull-left" name="form3">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>