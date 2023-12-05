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

    .sign-up:hover,
    .login:hover,
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

    #reset-token {
        display: none;
    }
</style>
<?php
$reset_token = $_GET['reset_token'];
?>
<div id="content" class="pt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 m-auto">
                <h1 class="text-center">Khôi phục mật khẩu</h1>
                <form class="form" id="form-reset-pass">
                    <div class="form-group form-group-password">
                        <label for="password">Mật khẩu mới</label>
                        <div class="sub-form">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu" />
                            <i class="fa-solid fa-eye icon-eye"></i>
                        </div>
                        <small class="form-message-password form-message"></small>
                    </div>
                    <div class="form-group form-group-password-confirm">
                        <label for="password-confirm">Nhập lại mật khẩu</label>
                        <div class="sub-form">
                            <input type="password" name="password-confirm" id="password-confirm" class="form-control" placeholder="Mật khẩu" />
                            <i class="fa-solid fa-eye icon-eye"></i>
                        </div>
                        <small class="form-message-password-confirm form-message"></small>
                    </div>
                    <input type="submit" name="btn-reset-pass" id="btn-reset-pass" class="btn btn-info w-100 mt-4 mb-2" value="Lưu mật khẩu">
                    <small id="form-message-error"></small>
                    <small id="form-message-success"></small>
                    <input type="hidden" name="reset-token" id="reset-token" value="<?php echo $reset_token; ?>"></input>
                    <div>
                        <span>Quay lại trang</span>
                        <a href="index.php?page=login" class="login">Đăng nhập</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".icon-eye").click(function() {
            $(this).toggleClass("fa-eye-slash");
            $(this).toggleClass("fa-eye");
            if ($(this).hasClass("fa-eye-slash")) {
                $(this).prev("#password").attr('type', 'text');
                $(this).prev("#password-confirm").attr('type', 'text');
            } else {
                $(this).prev("#password").attr('type', 'password');
                $(this).prev("#password-confirm").attr('type', 'password');
            }
            var reset_token = $("#reset-token").val();
            console.log(reset_token);
        })
        $("#password").blur(function() {
            var password = $("#password").val();
            var password_confirm = $("#password-confirm").val();
            var reset_token = $("#reset-token").val();
            var data = {
                password: password,
                password_confirm: password_confirm,
                reset_token: reset_token
            };
            // console.log(data);
            $.ajax({
                url: "./controllers/check-reset-pass-ajax.php", // Trang xử lý, mặc định trang hiện tại
                method: "POST", // POST hoặc GET, mặc định GET
                data: data, // Dữ liệu truyền lên server
                dataType: "json", // html, text, script hoặc json
                success: function(data) {
                    if (data.error.password != null) {
                        $(".form-group-password").addClass("invalid");
                        $(".form-message-password").text(data.error.password);
                    } else {
                        $(".form-group-password").removeClass("invalid");
                        $(".form-message-password").text("");
                    }

                    $("#password").focus(function() {
                        $(this).parents(".sub-form").parents(".form-group-password").removeClass("invalid");
                        $(this).parents(".sub-form").nextAll(".form-message-password").text("");
                        $("#form-message-error").text("");
                        $("#form-message-success").text("");
                    })
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
            });
        })

        $("#password-confirm").blur(function() {
            var password = $("#password").val();
            var password_confirm = $("#password-confirm").val();
            var reset_token = $("#reset-token").val();
            var data = {
                password: password,
                password_confirm: password_confirm,
                reset_token: reset_token
            };
            // console.log(data);
            $.ajax({
                url: "./controllers/check-reset-pass-ajax.php", // Trang xử lý, mặc định trang hiện tại
                method: "POST", // POST hoặc GET, mặc định GET
                data: data, // Dữ liệu truyền lên server
                dataType: "json", // html, text, script hoặc json
                success: function(data) {
                    if (data.error.password_confirm != null) {
                        $(".form-group-password-confirm").addClass("invalid");
                        $(".form-message-password-confirm").text(data.error.password_confirm);
                    } else {
                        $(".form-group-password-confirm").removeClass("invalid");
                        $(".form-message-password-confirm").text("");
                    }

                    $("#password-confirm").focus(function() {
                        $(this).parents(".sub-form").parents(".form-group-password-confirm").removeClass("invalid");
                        $(this).parents(".sub-form").nextAll(".form-message-password-confirm").text("");
                        $("#form-message-error").text("");
                        $("#form-message-success").text("");
                    })
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
            });
        })

        $("#form-reset-pass").submit(function(e) {
            var password = $("#password").val();
            var password_confirm = $("#password-confirm").val();
            var reset_token = $("#reset-token").val();
            var btnResetPass = $("#btn-reset-pass").val();
            var data = {
                password: password,
                password_confirm: password_confirm,
                reset_token: reset_token,
                btnResetPass: btnResetPass
            };
            // console.log(data);
            $.ajax({
                url: "./controllers/check-reset-pass-ajax.php", // Trang xử lý, mặc định trang hiện tại
                method: "POST", // POST hoặc GET, mặc định GET
                data: data, // Dữ liệu truyền lên server
                dataType: "json", // html, text, script hoặc json
                success: function(data) {
                    if (data.error.password != null) {
                        $(".form-group-password").addClass("invalid");
                        $(".form-message-password").text(data.error.password);
                    } else {
                        $(".form-group-password").removeClass("invalid");
                        $(".form-message-password").text("");
                    }

                    if (data.error.password_confirm != null) {
                        $(".form-group-password-confirm").addClass("invalid");
                        $(".form-message-password-confirm").text(data.error.password_confirm);
                    } else {
                        $(".form-group-password-confirm").removeClass("invalid");
                        $(".form-message-password-confirm").text("");
                    }


                    $("#password").focus(function() {
                        $(this).parents(".sub-form").parents(".form-group-password").removeClass("invalid");
                        $(this).parents(".sub-form").nextAll(".form-message-password").text("");
                        $("#form-message-error").text("");
                        $("#form-message-success").text("");
                    })

                    $("#password-confirm").focus(function() {
                        $(this).parents(".sub-form").parents(".form-group-password-confirm").removeClass("invalid");
                        $(this).parents(".sub-form").nextAll(".form-message-password-confirm").text("");
                        $("#form-message-error").text("");
                        $("#form-message-success").text("");
                    })

                    if (data.error == "") {
                        if (data.is_reset_pass == 1) {
                            $("#form-message-success").text(data.message);
                        } else if (data.is_reset_pass == 0) {
                            $("#form-message-error").text(data.message);
                        }
                    }
                    console.log(data);

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                },
            });
            e.preventDefault();
        });
    })
</script>