<!-- end header -->
<style>
  .form-group label {
    font-weight: 500;
    font-size: larger;
  }

  .form-group.invalid .form-control {
    border-color: #f33a58;
  }

  .form-group.invalid .form-message {
    color: #f33a58;
    font-size: 17px;
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

  .sign-up:hover,
  .login:hover,
  .forgot-password:hover {
    color: crimson;
    text-decoration: none;
  }
</style>

  <div id="content" class="pt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-8 m-auto">
          <h1 class="text-center mb-3">Quên mật khẩu</h1>
          <form action="" class="form" id="form-3">
            <div class="form-group">
              <label for="email">Vui lòng nhập email để lấy lại mật khẩu của bạn</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Email" />
              <small class="form-message"></small>
            </div>
            <input type="submit" name="btn-forgot-pass" id="btn-forgot-pass" class="btn btn-info w-100 my-2" value="Gửi yêu cầu"></input>
            <small id="form-message-success"></small>
            <small id="form-message-error"></small>
            <div>
              <span>Quay lại trang</span>
              <a href="index.php?page=login" class="login">Đăng nhập</a>
              <a href="index.php?page=sign-up" class="sign-up">Đăng ký</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {

      $("#form-3").submit(function(e) {

        var email = $("#email").val();
        
        var btnForgotPass = $("#btn-forgot-pass").val();
        var data = {
          email: email,
          btnForgotPass: btnForgotPass
        };
        console.log("đasasad");
        console.log(email);
        console.log(data);
        $.ajax({
          url: "./controllers/check-forgot-pass-ajax.php", // Trang xử lý, mặc định trang hiện tại
          method: "POST", // POST hoặc GET, mặc định GET
          data: data, // Dữ liệu truyền lên server
          dataType: "json", // html, text, script hoặc json
          success: function(data) {
            // console.log(data.error.email);
            // console.log(data.error.password);
            if (data.error.email != null) {
              $(".form-group").addClass("invalid");
              $(".form-message").text(data.error.email);
            } else {
              $(".form-group").removeClass("invalid");
              $(".form-message").text("");
            }

            $("#email").focus(function() {
              $(this).parents(".form-group").removeClass("invalid");
              $(this).next(".form-message").text("");
              $("#form-message-success").text("");
              $("#form-message-error").text("");

            })

            if (data.error == "") {
              if (data.is_send == 1) {
                $("#form-message-success").text(data.message);
              } else {
                $("#form-message-error").text(data.message);
              }
            }

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