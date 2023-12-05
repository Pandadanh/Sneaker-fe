<?php
if (isset($_GET['doitt'])) {
    echo "vo";
}
include("../../Control/inc/config.php");




$sodong = $_GET['sodong'];
$search = $_GET['search'];
$trangthaihd = $_GET['trangthaihd'];
$loaitk = $_GET['loaitk'];

$p = isset($_GET['p']) ? $_GET['p'] : 1; // Trang hiện tại, mặc định là 1

$params = array(
    'page' => $p,
    'size' => $sodong,
    'search' => $search,
    'trangthaihd' => $trangthaihd
);

$query_string = http_build_query($params);

$url = "http://localhost:8080/api-admin/controller-user-admin/search?" . $query_string;

$response = file_get_contents($url);

if ($response === false) {
    echo 'Lỗi khi gửi yêu cầu.';
    exit;
}
$responseArray = json_decode($response, true);

if ($responseArray === null) {
    // echo 'Lỗi khi chuyển đổi JSON thành mảng.';
    exit;
}
$result = $responseArray['data'];

$sotrang = round($responseArray['trans_page'] / $sodong + 0.4);

// print_r($result);
foreach ($result as $row) {
?>
    <tr class="dong " style="background-color:<?php if ($row['trangThai'] == 1)
                                                    echo "#c44b69";
                                                else
                                                    echo "#71f593";
                                                ?>; color:black;">
        <td><?php echo $row['idUser']; ?></td>
        <td>
            <div class="row" style="text-align: left;">
                <div class="col-md-3"><img src="../../uploads/<?php echo $row['avatar']; ?>" width="100px" height="100px" style="border-radius: 100%;" alt=""></div>
                <div class="col-md-1"></div>
                <div class="col-md-8">
                    <b>Tên: </b><?php echo $row['tenUser']; ?> <br>
                    <b>Email: </b><?php echo $row['email']; ?> <br>
                    <b>Số điện thoại: </b><?php echo $row['soDienThoai']; ?>
                </div>

            </div>

        </td>
        <td style="text-align: left; padding-left:30px;">
            <b>Tài khoản: </b> <?php echo $row['email']; ?> <br>
            <b>Mật khẩu: </b> <?php echo $row['matKhau']; ?>
        </td>
        <td>

            <?php
            ?>
            <select id="nhomquyen<?php echo $row['idUser']; ?>" style="height: 25px;" onchange="doicv(<?php echo $row['idUser']; ?>)">
                <?php
                $apiUrl = 'http://localhost:8080/api-admin/controller-nhomquyen/show';
                $curl = curl_init($apiUrl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);
                curl_close($curl);
                $data = json_decode($response, true);
                $result1 = $data['data'];
                foreach ($result1 as $row1) {
                ?>
                    <option <?php if ($row1['nhomquyen'] == $row['nhomQuyen']['nhomquyen']) echo "selected" ?> value="<?php echo $row1['nhomquyen']; ?>"><?php echo $row1['nhomquyen']; ?></option>
                <?php
                }
                if ($row["id_loaitk"] == 1) {
                ?>
                    <option selected> Khách Hàng</option>
                <?php
                }
                ?>
            </select>
        </td>
        <td>
            <button onclick="doitt(<?php echo $row['idUser']; ?>)"><?php if ($row['trangThai'] == 0)
                                                                        echo "Hoạt động";
                                                                    else echo "Bị khóa";
                                                                    ?></button>
        </td>
        <td>
            <a href="../View/taikhoan-delete.php?id=<?php echo $row['idUser']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Bạn có muốn xóa không')">Delete</a>
        </td>
    </tr>

<?php

}
echo "???";
?>
<?php
for ($i = 1; $i <= $sotrang; $i++) {
    if ($sotrang == 1) {
        break;
    }
?>
    <li class="page-item <?php if ($p == $i) echo "active"; ?>"><a class="page-link" onclick="show(<?php echo $i; ?>)"><?php echo $i; ?></php></a></li>
<?php

}

?>