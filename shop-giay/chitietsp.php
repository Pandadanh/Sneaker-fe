<?php
require_once("header.php");

function money($number, $suffix = 'đ')
{
    if (!empty($number)) {
        return number_format($number, 0, ',', ',') . "{$suffix}";
    }
}
$idPro = $_GET['id'] ?? null;
if ($idPro === null || !is_numeric($idPro)) {
    header('Location: index.php?page=home');
    exit; // Dừng việc xử lý tiếp
}   


$apiUrl = 'http://localhost:8080/api/controller-page/chitietsp/' . $idPro;
$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

$product = $data['list_data']['product'][0];


if (!$product) {
    header('Location: index.php?page=home');
    exit; // Dừng việc xử lý tiếp
}


$danhmuc = $data['list_data']['danhmuc'][0];
$brand = $data['list_data']['nhanhieu'][0];
$products_size = $data['list_data']['list_size'];

$id_size =  $_GET['size_chon'] ?? null;
if (isset($_POST['product_id'])) {
    $quantity_temp = $_REQUEST["quantity_temp"];
    $tensizechon = $_REQUEST["size_chon"];
    $id_size = $_REQUEST["id_size"];

    if (isset($_SESSION['cart'])) {
        $array = $_SESSION['cart'];
    } else {
        $array = array();
    }

    $co = 0;

    foreach ($array as $index => $spgh) {
        if ($spgh['idPro'] == $_POST['product_id'] && $spgh['id_size'] == $id_size) {
            $array[$index]['soluong'] += $quantity_temp;
            $co = 1;
            $_SESSION['cart'] = $array; // Cập nhật giỏ hàng
            break; // Kết thúc vòng lặp sau khi tìm thấy sản phẩm
        }
    }

    if ($co == 0) {
        $product = array(
            'idPro' => $product['idPro'],
            'tenPro' => $product['tenPro'],
            'size' => $tensizechon,
            'id_size' => $id_size,
            'soluong' => $quantity_temp,
            'hinhAnh' => $product['hinhAnh'],
            'giaMoi' => $product['giaMoi'],
        );

        $_SESSION['cart'][] = $product; // Thêm sản phẩm mới vào giỏ hàng
    }

    echo "<meta http-equiv='refresh' content='0'>";
    echo "<script type='text/javascript'>alert('Đã thêm vào giỏ hàng');</script>";
}

?>

<style>
    .container{
        padding-top: 40px;

    }
</style>

<div id="wrapper">
    <div id="content">
        <div class="container" >
            <div class="row">
                <div class="col-md-6">
                    <img src="../uploads/<?php echo $product['hinhAnh'] ?>" alt="" />
                </div>
                <div class="col-md-6 mt-xl-5">
                    <div class="product-info d-flex">
                        <h2><?php echo $product['tenPro']; ?></h2>
                        <div class="product-info-more my-2">
                            <span class="type">Loại: <strong><?php echo $danhmuc['danhMuc']; ?></strong></span>
                            <span>Nhãn hiệu: <strong><?php echo $brand['nhanhieu']; ?></strong></span>
                        </div>
                        <div class="price">
                            <span class="price-new mr-3"><?php echo money($product['giaMoi']); ?></span>
                            <span class="price-old"><?php echo money($product['giaCu']); ?></span>
                        </div>
                        <div class="size my-2">
                            <span>Size</span>
                        </div>
                        <div>
                            <ul class="d-flex">
                                <?php $sizechon = isset($_GET['sizechon']) ? $_GET['sizechon'] : null; ?>


                                <?php foreach ($products_size as $size) : ?>
                                    <li class="mr-2">
                                        <form method="get" action="chitietsp.php">
                                            <input type="hidden" name="id" value="<?php echo $idPro; ?>">
                                           
                                            <input type="hidden" name="tensize" value="<?php echo $size['size']; ?>">
                                            <button type="submit" name="sizechon" value="<?php echo $size['idSize']; ?>" class="btn <?php echo ($sizechon == $size['idSize']) ? 'btn-info' : 'btn-secondary'; ?>">
                                                <?php echo $size['size']; ?>
                                            </button>
                                        </form>
                                    </li>

                                <?php endforeach; ?>

                            </ul>
                        </div>
                        <div class="amount mt-3">
                            <div class="d-flex justify-content-between">
                                <div class="product-button">
                                    <div class="exchange"></div>
                                    <form method="post" action="chitietsp.php?id=<?php echo $product['idPro']; ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $product['idPro']; ?>">

                                        <?php $sizechon = isset($_GET['sizechon']) ? $_GET['sizechon'] : null; ?>
                                        <input type="hidden" name="id_size" value="<?php echo $sizechon; ?>">

                                        <?php $tensize = isset($_GET['tensize']) ? $_GET['tensize'] : null; ?>
                                        <input type="hidden" name="size_chon" value="<?php echo $tensize; ?>">

                                        <div class="mb-3 mt-3 ml-4">
                                            <span class="quantity-btn minus ml-5 " onclick="TangGiamSL(-1)"><img src="../uploads/minus.jpg" style="width:40px ;"></span>
                                            <input type="text" style="width: 40px; text-align:center;" id="soluong" name="quantity_temp" min="0" value="1" readonly>
                                            <span class="quantity-btn plus" onclick="TangGiamSL(1)"><img src="../uploads/add.jpg" style="width:40px ;"></span>
                                        </div>
                                        <button type="submit" class="btn btn-info ml-2" <?php if (!isset($_REQUEST['sizechon'])) {
                                                                                            echo "disabled";
                                                                                        } ?>>Thêm vào giỏ</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="product-detail" class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Mô tả sản phẩm</h2>
                    <p><?php echo $product['moTa']; ?></p>
                </div>
            </div>
        </div>
        <div class="related-products">
            <div class="container text-center">
                <h3 class="my-4">Sản phẩm liên quan</h3>
                <div class="row">
                    <?php
                   
                    $product_dm = $data['list_data']['list_product_danhmuc'];
                    foreach ($product_dm as $sp) {
                    ?>
                        <div class="col-md-3 col-sm-6 col-6 mb-4">
                            <a href="chitietsp.php?id=<?php echo $sp['idPro']; ?>" class="img-box-body">
                                <img src="../uploads/<?php echo $sp['hinhAnh'] ?>" alt="" />
                            </a>
                            <a href="chitietsp.php?id=<?php echo $sp['idPro']; ?>" class="name-type name-box-body text-justify" style="color:blue; font-weight: bold;">
                                <?php echo $sp['tenPro']; ?>
                            </a>
                            <span class="price-box-body d-block text-center text-danger"><?php echo money($sp['giaMoi']); ?></span>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once("footer.php"); ?>

<script>
    function TangGiamSL(sl) {
        <?php

        $size_api = $_GET['sizechon'] ?? null;

        $apiUrl = 'http://localhost:8080/api/controller-page/chitietsp/' . $idPro . '/' . $sizechon;
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);
        $max = $data['data'];

        ?>
        var ht = document.getElementById("soluong").value;
        var max = <?php echo json_encode($max); ?>;
        if (ht * 1 + sl * 1 > max) {
            alert("Đã tới giới hạn trong kho");
            return;
        }
        if (ht * 1 + sl * 1 > 0) {
            document.getElementById("soluong").value = ht * 1 + sl * 1;
        }
    }
</script>