<?php
if (isset($_POST['clear'])) {
    $_SESSION['cart'] = array();
}
$tong_tien = 0;
if (isset($_POST['xoa'])) {
    $id_xoa = $_POST['id_xoa'];
    $size_xoa = $_POST['size_xoa'];
    $array = $_SESSION['cart'];
    foreach ($array as $key => $spnh) {
        if ($spnh['idPro'] == $id_xoa) {
            unset($array[$key]);
            break;
        }
    }
    
    $_SESSION['cart'] = $array;
    echo "<script type='text/javascript'>alert('Đã xóa');</script>";
}
// print_r($_SESSION["user1"]['data']);
// print_r( $_SESSION['cart']);
// print_r($_SESSION);
if (isset($_POST['thanhtoan'])) {
    $valid = 1;
    if (!isset($_SESSION["user1"])) {
        $valid = 0;
        echo "<script type='text/javascript'>alert('Bạn chưa đăng nhập'); window.location.href = 'index.php?page=login';</script>";
        die();

    }
    if (count($_SESSION["cart"]) == 0) {
        $valid = 0;
        echo "<script type='text/javascript'>alert('Giỏ hàng trống');</script>";
        echo "<script type='text/javascript'>alert('Bạn chưa đăng nhập'); window.location.href = 'index.php?page=product';</script>";
    }
    $error_out = "";
    foreach ($_SESSION['cart'] as  &$spnh) {

      $apiUrl = 'http://localhost:8080/api/controller-page/chitietsp/' . $spnh['idPro'] . '/' . $spnh['id_size'];

        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($response, true);
    //   print_r($_SESSION);
        $soluongtemp = $data['data'];
        if ($spnh['soluong'] > $soluongtemp) {
            $error_out .= $spnh['tenPro'] . "  size : " .  $spnh['size'] . "\\n"; 
            $spnh['soluong'] =  $soluongtemp;
            $valid = 0;
        }
    }

    if ($valid === 0) {
        echo "<script type='text/javascript'>alert('Sản phẩm đã vượt quá số lượng trong kho \\n" .  $error_out ."');</script>";
        echo "<script type='text/javascript'>alert('Set lại sản phẩm vượt quá ');</script>";
    }
   
   


    if ($valid == 1) {
        // Chuẩn bị dữ liệu để gửi đến API
        $data = [
            'idUser' => $_SESSION["user1"]['data']["idUser"],
            'tongtien' => $_POST['tongtien'],
            'tongsl' => $_POST['tongsl'],
            'cart' => $_SESSION['cart'] // Dữ liệu giỏ hàng
        ];
        // print_r($data);
    
        // Gửi yêu cầu POST đến API
        $apiUrl = 'http://localhost:8080/api/controller-giohang/create-phieu-xuat'; // Thay đổi thành URL của API của bạn
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Thực hiện yêu cầu cURL
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
        // Kiểm tra và xử lý kết quả từ API
        if ($httpCode == 200) {
            echo "<script type='text/javascript'>alert('Mua hàng thành công');</script>";
            $_SESSION['cart'] = array(); // Xóa giỏ hàng sau khi mua thành công
        } else {
            echo "<script type='text/javascript'>alert('Mua hàng không thành công.');</script>";
          
        }
    
        // Đóng phiên cURL
        curl_close($ch);
    }
}

// print_r($_SESSION);
?>

<body>
    <style>
        @media (min-width: 1200px) {
            .container {
                max-width: 1850px;
                padding: 0px 50px;
            }
        }

        @media (max-width: 768px) {
            .cart {
                display: none;
            }
        }
    </style>
    <h2 class="text-center mt-3 mb-3">SẢN PHẨM TRONG GIỎ HÀNG</h2>
    <div class="container">
        <div class="row">
            <div class="cart col-xl-8 border col-md-12 mb-md-4">
                <div class="cart-title row shadow border py-1">
                    <div class="col-md-1 text-center p-1">Mã SP</div>
                    <div class="col-md-2 text-center p-1">Hình Ảnh</div>
                    <div class="col-md-3 text-center p-1">Tên SP</div>
                    <div class="col-md-1 text-center p-1">Size</div>
                    <div class="col-md-1 text-center p-1">Giá</div>
                    <div class="col-md-3 text-center p-1">Số lượng</div>
                    <div class="col-md-1 text-center p-1">Hành động</div>
                </div>
                <?php
                // print_r($_SESSION);
                // exit;
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $row) {
                ?>
                        <div class="cart-body row mt-2 border shadow text-center d-flex align-items-center py-2">
                            <div class="col-md-1"><?php echo $row['idPro'] ?></div>
                            <div class="col-md-2"> <img src="../uploads/<?php echo $row['hinhAnh'] ?>" alt="" /></div>
                            <div class="col-md-3 text-left"><?php echo $row['tenPro'] ?></div>
                            <div class="col-md-1"><?php echo $row['size'] ?></div>
                            <div class="col-md-1 text-left"><?php echo money($row['giaMoi']) ?></div>
                            <div class="col-md-3 mx-auto">
                                <div class="row d-flex justify-content-center">
                                    <span class="quantity-btn minus" onclick="TangGiamSL(<?php echo $row['idPro'] + $row['size'] ?>,-1),show(<?php echo $row['idPro'] ?>, <?php echo $row['size'] ?>,-1)"><img src="../uploads/minus.jpg" style="width:70%;"></span>
                                    <input type="text" style="width: 20%; text-align:center" id="<?php echo $row['idPro'] + $row['size'] ?>" name="quantity_temp" min="0" value="<?php echo $row['soluong'] ?>" readonly>
                                    <span class="quantity-btn plus" onclick="TangGiamSL(<?php echo $row['idPro'] + $row['size'] ?>,1),show(<?php echo $row['idPro'] ?>, <?php echo $row['size'] ?>,1)"><img src="../uploads/add.jpg" style="width: 70% ;"></span>
                                </div>
                            </div>
                            <form method="POST">
                                <input type="text" name="id_xoa" hidden value="<?php echo $row['idPro'] ?>">
                                <input type="text" name="size_xoa" hidden value="<?php echo $row['size'] ?>">
                                <button name="xoa" onclick="return confirm('Bạn có muốn xóa không')" class="btn btn-danger">Xóa</button>
                            </form>
                        </div>
                <?php
                    }
                    if (count($_SESSION["cart"]) == 0) {
                        echo '<h4 class="text-center mt-4">GIỎ HÀNG CỦA BẠN ĐANG TRỐNG</h4>';
                    }
                } else {
                    echo '<h4 class="text-center mt-4">GIỎ HÀNG CỦA BẠN ĐANG TRỐNG</h4>';
                }
                ?>
            </div>
            <div class="col-xl-4 col-md-12">
                <div class="row">
                    <div class="col-xl-1"></div>
                    <?php
                    // print_r($_SESSION);
                    if (isset($_SESSION["user1"])) {
                        $ten_user = $_SESSION['user1']['data']['tenUser'];
                        $sodth = $_SESSION['user1']['data']['soDienThoai'];
                        $email = $_SESSION['user1']['data']['email'];
                        $diachi = $_SESSION['user1']['data']['diaChi'];
                    } else {
                        $ten_user = "";
                        $sodth = "";
                        $email = "";
                        $diachi = "";
                    }
                    $tong_tien = 0;
                    $tongsl = 0;
                    if (isset($_SESSION["cart"])) {
                        foreach ($_SESSION["cart"] as $row) {
                            $tongsl += $row['soluong'];
                            $tong_tien += $row['giaMoi'] * $row['soluong'];
                        }
                    }
                    ?>
                    <div class="col-xl-11 col-md-12 border shadow py-3 px-4">
                        <h4 class="text-center mt-2"><strong>Thông tin thanh toán</strong></h4>
                        <div class="row">
                            <h5 class="col-md-4 text-right">Họ tên:</h5>
                            <h5 class="col-md-8"><strong><?php echo $ten_user ?></strong></h5>
                        </div>
                        <div class="row">
                            <h5 class="col-md-4 text-right">Số điện thoại:</h5>
                            <h5 class="col-md-8"><strong><?php echo $sodth ?></h5>
                        </div>
                        <div class="row">
                            <h5 class="col-md-4 text-right">Email:</h5>
                            <h5 class="col-md-8"><strong><?php echo $email ?></strong></h5>
                        </div>
                        <div class="row">
                            <h5 class="col-md-4 text-right">Địa chỉ:</h5>
                            <h5 class="col-md-8"><strong><?php echo $diachi ?></strong></h5>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-7">
                                <h4>Tổng tiền: <strong id="tongTien"><?php echo money($tong_tien) ?></strong></h4>
                            </div>
                            <div class="col-md-5">
                                <h4>Số lượng: <strong id="tongSoLuong"><?php echo $tongsl ?></strong></h4>
                            </div>
                        </div>

                        <div class="row mt-3 d-flex justify-content-between">
                            <form method="post">
                                <input type="text" name="tongtien" hidden value="<?php echo $tong_tien ?>">
                                <input type="text" name="tongsl" hidden value="<?php echo $tongsl ?>">
                                <input type="submit" class="btn btn-success" name="thanhtoan" value="Thanh Toán">
                                <input type="submit" name="clear" onclick="return confirm('Bạn có muốn xóa hết không')" value="Xóa danh sách" class="btn btn-danger" style="font-size: 1rem!important;"></input>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    function TangGiamSL(phantu, sl) {
        var ht = document.getElementById(phantu).value;
        if (ht * 1 + sl * 1 > 0) {
            document.getElementById(phantu).value = ht * 1 + sl * 1;
        }
    }

    function show(id_pro, size, soluong) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var inra = this.responseText.split("???");
                document.getElementById("tongTien").innerText = inra[0];
                document.getElementById("tongSoLuong").innerText = inra[1];
                document.getElementById("soluongGH").innerText = inra[1];


            }
        }
        xmlhttp.open("GET", "update_quantity_temp.php?id_pro=" + id_pro + "&size=" + size + "&soluong=" + soluong, true);
        xmlhttp.send();
    }
</script>