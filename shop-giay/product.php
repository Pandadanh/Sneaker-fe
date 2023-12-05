<?php
$apiUrl = 'http://localhost:8080/api/controller-page/inf-product';

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

?>
<link rel="stylesheet" href="./style.css">

<style>
    .range-slider {
        height: 5px;
        position: relative;
        background-color: #e1e9f6;
        border-radius: 2px;
    }

    .range-selected {
        height: 100%;
        left: 30%;
        right: 30%;
        position: absolute;
        border-radius: 5px;
    }

    .range-input {
        position: relative;
    }

    .range-input input {
        position: absolute;
        width: 100%;
        height: 5px;
        top: -7px;
        background: none;
        pointer-events: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    .range-input input::-webkit-slider-thumb {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        border: 3px solid #1b53c0;
        background-color: #fff;
        pointer-events: auto;
        -webkit-appearance: none;
    }

    .range-input input::-moz-range-thumb {
        height: 15px;
        width: 15px;
        border-radius: 50%;
        border: 3px solid #1b53c0;
        background-color: #fff;
        pointer-events: auto;
        -moz-appearance: none;
    }

    #minne,
    #maxne {
        width: 100%;
        text-align: center;
        border: none;

    }

    a .box-body {
        overflow: hidden;
    }

    .cart a {
        display: block;
    }

    .img-box-body {
        transition: all .3s;
    }

    .img-box-body:hover {
        transform: scale(1.1);
    }

    @media(min-width: 800px) {
        .card {
            height: 580px !important;
        }
    }

    .card {
        min-height: 580px;
    }
</style>
<script>
    function laygia() {
        var min = document.getElementById("min").value;
        var max = document.getElementById("max").value;
        if (max * 1 <= min * 1) {
            document.getElementById("minne").value = intToVND(max);
            document.getElementById("maxne").value = intToVND(min);
        } else {
            document.getElementById("minne").value = intToVND(min);
            document.getElementById("maxne").value = intToVND(max);
        }
    }

    function intToVND(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " đ";
    }

    function VNDtoInt(str) {
        var vnd = parseInt(str.replace(/[^\d]/g, ""), 10);
        return parseInt(vnd, 10);
    }
</script>

<div id="contain">
    <div class="left-menu">
        <div class="gia mt-3 mb-3" class="unselectable">
            <h1>GIÁ
                <span id="size-toggle" class="toggle" class="unselectable"><img src="" alt="">+</span>
            </h1>
            <div class="range mt-4">
                <div class="range-slider">
                    <span class="range-selected"></span>
                </div>
                <div class="range-input">
                    <input type="range" class="min" id="min" min="0" max="10000000" value="0" onchange="laygia()" step="100000">
                    <input type="range" class="max" id="max" min="0" max="10000000" value="100000000" onchange="laygia()" step="100000">
                </div>
                <div class="row  mt-3 text-center">
                    <div class="col-md-6"><label for="min">Min</label></div>
                    <div class="col-md-6"><label for="max">Max</label></div>
                </div>
                <div class="row">
                    <div class="col-md-6"><input type="text" name="min" id="minne" value="0 đ" disabled></div>
                    <div class="col-md-6"><input type="text" name="max" id="maxne" value="10,000,000 đ" disabled></div>
                </div>
            </div>
        </div>
        <div class="brand mt-2">
            <h1>THƯƠNG HIỆU
                <span id="size-toggle" class="toggle">+</span>
            </h1>

            <form>
                <?php

                $result_brand = $data["list_data"]["list_nhanhieu"];
                foreach ($result_brand as $row) {
                ?>
                    <ul id="size-filter" class="filter-options" class="form_brand">

                        <label>
                            <input type="checkbox" name="brand[]" id="<?php echo $row['id_nh'] ?>" value="<?php echo $row['id_nh'] ?>">
                            <?php echo $row['nhanhieu'] ?>
                        </label>

                    </ul>

                <?php } ?>
            </form>
        </div>
        <div class="size">
            <h1> SIZE
                <span id="size-toggle" class="toggle">+</span>
            </h1>
            <form>
                <?php

                $result_brand = $data["list_data"]["list_size"];
                foreach ($result_brand as $row) {
                ?>
                    <ul id="size-filter" class="filter-options" class="form_brand">

                        <label>
                            <input type="checkbox" name="size[]" id="<?php echo $row['idSize'] ?>" value="<?php echo $row['idSize'] ?>">
                            <?php echo $row['size'] ?>
                        </label>

                    </ul>

                <?php } ?>
            </form>
        </div>
    </div>
    <div class="contact">
        <div class="banner">
            <img src="../uploads/banner.webp" alt="Banner">
        </div>
        <div class="under_banner">
            <div class="text_Sr">
                TẤT CẢ SẢN PHẨM
            </div>
            <div class="sort">
                <label>Sắp xếp theo : </label>
                <div class="select-product">
                    <select id="sapxep" name="sapxep">
                        <option value="giagiam">Giá: Giảm dần</option>
                        <option value="giatang">Giá: Tăng dần</option>
                        <option value="tentang">Tên: A-Z</option>
                        <option value="tengiam">Tên: Z-A</option>
                    </select>
                </div>
                <div class="locsanpham">
                    <div id="icon-selector" class="select_lsp" onclick="showPopup()"><span>Lọc sản phẩm</span></div>
                    <div class="popup-overlay" onclick="hidePopup()"></div>
                    <div class="popup" id="myPopup">
                        <div class="gia" class="unselectable">
                            <h1>GIÁ
                                <span id="size-toggle" class="toggle" class="unselectable">+</span>
                            </h1>
                            <form>
                                <ul id="size-filter" class="filter-options" class="form_gia">
                                    <li>
                                        <input type="radio" name="price" value="all">
                                        Tất cả
                                        </label>
                                    </li>
                                </ul>
                            </form>
                        </div>
                        <div class="brand">
                            <h1>THƯƠNG HIỆU
                                <span id="size-toggle" class="toggle">+</span>
                            </h1>
                            <form>
                                <?php

                                $result_brand = $result_brand = $data["list_data"]["list_nhanhieu"];
                                foreach ($result_brand as $row) {
                                ?>
                                    <ul id="size-filter" class="filter-options" class="form_brand">
                                        <p>
                                            <input type="checkbox" name="brand[]" id="<?php echo $row['id_nh'] ?>" value="<?php echo $row['id_nh'] ?>">
                                            <?php echo $row['nhanhieu'] ?>
                                        </p>
                                    </ul>
                                <?php } ?>
                            </form>
                        </div>
                        <div class="size">
                            <h1> SIZE
                                <span id="size-toggle" class="toggle">+</span>
                            </h1>
                            <form>
                                <?php

                                $result_brand = $result_brand = $data["list_data"]["list_size"];
                                foreach ($result_brand as $row) {
                                ?>
                                    <ul id="size-filter" class="filter-options" class="form_brand">
                                        <p>
                                            <input type="checkbox" name="size[]" id="<?php echo $row['idSize'] ?>" value="<?php echo $row['idSize'] ?>">
                                            <?php echo $row['size'] ?>
                                        </p>
                                    </ul>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section style="background-color: #eee;">
            <div class="container pt-4 ">
                <div class="row" id="product-list">

                    <?php

                    $para = [];
                    if (isset($_GET['nhanhieu'])) {
                        $nhloc = $_GET['nhanhieu'];
                    } else {
                        $nhloc = "";
                    }
                    if (isset($_GET['danhmuc'])) {
                        $dmloc = $_GET['danhmuc'];
                    } else {
                        $dmloc = "";
                    }
                    if (isset($_REQUEST['search'])) {
                        $search = $_REQUEST['search'];
                    } else {
                        $search = "";
                    }

                    // Tạo một mảng chứa các tham số từ $_GET và $_REQUEST
                    $params = array(
                        'page' => 1,
                        'size' => 9,
                        'tenpro' => $search,
                        'idnhStr' => $nhloc,
                        'iddmStr' => $dmloc
                    );

                    // Tạo chuỗi tham số từ mảng
                    $query_string = http_build_query($params);

                    // Địa chỉ URL cần truy cập
                    $url = "http://localhost:8080/api/controller-page/show-product?" . $query_string;

                    // Thực hiện yêu cầu GET đến URL
                    $response = file_get_contents($url);

                    // Kiểm tra lỗi khi thực hiện yêu cầu
                    if ($response === false) {
                        echo 'Lỗi khi gửi yêu cầu.';
                        exit;
                    }

                    // Chuyển đổi chuỗi JSON thành mảng
                    $responseArray = json_decode($response, true);

                    // Kiểm tra xem chuyển đổi có thành công hay không
                    if ($responseArray === null) {
                        echo 'Lỗi khi chuyển đổi JSON thành mảng.';
                    }
                    // print_r($responseArray['data']);




                    $result = $responseArray['data'];
                    foreach ($result as $product) {
                    ?>
                        <div class="col-12 col-md-6 col-lg-4 mb-lg-0" id="box-product" style="margin-bottom: 30px!important;">
                            <div class="card position-relative">
                                <!-- <div class="position-absolute p-2  " style="top:0;left:0; background-color:bisque; color:tomato;">-30%</div>
                                <div class="position-absolute p-2  " style="top:0;right:0; background-color:red; color:white;"> New</div> -->
                                <!-- Giày Cỏ Nhân Tạo (Turf) -->
                                <a href="chitietsp.php?id=<?php echo $product['idPro']; ?>">
                                    <div style="max-width:100%; height:auto;" class="box-body">
                                        <img src="../uploads/<?php echo $product['hinhAnh']; ?>" class="card-img-top img-box-body" alt="">
                                    </div>
                                </a>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <!-- thêm cái danh mục -->
                                        <!-- <p class="small"><a href="#!" class="text-muted"><?php echo $product['idDm'] ?></a></p> -->
                                        <p class="small"><a href="#!" class="text-muted">Giày Cỏ Nhân Tạo (Turf)</a></p>

                                        <p class=""></p>
                                        <p class="small text-danger"><s><?php echo money($product['giaCu']) ?></s></p>
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <a href="chitietsp.php?id=<?php echo $product['idPro']; ?>" style="text-decoration: none;">
                                            <h5 class="text-dark mb-0"><?php echo $product['tenPro'] ?></h5>
                                        </a>
                                        <h5 class="text-dark mb-0"><?php echo money($product['giaMoi']) ?></h5>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <p class="text-muted mb-0">Lượt xem: <span class="fw-bold"><?php echo $product['totalView']; ?></span></p>
                                        <div class="ms-auto text-warning">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>

        </section>

        <nav id="trans_page" aria-label="Page navigation" style="width: 100%; display: flex; justify-content: center; padding-bottom: 20px;">
            <ul class="pagination" id="pagination-ul" name="trang" style="width: 400px; display: flex; justify-content: center; overflow-x: scroll;">
                <?php

                $sotrang = round($responseArray['trans_page'] / 6 + 0.4);
                ?>
                <input type="text" name="page" id="page" value="1" hidden>
                <?php
                for ($i = 1; $i <= $sotrang-1; $i++) {
                    if ($sotrang == 1) {
                        break;
                    }
                ?>
                    <li class="page-item <?php if ($i == 1) echo "active"; ?>"><a class="page-link" onclick="hamcom(<?php echo $i; ?>)"><?php echo $i; ?></a></li>
                <?php
                }
                ?>
            </ul>
        </nav>
    </div>

    <input type="text" id="nhanhieu1" hidden value="<?php if (isset($_GET['nhanhieu'])) {
                                                        echo $_GET['nhanhieu'];
                                                    } ?>">
    <input type="text" id="danhmuc1" hidden value="<?php if (isset($_GET['danhmuc'])) {
                                                        echo $_GET['danhmuc'];
                                                    } ?>">
    <input type="text" id="search1" hidden value="<?php if (isset($_GET['search'])) {
                                                        echo $_GET['search'];
                                                    } ?>">
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Sự kiện left menu +/-
    var toggleButtons = document.querySelectorAll(".toggle");
    toggleButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            var filterOptions = button.parentElement.nextElementSibling;
            if (filterOptions.style.display === "none") {
                filterOptions.style.display = "block";
                button.textContent = "-";
            } else {
                filterOptions.style.display = "none";
                button.textContent = "+";
            }
        });
    });

    // Thêm sự kiện "click" cho toàn bộ trang web để đóng cửa sổ khi người dùng bấm ra ngoài
    function showPopup() {
        document.getElementById("myPopup").style.display = "block";
        document.querySelector('.popup-overlay').style.display = "block";
    }

    function DoiTrang(i) {
        document.getElementById("page").value = i;
    }

    function hamcom(i) {
        var brands = $('input[name="brand[]"]:checked').map(function() {
            return this.id;
        }).get();
        var sizes = $('input[name="size[]"]:checked').map(function() {
            return this.id;
        }).get();
        var min = VNDtoInt($('#minne').val());
        var max = VNDtoInt($('#maxne').val());
        var nhanhieu = $('#nhanhieu1').val();
        var danhmuc = $('#danhmuc1').val();
        var search = $('#search1').val();
        var sapxep = $('#sapxep').val();
        var page = i;

        // Tạo URL cho API
        var apiUrl = 'http://localhost:8080/api/controller-page/show-product?page=' + page +
            '&size=9' +
            '&tenpro=' + search +
            '&idnhStr=' + nhanhieu +
            '&iddmStr=' + danhmuc;


        // Sử dụng AJAX để gọi API
        $.ajax({
            url: apiUrl,
            method: 'GET',
            success: function(response) {
                // Xử lý dữ liệu từ API tại đây
                var data = response.data;

                // Xóa nội dung hiện tại của #product-list
                $('#product-list').html('');

                // Duyệt qua danh sách sản phẩm và thêm chúng vào #product-list
                data.forEach(function(product) {
                    var productHtml = '<div class="col-12 col-md-6 col-lg-4 mb-lg-0" id="box-product" style="margin-bottom: 30px!important;">' +
                        '<div class="card position-relative">' +
                        '<a href="chitietsp.php?id=' + product.idPro + '">' +
                        '<div style="max-width:100%; height:auto;" class="box-body">' +
                        '<img src="../uploads/' + product.hinhAnh + '" class="card-img-top img-box-body" alt="">' +
                        '</div>' +
                        '</a>' +
                        '<div class="card-body">' +
                        '<div class="d-flex justify-content-between">' +
                        '<p class="small"><a href="#!" class="text-muted">' + product.idDm + '</a></p>' +
                        '<p class=""></p>' +
                        '<p class="small text-danger"><s>' + money(product.giaCu) + '</s></p>' +
                        '</div>' +
                        '<div class="d-flex justify-content-between mb-3">' +
                        '<a href="chitietsp.php?id=' + product.idPro + '" style="text-decoration: none;">' +
                        '<h5 class="text-dark mb-0">' + product.tenPro + '</h5>' +
                        '</a>' +
                        '<h5 class="text-dark mb-0">' + money(product.giaMoi) + '</h5>' +
                        '</div>' +
                        '<div class="d-flex justify-content-between mb-2">' +
                        '<p class="text-muted mb-0">Lượt xem: <span class="fw-bold">' + product.totalView + '</span></p>' +
                        '<div class="ms-auto text-warning">' +
                        '<i class="fa fa-star"></i>' +
                        '<i class="fa fa-star"></i>' +
                        '<i class="fa fa-star"></i>' +
                        '<i class="fa fa-star"></i>' +
                        '<i class="fa fa-star"></i>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    // Thêm sản phẩm vào #product-list

                    $('#product-list').append(productHtml);
                    
                });

                $('#trans_page').html('');
                var totalPages = response.trans_page;
                var paginationHtml = '<nav class="trans_page"aria-label="Page navigation" style="width: 100%; display: flex; justify-content: center; padding-bottom: 20px;">' +
                    '<ul class="pagination" id="pagination-ul" name="trang" style="width: 400px; display: flex; justify-content: center; overflow-x: scroll;">';

                for (var j = 1; j <= totalPages / 7 + 0.4; j++) {
                    if (j == i) {
                        paginationHtml += '<li class="page-item active"><a class="page-link" onclick="hamcom(' + j + ')">' + j + '</a></li>';
                    } else {
                        paginationHtml += '<li class="page-item"><a class="page-link" onclick="hamcom(' + j + ')">' + j + '</a></li>';
                    }
                }


                paginationHtml += '</ul></nav>';

                console.log(paginationHtml);

                $('#trans_page').html(paginationHtml);

                if (data == null) {
                        $('#product-list').html('');
                        $('#trans_page').html('');
                    }

            },
            error: function(error) {
                $('#product-list').html('');
                $('#trans_page').html('');
                console.error("bi ngay 1");
                console.error(error);
            }
        });
    }


    function hidePopup() {
        document.getElementById("myPopup").style.display = "none";
        document.querySelector('.popup-overlay').style.display = "none";
    }

    // Hàm chuyển đổi định dạng tiền tệ
    function VNDtoInt(vnd) {
        // Sử dụng regex để loại bỏ ký tự không phải số
        return parseInt(vnd.replace(/[^0-9]/g, ''));
    }

    // jQuery

    //sử lý database sai thiếu nên thêm mấy cái vô
    $(document).ready(function() {
        $('input[name="brand[]"], input[name="size[]"], .min, .max , .sapxep , #sapxep').click(function() {
            var brands = $('input[name="brand[]"]:checked').map(function() {
                return this.id;
            }).get();
            var sizes = $('input[name="size[]"]:checked').map(function() {
                return this.id;
            }).get();
            var min = VNDtoInt($('#minne').val());
            var max = VNDtoInt($('#maxne').val());
            var search = $('#search1').val();
            var sapxep = $('#sapxep').val();
            var page = 1;

            // Tạo URL cho API
            var apiUrl = 'http://localhost:8080/api/controller-page/search?page=' + page +
                '&size=9' +
                '&sapxep=' + sapxep +
                '&minne=' + min +
                '&maxne=' + max +
                '&checkbox_brand=' + brands +
                '&checkbox_size=' + sizes;

            // Sử dụng AJAX để gọi API
            $.ajax({
                url: apiUrl,
                method: 'GET',
                success: function(response) {
                    // Xử lý dữ liệu từ API tại đây
                    var data = response.data;

                    // Xóa nội dung hiện tại của #product-list
                    $('#product-list').html('');

                    // Duyệt qua danh sách sản phẩm và thêm chúng vào #product-list
                    data.forEach(function(product) {
                        var productHtml = '<div class="col-12 col-md-6 col-lg-4 mb-lg-0" id="box-product" style="margin-bottom: 30px!important;">' +
                            '<div class="card position-relative">' +
                            '<a href="chitietsp.php?id=' + product.idPro + '">' +
                            '<div style="max-width:100%; height:auto;" class="box-body">' +
                            '<img src="../uploads/' + product.hinhAnh + '" class="card-img-top img-box-body" alt="">' +
                            '</div>' +
                            '</a>' +
                            '<div class="card-body">' +
                            '<div class="d-flex justify-content-between">' +
                            '<p class="small"><a href="#!" class="text-muted">' + product.idDm + '</a></p>' +
                            '<p class=""></p>' +
                            '<p class="small text-danger"><s>' + money(product.giaCu) + '</s></p>' +
                            '</div>' +
                            '<div class="d-flex justify-content-between mb-3">' +
                            '<a href="chitietsp.php?id=' + product.idPro + '" style="text-decoration: none;">' +
                            '<h5 class="text-dark mb-0">' + product.tenPro + '</h5>' +
                            '</a>' +
                            '<h5 class="text-dark mb-0">' + money(product.giaMoi) + '</h5>' +
                            '</div>' +
                            '<div class="d-flex justify-content-between mb-2">' +
                            '<p class="text-muted mb-0">Lượt xem: <span class="fw-bold">' + product.totalView + '</span></p>' +
                            '<div class="ms-auto text-warning">' +
                            '<i class="fa fa-star"></i>' +
                            '<i class="fa fa-star"></i>' +
                            '<i class="fa fa-star"></i>' +
                            '<i class="fa fa-star"></i>' +
                            '<i class="fa fa-star"></i>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                        // Thêm sản phẩm vào #product-list

                        $('#product-list').append(productHtml);
                    });
                    if (data == null) {
                        $('#product-list').html('');
                        $('#trans_page').html('');
                    }

                    $('#trans_page').html('');
                },
                error: function(error) {
                    console.error("bi ngay 2");
                    $('#product-list').html('');
                    $('#trans_page').html('');
                    console.error(error);
                }
            });
        });
    });




    // Thêm sự kiện "click" cho các nút trang
    $('.page-link').click(function() {
        var page = $(this).text();
        hamcom(page);
    });


    function money(number) {
        // Định dạng số thành tiền tệ (VND)
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(number);
    }
</script>