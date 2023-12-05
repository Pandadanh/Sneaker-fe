
<?php
$apiUrl = 'http://localhost:8080/api/controller-page/home';

// Tạo một cURL session
$curl = curl_init($apiUrl);

// Cấu hình các tùy chọn cho cURL
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Thực hiện request GET và lấy dữ liệu trả về
$response = curl_exec($curl);

// Đóng cURL session
curl_close($curl);

// Giải mã dữ liệu JSON trả về thành mảng PHP
$data = json_decode($response, true);
// print_r($_SESSION);
?>

<div id="slider" class="mb-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 p-0">
                <div id="home-slide" class="carousel slide carousel-fade" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#home-slide" class="active" data-slide-to="0"></li>
                        <li data-target="#home-slide" class="active" data-slide-to="1"></li>
                        <li data-target="#home-slide" class="active" data-slide-to="2"></li>
                        <li data-target="#home-slide" class="active" data-slide-to="3"></li>
                        <li data-target="#home-slide" class="active" data-slide-to="4"></li>
                        <li data-target="#home-slide" class="active" data-slide-to="5"></li>
                        <li data-target="#home-slide" class="active" data-slide-to="6"></li>
                        <li data-target="#home-slide" class="active" data-slide-to="7"></li>
                    </ol>
                    <div class="carousel-inner">
                        <?php
                       
                       $result = $data["list_data"]["list_silders"];
                        foreach ($result as $row) {
                        ?>
                            <div class="carousel-item active" data-inteval="4800">
                                <img src="../uploads/<?php echo $row['photo'] ?>" alt="" class="d-block w-100" />
                            </div>

                        <?php
                            break;
                        }
                        foreach ($result as $row) {
                        ?>
                            <div class="carousel-item" data-inteval="4800">
                                <img src="../uploads/<?php echo $row['photo'] ?>" alt="" class="d-block w-100" />
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <!-- end carousel-inner -->
                    <a href="#home-slide" class="carousel-control-prev" data-slide="prev">
                        <span class="carousel-control-prev-icon w-25 h-25"></span>
                    </a>
                    <a href="#home-slide" class="carousel-control-next" data-slide="next">
                        <span class="carousel-control-next-icon w-25 h-25"></span>
                    </a>
                    <!-- end control next-prev -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end slider -->
<div id="content">
    <div id="new-collection box">
        <div class="container">
            <div class="row box-head">
                <div class="col-md-12 text-center">
                  
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row box-body list-new-collection mb-5">
                <?php
                
                $result = $data["list_data"]["list_product_top4"];
                foreach ($result as $row) {
                ?>
                    <div class="col-md-3 col-sm-6 col-12 mb-4">
                        <a href="chitietsp.php?id=<?php echo $row['idPro']; ?>" class="img-new-collection img-box-body">
                            <img src="../uploads/<?php echo $row['hinhAnh'] ?>" alt="" />
                        </a>
                        <span class="tag-sale">Hàng mới</span>
                        <a href="chitietsp.php?id=<?php echo $row['idPro']; ?>" class="name-new-collection name-box-body text-dark text-justify"><?php echo $row['tenPro'] ?></a>
                        <span class="price-box-body d-block text-center text-danger"><?php echo money($row['giaMoi']) ?></span>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div id="caring box" class="bg-light">
        <div class="container pt-5">
            <div class="row box-head">
                <div class="col-md-12 text-center mb-5">
                    <h1 class="text-uppercase">Bạn đang quan tâm</h1>
                </div>
            </div>
        </div>
        <div class="container pb-5 mb-5">
            <div class="row box-body">
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="index.php?page=product&danhmuc=1" class="img-box-body">
                        <img src="assets/images/newcoll_1_img_large.jpg" alt="" />
                    </a>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="index.php?page=product&danhmuc=2" class="img-box-body">
                        <img src="assets/images/newcoll_2_img_large.jpg" alt="" />
                    </a>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="index.php?page=product" class="img-box-body">
                        <img src="assets/images/newcoll_4_img_large.jpg" alt="" />
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="brand box ">
        <div class="container">
            <div class="row box-head">
                <div class="col-md-12 text-center mb-5">
                    <h1 class="text-uppercase">Tìm theo thương hiệu</h1>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row box-body pb-5 mb-5">
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="index.php?page=product&nhanhieu=1" class="img-box-body">
                        <img src="assets/images/check_use_icon_1_large.webp" alt="" />
                    </a>
                    <a href="" class="brand-name">Giày Nike</a>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="index.php?page=product&nhanhieu=2" class="img-box-body">
                        <img src="assets/images/check_use_icon_2_large.jpg" alt="" />
                    </a>
                    <a href="" class="brand-name">Giày Adidas</a>
                </div>

                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="index.php?page=product&nhanhieu=4" class="img-box-body">
                        <img src="assets/images/check_use_icon_3_large.webp" alt="" />
                    </a>
                    <a href="" class="brand-name">Giày Mizuno</a>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="index.php?page=product&nhanhieu=7" class="img-box-body">
                        <img src="assets/images/check_use_icon_4_large.webp" alt="" />
                    </a>
                    <a href="" class="brand-name">Giày Puma</a>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="index.php?page=product&nhanhieu=8" class="img-box-body">
                        <img src="assets/images/check_use_icon_7_large.jpg" alt="" />
                    </a>
                    <a href="" class="brand-name">Giày Kamito</a>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="index.php?page=product&nhanhieu=5" class="img-box-body">
                        <img src="assets/images/check_use_icon_12_large.jpg" alt="" />
                    </a>
                    <a href="" class="brand-name">Giày Asics</a>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="index.php?page=product" class="img-box-body">
                        <img src="assets/images/check_use_icon_8_large.jpg" alt="" />
                    </a>
                    <a href="" class="brand-name">Giày Athleta</a>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="index.php?page=product&nhanhieu=10" class="img-box-body">
                        <img src="assets/images/check_use_icon_5_large.webp" alt="" />
                    </a>
                    <a href="" class="brand-name">Giày Loma</a>
                </div>
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="index.php?page=product&nhanhieu=3" class="img-box-body">
                        <img src="assets/images/check_use_icon_6_large.jpg" alt="" />
                    </a>
                    <a href="" class="brand-name">Giày Desporte</a>
                </div>
            </div>
        </div>
    </div>
    <div id="type box">
        <div class="container">
            <div class="row box-head">
                <div class="col-md-12 text-center">
                    <nav class="d-inline-block mb-4">
                        <div class="nav nav-tabs">
                            <a href="#tab-1" class="title-nav-tab nav-item nav-link active" data-toggle="tab">Giày sân cỏ nhân tạo</a>
                            <a href="#tab-2" class="title-nav-tab nav-item nav-link" data-toggle="tab">Giày sân
                                futsal</a>
                        </div>
                    </nav>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-1">
                            <div class="container">
                                <div class="row box-body">
                                    <?php
                                  

                                    $result = $data["list_data"]["list_product_iddm1"];
                                    foreach ($result as $row) {
                                    ?>
                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <a href="chitietsp.php?id=<?php echo $row['idPro']; ?>" class="img-box-body">
                                                <img src="../uploads/<?php echo $row['hinhAnh'] ?>" alt="" />
                                            </a>
                                            <a href="chitietsp.php?id=<?php echo $row['idPro']; ?>" class="name-type name-box-body text-dark text-justify"><?php echo $row['tenPro'] ?></a>
                                            <span class="price-box-body d-block text-center text-danger"><?php echo money($row['giaMoi']) ?></span>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane show fade" id="tab-2">
                            <div class="container">
                                <div class="row box-body">
                                <?php
                                    $result = $data["list_data"]["list_product_iddm2"];
                                    foreach ($result as $row) {
                                    ?>
                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <a href="chitietsp.php?id=<?php echo $row['idPro']; ?>" class="img-box-body" style="height: 300px;">
                                                <img src="../uploads/<?php echo $row['hinhAnh'] ?>" alt="" />
                                            </a>
                                            <a href="chitietsp.php?id=<?php echo $row['idPro']; ?>" class="name-type name-box-body text-dark text-justify"><?php echo $row['tenPro'] ?></a>
                                            <span class="price-box-body d-block text-center text-danger"><?php echo money($row['giaMoi']) ?></span>
                                        </div>

                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div