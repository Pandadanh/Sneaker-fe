<?php 

if (!function_exists('money')) {
    function money($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', ',') . "{$suffix}";
        }
    }
}

include('./Helper.php');
$db = new Helper();
$statement = "SELECT * FROM tbl_setting where id=1";
$result = $db ->fetchOne($statement);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../shop-giay/assets/font/fontawesome/css/all.css" />
    <script src="assets/js/main.js"></script>
    <link rel="stylesheet" href="./assets/css/product-detail.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <title>Shop bán giày</title>
    <link rel="icon" type="image/x-icon" href="../uploads/<?php echo $result['favicon'] ?>">
</head>
<body>

    <div id="wrapper">
        <div id="header">
            <div class="container-fluid pt-3 position-relative">
                <div class="row d-flex justify-content-between">
                    <div class="logo col-md-3">
                        <a href="index.html" class="d-block logo-icon">
                            <!-- <img src="assets/images/Screenshot 2023-03-03 171243.png" alt="" /> -->
                            <img src="../uploads/<?php echo $result['logo'] ?>" alt="" />
                        </a>
                    </div>
                    <?php
                    session_start();
                    if (isset($_SESSION['user1'])) {
                        $ten_user = $_SESSION['user1']['ten_user'];
                        $avatar = $_SESSION['user1']['avatar'];
                    } else {
                        $ten_user = "";
                        $avatar = "";
                    }
                    ?>
                    <div class="mr-3 mt-4" id="ttdn">
                        <img src="../uploads/<?php echo $avatar ?>" alt="" style="width:50px">
                        <?php echo $ten_user ?>
                    </div>

                    <form id="form-search-responsive">
                        <input type="text" name="query" placeholder="Bạn muốn tìm gì?" />
                        <button>
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="container-fluid position-relative">
                <button id="icon-menu-responsive">
                    <i class="icon-menu-responsive fa-solid fa-bars"></i>
                </button>
                <div class="row">
                    <div class="col-md-6">
                        <nav>
                            <ul id="main-menu">
                                <li><a href="index.php?page=home">Trang chủ</a></li>
                                <li><a href="index.php?page=product">Tất cả sản phẩm</a></li>
                                <li>
                                    <a href="">Thương hiệu <i class="fa-solid fa-sort-down"></i></a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a class="position-relative" href="">Nike </i></a>

                                        </li>
                                        <li>
                                            <a href="">Adidas</i></a>

                                        </li>
                                        <li>
                                            <a href="">Puma</i></a>

                                        </li>
                                        <li>
                                            <a href="">Mizuno</i></a>

                                        </li>
                                        <li>
                                            <a href="">Kamito</i></a>

                                        </li>
                                        <li>
                                            <a href="">Joma</i></a>

                                        </li>
                                        <li>
                                            <a href="">Asics</i></a>

                                        </li>
                                        <li>
                                            <a href="">Athleta</a>

                                        </li>
                                        <li>
                                            <a href="">Desporte</a>

                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Giày cỏ nhân tạo <i class="fa-solid fa-sort-down"></i></a>
                                    <ul class="sub-menu text-dark">
                                        <li><a href="">Nike </a></li>
                                        <li><a href="">Adidas</a></li>
                                        <li><a href="">Puma</a></li>
                                        <li><a href="">Mizuno</a></li>
                                        <li><a href="">Kamito</a></li>
                                        <li><a href="">Desporte</a></li>
                                        <li><a href="">Asics</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">Giày futsal <i class="fa-solid fa-sort-down"></i></a>
                                    <ul class="sub-menu">
                                        <li><a href="">Nike</a></li>
                                        <li><a href="">Adidas</a></li>
                                        <li><a href="">Puma</a></li>
                                        <li><a href="">Mizuno</a></li>
                                        <li><a href="">Kamito</a></li>
                                        <li><a href="">Joma</a></li>
                                        <li><a href="">Asics</a></li>
                                        <li><a href="">Athleta</a></li>
                                        <li><a href="">Desporte</a></li>
                                    </ul>
                                </li>

                                <li><a href="">Hot sale</a></li>
                                <li><a href="index.php?page=chitietsp">Liên hệ</a></li>
                            </ul>
                        </nav>
                        <nav>
                            <ul id="main-menu-responsive">
                                <li><a href="index.php?page=home">Trang chủ</a></li>
                                <li><a href="">Tất cả sản phẩm</a></li>
                                <li class="position-relative">
                                    <a href="">Thương hiệu </a><i class="icon-sub-menu fa-solid fa-caret-right"></i>
                                    <ul class="sub-menu">
                                        <li class="position-relative">
                                            <a href="">Nike </a></i>

                                        </li>
                                        <li class="position-relative">
                                            <a href="">Adidas</a></i>

                                        </li>
                                        <li class="position-relative">
                                            <a href="">Puma</a></i>

                                        </li>
                                        <li class="position-relative">
                                            <a href="">Mizuno</a></i>

                                        </li>
                                        <li class="position-relative">
                                            <a href="">Kamito</a></i>
                                            <ul class="sub-sub-menu">
                                                <li><a href="">Giày đá banh Kamito TA11</a></li>
                                            </ul>
                                        </li>
                                        <li class="position-relative">
                                            <a href="">Joma</a></i>

                                        </li>
                                        <li class="position-relative">
                                            <a href="">Asics</a></i>

                                        </li>
                                        <li class="position-relative">
                                            <a href="">Athleta</a>
                                            </i>
                                            <ul class="sub-sub-menu">
                                                <li><a href="">Giày đá banh Athleta O-rei</a></li>
                                            </ul>
                                        </li>
                                        <li class="position-relative">
                                            <a href="">Desporte</a></i>

                                        </li>
                                    </ul>
                                </li>
                                <li class="position-relative">
                                    <a href="">Giày cỏ nhân tạo </a>
                                    <i class="icon-sub-menu fa-solid fa-caret-right"></i>
                                    <ul class="sub-menu text-dark">
                                        <li><a href="">Nike </a></li>
                                        <li><a href="">Adidas</a></li>
                                        <li><a href="">Puma</a></li>
                                        <li><a href="">Mizuno</a></li>
                                        <li><a href="">Kamito</a></li>
                                        <li><a href="">Desporte</a></li>
                                        <li><a href="">Asics</a></li>
                                    </ul>
                                </li>
                                <li class="position-relative">
                                    <a href="">Giày futsal </a><i class="icon-sub-menu fa-solid fa-caret-right"></i>
                                    <ul class="sub-menu">
                                        <li><a href="">Nike</a></li>
                                        <li><a href="">Adidas</a></li>
                                        <li><a href="">Puma</a></li>
                                        <li><a href="">Mizuno</a></li>
                                        <li><a href="">Kamito</a></li>
                                        <li><a href="">Joma</a></li>
                                        <li><a href="">Asics</a></li>
                                        <li><a href="">Athleta</a></li>
                                        <li><a href="">Desporte</a></li>
                                    </ul>
                                </li>

                                <li><a href="">Hot sale</a></li>
                                <li><a href="">Liên hệ</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-5 col-sm-3 position-absolute ">
                        <form action="" id="form-search" style="right:-105%; ">
                            <input type="text" name="form-search" placeholder="Bạn muốn tìm gì?" class="form-control" />
                            <button name="btn-search" class="btn btn-dark ml-2">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                    <div class="login col-md-1 col-sm-1 col-1 ml-auto">
                        <ul class="list-icon">
                            <li>
                                <a href="index.php?page=giohang"><i class="fa-solid fa-cart-shopping"></i></a>
                                <span style="position: absolute; top:0; right:2px; color:red">0</span>
                                
                            </li>
                            <li class="icon-login-1 ml-2">
                                <a href="">
                                    <i class="fa-regular fa-user"></i>
                                </a>
                                <ul class="sub-login">
                                    <?php
                                    if (isset($_SESSION['user1'])) {
                                        echo '<li><a href="index.php?page=login"">Đăng xuất</a></li>';
                                    } 
                                    else{
                                        echo'<li><a href="index.php?page=sign-up">Đăng ký</a></li>
                                        <li><a href="index.php?page=login">Đăng nhập</a></li>';
                                    }?>
                                    
                                </ul>
                            </li>
                            <li class="icon-login-2 ml-2">
                                <i class="fa-regular fa-user"></i>
                                <ul class="sub-login">
                                <?php
                                    if (isset($_SESSION['user1'])) {
                                        echo '<li><a href="index.php?page=login" ">Đăng xuất</a></li>';
                                    } 
                                    else{
                                        echo'<li><a href="index.php?page=sign-up">Đăng ký</a></li>
                                        <li><a href="index.php?page=login">Đăng nhập</a></li>';
                                    }?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php

        ?>
     