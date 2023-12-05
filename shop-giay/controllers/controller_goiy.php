<style>
    .row.hienThiGoiY {
        width: 100%;
        margin-left: 0;
        border-bottom: 1px solid black;
        padding: 10px 0;
    }

    .row.hienThiGoiY:last-child {
        margin-bottom: 0px;
    }

    .row.hienThiGoiY:hover {
        background: rgb(200, 300, 300);
        border-bottom: 1px solid black;
    }


    img {
        max-width: 100%;
    }
</style>
<?php

if (!function_exists('money')) {
    function money($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', ',') . "{$suffix}";
        }
    }
}
if (isset($_REQUEST['search'])) {

    $apiUrl = 'http://localhost:8080/api/controller-page/search-goi-y/' . $_REQUEST['search'];
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    $result =  $data['data'];

}
// print_r( $result);
foreach ($result as $row) {

    $apiUrl = 'http://localhost:8080/api/controller-page/search-iddm-idnh/' .$row['danhmuc']['idDm'] ."/".$row['nhanhieu']['id_nh'] ;
    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);

    if ($_REQUEST['search'] == "") {
        echo "";
        break;
    }
?>
    <div class="row hienThiGoiY">
        <div class="col-md-3"><img src="../uploads/<?php echo $row['hinhAnh'] ?>" alt=""></div>
        <div class="col-md-9 d-block">
            <div>
                <a href="chitietsp.php?id=<?php echo $row['idPro']; ?>">
                    <h5 style="color: #0288d9;"><?php echo $row["tenPro"] ?></h5>
                </a>
            </div>
            <div class="row d-flex my-2">
                <div style="margin: 0 18px;"><?php echo $data['data']['danhmuc']['danhMuc']; ?></div>
                <div><?php echo $data['data']['nhanhieu']['nhanhieu']; ?></div>
            </div>
            <div class="row d-flex " style="margin-left:10px; align-items:center;">
                <div style="margin-right:20px; color: #0288d9; font-weight: bold; font-size:larger;"><?php echo money($row["giaMoi"]) ?></div>
                <div><del><?php echo money($row["giaCu"]) ?></del></div>
            </div>
        </div>
    </div>
<?php
}
?>