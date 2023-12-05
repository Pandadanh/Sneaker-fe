<?php
session_start();
if (!function_exists('money')) {
    function money($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', ',') . "{$suffix}";
        }
    }
}



$apiUrl = 'http://localhost:8080/api/controller-page/header';
$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

$result = $data['list_data']['list_setting'][1];

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
    <link rel="stylesheet" href="assets/css/lienHe-footer.css" />
    <link rel="stylesheet" href="assets/css/all.css" />
    <title>Shop bán giày</title>
    <link rel="icon" type="image/x-icon" href="../uploads/<?php echo $result['favicon'] ?>">
    <style>
        #search-hints {
            position: absolute;
            display: block;
            top: 40px;
            left: 0;
            right: 0;
            background-color: white;
            border: 1px solid gray;
            z-index: 1;
        }

        #header {
            background-color: #E1E3E8 !important;
        }

        .row {
            background-color: #E1E3E8 !important;

        }

        #top_header {
            width: 100%;
            height: 45px;
            background-color: #424146;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .text-top-header {
            color: #ffffff;
            border-radius: 3px 3px 0 0;
            font-family: Roboto Condensed;
            font-size: 15px;
            font-weight: 15%;
            font-size: 15px;
            font-weight: inherit;

            /* Đặt độ đậm cho chữ */
            cursor: default;

        }
    </style>
    <script defer>
        function show() {
            var search = document.getElementById("search").value;
            if (search.length < 4) {
                document.getElementById("search-hints").innerHTML = "<div></div>";
                return
            }
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("search-hints").innerHTML = this.responseText;
                }
            }
            xmlhttp.open("GET", "./controllers/controller_goiy.php?search=" + search, true);
            xmlhttp.send();
        }
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                $("#search-hints").html("<div></div>");
            })
        });
        window.addEventListener("click", function(event) {
            var searchHints = document.getElementById("search-hints");
            // Kiểm tra nếu phần tử bấm vào không thuộc search-hints
            if (event.target !== searchHints && !searchHints.contains(event.target)) {
                // Tắt search-hints bằng cách gán nội dung thành chuỗi rỗng
                searchHints.innerHTML = "";
            }
        });
    </script>
</head>

<body>
    <div id="wrapper">

        <div id="top_header">
            <div class="text-top-header">Thanh Hùng Futsal - Giày Đá Bóng Chính Hãng - 2013</div>
        </div>
        <div id="header">
            <div class="container-fluid pt-3 position-relative">
                <div class="row d-flex justify-content-between">
                    <div class="logo col-md-3">
                        <a href="index.php?page=home" class="d-block logo-icon">
                            <img src="../uploads/<?php echo $result['logo'] ?>" alt="" />
                        </a>
                    </div>
                    <?php
                 
                    if (isset($_SESSION['user1'])) {

                        $ten_user = isset($_SESSION['user1']['data']['tenUser']);



                        if (isset($_SESSION['user1']['data']['avatar']) && $_SESSION['user1']['data']['avatar'] != '') {
                            $avatar = $_SESSION['user1']['data']['avatar'];
                        } else {
                            $_SESSION['user1']['data']['avatar'] = "user-5.jpg";
                            $avatar = $_SESSION['user1']['data']['avatar'];
                        }
                    } else {
                        $ten_user = "";
                        $avatar = "";
                    }
                    ?>

                    <div class="mr-3 " id="ttdn">
                        <?php
                        if ($avatar != "") {
                        ?>
                            <img src="../uploads/<?php echo $avatar; ?>" alt="" style="width:60px; height: 60px; border-radius: 100%;">
                            <!-- <?php echo $ten_user; ?> -->
                        <?php
                        }
                        ?>
                    </div>



                    <form id="form-search-responsive">
                        <input type="text" name="query" id="search-input" onkeypress="show()" onchange="show()" placeholder="Bạn muốn tìm gì?" />
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
                                    <a href="index.php?page=product">Thương hiệu <i class="fa-solid fa-sort-down"></i></a>
                                    <ul class="sub-menu">
                                        <?php


                                        $result = $data['list_data']['list_nhanhieu'];

                                        foreach ($result as $row) {
                                        ?>
                                            <li>
                                                <a href="index.php?page=product&nhanhieu=<?php echo $row['id_nh'] ?>"><?php echo $row['nhanhieu'] ?> </i></a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <?php

                                $result0 = $data['list_data']['list_danhmuc'];
                                foreach ($result0 as $danhmuc) {
                                ?>
                                    <li>
                                        <a href=""><?php echo $danhmuc['danhMuc'] ?> <i class="fa-solid fa-sort-down"></i></a>
                                        <ul class="sub-menu text-dark">
                                            <?php

                                            $result = $data['list_data']['list_nhanhieu'];
                                            foreach ($result as $nhanhieu) {
                                            ?>
                                                <li><a href="index.php?page=product&nhanhieu=<?php echo $nhanhieu['id_nh'] ?>&danhmuc=<?php echo $danhmuc['idDm'] ?>"><?php echo $nhanhieu['nhanhieu'] ?> </a></li>
                                            <?php
                                            }
                                            ?>

                                        </ul>
                                    </li>
                                <?php
                                }
                                ?>
                                <li><a href="index.php?page=lienhe">Liên hệ</a></li>
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
                                <li><a href="index.php?page=lienhe">Liên hệ</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-5 col-sm-3 position-absolute ">
                        <form action="index.php" id="form-search" style="right:-105%; ">
                            <input type="text" name="page" hidden value="product" />
                            <input type="text" name="search" id="search" onkeypress="show()" onkeydown="show()" placeholder="Bạn muốn tìm gì?" class="form-control" />
                            <button class="btn btn-dark ml-2">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                            <div id="search-hints">

                            </div>
                        </form>
                    </div>
                    <div class="login col-md-1 col-sm-1 col-1 ml-auto">
                        <ul class="list-icon">
                            <li>
                                <a href="index.php?page=giohang"><i class="fa-solid fa-cart-shopping"></i></a>
                                <span id="soluongGH" style="position: absolute; top: 0px; right:-5px; color:#e74c3c; border-radius: 100%; background: white; width: 20px; height: 20px; display:block; text-align:center; line-height: 20px; font-weight: bold;">
                                    <?php
                                    $num_products = 0;
                                    if (isset($_SESSION['cart'])) {
                                        foreach ($_SESSION['cart'] as $product) {
                                            // $num_products += $product['soluong'];
                                            $num_products += 1;
                                        }
                                    }
                                    echo $num_products;
                                    ?>
                                </span>

                            </li>
                            <li class="icon-login-1 ml-2">
                                <a href="">
                                    <i class="fa-regular fa-user"></i>
                                </a>
                                <ul class="sub-login">
                                    <?php
                                    if (isset($_SESSION['user1'])) {
                                        echo '<li><a href="index.php?page=out"">Đăng Xuất</a></li>';
                                        echo '<li><a href="index.php?page=Profile-edit"">Chỉnh Sửa</a></li>';
                                    } else {
                                        echo '<li><a href="index.php?page=sign-up">Đăng ký</a></li>
                                        <li><a href="index.php?page=login">Đăng nhập</a></li>';
                                    } ?>

                                </ul>
                            </li>
                            <li class="icon-login-2 ml-2">
                                <i class="fa-regular fa-user"></i>
                                <ul class="sub-login">
                                    <?php
                                    if (isset($_SESSION['user1'])) {
                                        echo '<li><a href="index.php?page=out">Đăng Xuất</a></li>';
                                        echo '<li><a href="index.php?page=Profile-edit"">Chỉnh Sửa</a></li>';
                                    } else {
                                        echo '<li><a href="index.php?page=sign-up">Đăng ký</a></li>
                                        <li><a href="index.php?page=login">Đăng nhập</a></li>';
                                    } ?>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php

        ?>