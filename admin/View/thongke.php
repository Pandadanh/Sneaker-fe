<section class="content-header">
    <div class="content-header-left">
        <h1>Thống kê</h1>
    </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<section class="content" onload="show(1)">
    <div class="row">
        <div class="col-md-12" style="overflow-x: scroll;">
            <div class="box box-info" style="width: 1550px">
                <div class="box-body">
                    <div class="wrap col-md-12">


                        <?php

                        $apiUrl = 'http://localhost:8080/api-admin/controller-product/show-dm-nh';
                        $ch = curl_init($apiUrl);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $response = curl_exec($ch);

                        curl_close($ch);

                        if ($response === false) {
                            die('CURL Error: ' . curl_error($ch));
                        }
                        if ($response) {
                            $data = json_decode($response, true);

                            if ($data === null) {
                                die('Invalid JSON data');
                            }
                        }
                        ?>


                        <form>
                            <div class="col-md-12" style="margin-top: 10px; margin-bottom: 10px; width: 1530px;">
                                Nhãn hiệu
                                <select name="nhanhieu" id="nhanhieu" style="height: 25px; margin-right: 50px;">
                                    <option value="">Tất cả</option>
                                    <?php

                                    $result = $data['list_data']['list_nhanhieu'];
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['id_nh'] ?>"><?php echo $row['nhanhieu'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                Danh Mục
                                <select name="nhanhieu" id="danhmuc" style="height: 25px; margin-right: 50px;">
                                    <option value="">Tất cả</option>
                                    <?php

                                    $result = $data['list_data']['list_danhmuc'];
                                    foreach ($result as $row) {
                                    ?>
                                        <option value="<?php echo $row['idDm'] ?>"><?php echo $row['danhMuc'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                Từ ngày <input type="date" name="" id="ngaymin" value="2020-01-01">
                                đến ngày <input type="date" name="" id="ngaymax" value="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" style="margin-right: 50px;">
                                Số dòng / Trang <input type="number" id="sodong" min="1" value="5" style="height: 25px; width: 50px; margin-right: 50px;">
                                Top<input type="number" id="topsp" style="width: 50px; margin-left:10px;margin-right: 10px;"> sản phẩm bán chạy
                                <input type="button" value="Tìm" class="" onclick="show(1)" style="margin-left: 15px;">
                            </div>
                        </form>
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th class="col-md-1 text-center">ID Sản phẩm</th>
                                    <th class="col-md-4 text-center">Tên sản phẩm</th>
                                    <th class="col-md-2 text-center">Số lượng đã bán</th>
                                    <th class="col-md-2 text-center">Doanh thu</th>
                                    <th class="col-md-2 text-center">Còn lại</th>
                                </tr>
                            </thead>
                            <tbody id="dulieu">

                            </tbody>
                        </table>
                        <nav aria-label="Page navigation " style="width: 100%; display: flex; justify-content: center; padding-bottom: 20px;">

                            <ul class="pagination mt-3 row " id="trang" style="width: 400px; display: flex; justify-content: center; overflow-x: scroll;">
                            </ul>

                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
</section>

<script defer>
    function show(p) {
        var sodong = document.getElementById("sodong").value;
        if (sodong < 1) {
            alert("Số dòng không hợp lệ");
            document.getElementById("sodong").value = 5;
            return;
        }
        var id_nh = document.getElementById("nhanhieu").value;
        var id_dm = document.getElementById("danhmuc").value;
        var ngaymin = document.getElementById("ngaymin").value;
        var ngaymax = document.getElementById("ngaymax").value;
        var topsp = document.getElementById("topsp").value;
        if (topsp < 0) {
            alert("Số dòng không hợp lệ");
            document.getElementById("topsp").value = 5;
            return;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var inra = this.responseText.split("???");
                document.getElementById("dulieu").innerHTML = inra[0];
                document.getElementById("trang").innerHTML = inra[1];
            }
        }
        xmlhttp.open("GET", "../Controllers/controller_thongke/controller_thongke-pt-tk.php?p=" + p + "&id_nh=" + id_nh + "&id_dm=" + id_dm + "&ngaymin=" + ngaymin + "&ngaymax=" + ngaymax + "&topsp=" + topsp + "&sodong=" + sodong, true);
        xmlhttp.send();
    }
    window.onload = show(1);
</script>