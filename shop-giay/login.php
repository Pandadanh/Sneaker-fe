<script defer>
    function resetdn() {
        document.getElementById('ttdn').innerHTML = '  <img src="../uploads/" alt="" style="width:50px">'
    }
    window.onload = resetdn();


    if (document.getElementById("form-message-error").textContent !== "") {
        alert(document.getElementById("form-message-error").textContent);
    }
    // Kiểm tra nếu có thông báo thành công thì hiển thị
    if (document.getElementById("form-message-success").textContent !== "") {
        alert(document.getElementById("form-message-success").textContent);
    }

    setTimeout(function() {
        // Sử dụng AJAX để gửi yêu cầu đặt giá trị $_SESSION["ERROR"] thành 1
        var xhr = new XMLHttpRequest();

        xhr.open("POST", "./controllers/set_error_session.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("error=1");
    }, 3000);

    setTimeout(function() {
        // Hiển thị các thông báo sau 2 giây
        document.getElementById("form-message-error").style.display = "none";
        document.getElementById("form-message-success").style.display = "none";
    }, 2000); // 2 giây
</script>
<style>
    .form-group label {
        font-weight: 500;
    }

    .form-group.invalid .form-control {
        border-color: #f33a58;
    }

    .form-group.invalid .form-message {
        color: #f33a58;
        font-size: 17px;
    }

    .convert-sign-up a:hover,
    .forgot-password:hover {
        color: crimson;
        text-decoration: none;
    }

    .sub-form {
        position: relative;
    }

    .icon-eye {
        position: absolute;
        right: 20px;
        bottom: 6px;
        padding: 3px;
        z-index: 1;
    }

    .icon-eye:hover {
        cursor: pointer;
    }


    #form-message-error {
        color: red;
        text-align: center;
        font-size: 23px;
        font-weight: 600;
        display: block;
    }

    #form-message-success {
        color: #3ae374;
        text-align: center;
        font-size: 23px;
        font-weight: 600;
        display: block;
    }
</style>

<div id="content" class="pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto">
                <h1 class="text-center">Đăng nhập</h1>
                <form method="POST" class="form" id="form-2" action="controllers/controller_login.php">
                    <div class="form-group form-group-email">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" placeholder="Email" />
                        <small class="form-message-email form-message"></small>
                    </div>
                    <div class="form-group form-group-password">
                        <label for="password">Mật khẩu</label>
                        <div class="sub-form">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu" />
                            <i class="fa-solid fa-eye icon-eye"></i>
                        </div>
                        <small class="form-message-password form-message"></small>
                    </div>
                    <input type="submit" name="submit-login" id="submit-login" class="btn btn-info w-100 mt-4 mb-2" value="Đăng nhập">


                    <?php
                    if (isset($_SESSION["error"])) {
                        if (isset($_SESSION["error"])) {
                            // Kiểm tra nếu $_SESSION["error"] tồn tại
                            if ($_SESSION["error"] === "") {
                            } else if (($_SESSION["ERROR"]) == 2) {

                                echo '<small id="form-message-error">' . $_SESSION["error"] . '</small>';
                            }
                        } else {
                            // Nếu $_SESSION["error"] không tồn tại, gán một giá trị mặc định
                            $_SESSION["error"] = "";
                        }
                    } else if (isset($_SESSION["success"])) {
                        // Kiểm tra nếu $_SESSION["success"] tồn tại
                        if ($_SESSION["success"] === "") {
                            // Nếu $_SESSION["success"] rỗng thì không hiển thị gì cả
                        } else {
                            // Hiển thị thông báo thành công
                            echo '<small id="form-message-success">' . $_SESSION["success"] . '</small>';
                        }
                    } else {
                        // Nếu $_SESSION["success"] không tồn tại, gán một giá trị mặc định
                        $_SESSION["success"] = "";
                    }
                    ?>
                    <script>
                        // Đợi 2 giây rồi hiển thị chúng
                        setTimeout(function() {
                            // Hiển thị các thông báo sau 2 giây
                            document.getElementById("form-message-error").style.display = "none";
                            document.getElementById("form-message-success").style.display = "none";
                        }, 2000); // 2 giây


                        setTimeout(function() {
                            // Sử dụng AJAX để gửi yêu cầu đặt giá trị $_SESSION["ERROR"] thành 1
                            var xhr = new XMLHttpRequest();

                            xhr.open("POST", "./controllers/set_error_session.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhr.send("error=1");
                        }, 3000);
                    </script>


                    <a class="forgot-password mt-1 d-block" href="index.php?page=forgot-pass">Quên mật khẩu?</a>
                    <div class="convert-sign-up">
                        <span>Bạn chưa có tài khoản?</span>
                        <a href="index.php?page=sign-up">Đăng ký</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>