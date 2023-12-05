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

  .convert-sign-in a:hover {
    color: crimson;
    text-decoration: none;
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
</style>
<!-- end header -->
<div id="content" class="pt-5">
  <div class="container">
    <div class="row">
      <div class="col-md-8 m-auto">
        <h1 class="text-center">Đăng ký</h1>
        <form action="controllers/controller_sign_up.php" class="form" id="form-1" method="POST">
          <div class="form-group form-group-username">
            <label for="username">Họ tên</label>
            <input type="text" name="ten_user" id="ten_user" class="form-control" placeholder="Họ tên" />
            <small class="form-message form-message-username"></small>
          </div>
          <div class="form-group form-group-email">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" class="form-control" placeholder="Email" />
            <small class="form-message form-message-email"></small>
          </div>
          <div class="form-group form-group-sdt">
            <label for="sdt">Số điện thoại</label>
            <input type="text" name="sodth" id="sodth" class="form-control" placeholder="Số điện thoại" />
            <small class="form-message form-message-sdt"></small>
          </div>
          <div id="email-result" class="result-message"></div>


          <div class="form-group form-group-diaChi">
            <label for="diaChi">Địa chỉ</label>
            <input type="text" name="diaChi" id="diaChi" class="form-control" placeholder="Địa chỉ" />
            <small class="form-message form-message-diaChi"></small>
          </div>


          <div class="form-group form-group-password">
            <label for="password">Mật khẩu</label>
            <div class="sub-form">
              <input type="password" name="matKhau" id="matKhau" class="form-control" placeholder="Mật khẩu" />
              <i class="fa-solid fa-eye icon-eye"></i>
            </div>
            <small class="form-message form-message-password"></small>
          </div>


          <div class="form-group form-group-password-confirm">
            <label for="password-confirm">Nhập lại mật khẩu</label>
            <div class="sub-form">
              <input type="password" name="password" id="password-confirm" class="form-control" placeholder="Nhập lại mật khẩu" />
              <i class="fa-solid fa-eye icon-eye"></i>
            </div>
            <small class="form-message form-message-password-confirm"></small>
          </div>


          <input type="submit" name="btn-sign-up" id="btn-sign-up" class="btn btn-info w-100 mt-4 mb-2" value="Đăng ký"></input>
          <small id="form-message-error"></small>
          <small id="form-message-success"></small>
          <div class="convert-sign-in mt-1">
            <span>Bạn đã có tài khoản?</span>
            <a href="index.php?page=login">Đăng nhập</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
$("#email").on("input", function () {
    const email = $(this).val();
    const errorMessageElement = $(".form-message-email");
    const resultMessageElement = $("#email-result");

    if (isEmailValid(email)) {
        errorMessageElement.text("");
        errorMessageElement.css("color", "green");

        // Gửi yêu cầu kiểm tra email bằng AJAX
        $.ajax({
            url: "/check-email", // Đổi thành địa chỉ API của bạn
            method: "POST",
            data: { email: email },
            success: function (response) {
                if (response.valid) {
                    resultMessageElement.text("Email hợp lệ.");
                    resultMessageElement.css("color", "green");
                } else {
                    resultMessageElement.text("Email đã tồn tại.");
                    resultMessageElement.css("color", "red");
                }
            }
        });
    } else {
        errorMessageElement.text("Email không hợp lệ.");
        errorMessageElement.css("color", "red");
        resultMessageElement.text(""); // Xóa kết quả trước đó nếu email không hợp lệ
    }
});

function isEmailValid(email) {
    // Thực hiện kiểm tra email ở đây (giống như trong ví dụ trước)
    const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail.com$/;
    return emailPattern.test(email);
}


// Kiểm tra mật khẩu
$("#matKhau, #password-confirm").on("input", function () {
    const password = $("#matKhau").val();
    const confirmPassword = $("#password-confirm").val();
    const passwordMessageElement = $(".form-message-password");
    const passwordConfirmMessageElement = $(".form-message-password-confirm");


    if (password.length < 5) {
        passwordMessageElement.text("Mật khẩu phải có ít nhất 5 ký tự.");
        passwordMessageElement.css("color", "red");
    } else {
        passwordMessageElement.text("");
    }

    if (password !== confirmPassword) {
      passwordConfirmMessageElement.text("Mật khẩu không trùng khớp.");
      passwordConfirmMessageElement.css("color", "red");
    }
    else {
      passwordConfirmMessageElement.text("");
    }
});

// Kiểm tra số điện thoại
$("#sodth").on("input", function () {
    const sdt = $(this).val();
    const sdtMessageElement = $(".form-message-sdt");
    const sdtResultElement = $("#sodth-result");

    if (/^0[0-9]{9}$/.test(sdt)) {
        sdtMessageElement.text("");
        sdtResultElement.text("Số điện thoại hợp lệ.");
        sdtResultElement.css("color", "green");
    } else {
        sdtMessageElement.text("Số điện thoại không hợp lệ.");
        sdtMessageElement.css("color", "red");
        sdtResultElement.text("");
    }
});

$(document).ready(function () {
    $("form").submit(function (event) {
        event.preventDefault(); // Ngăn chặn gửi form mặc định
        
        // Kiểm tra họ tên
        const tenUser = $("#ten_user").val();
        if (tenUser.trim() === "") {
            alert("Vui lòng nhập họ tên.");
            return;
        }

        // Kiểm tra email
        const email = $("#email").val();
        if (!isEmailValid(email)) {
            alert("Email không hợp lệ.");
            return;
        }

        // Kiểm tra số điện thoại
        const sdt = $("#sodth").val();
        if (!/^0[0-9]{9}$/.test(sdt)) {
            alert("Số điện thoại không hợp lệ.");
            return;
        }

        // Kiểm tra số điện thoại
        const diaChi = $("#diaChi").val();
        if (diaChi  .trim() === "") {
            alert("Vui lòng nhập địa chỉ.");
            return;
        }

        // Kiểm tra mật khẩu
        const matKhau = $("#matKhau").val();
        const confirmPassword = $("#password-confirm").val();
        if (matKhau.length < 5) {
            alert("Mật khẩu phải có ít nhất 5 ký tự.");
            return;
        }
        if (matKhau !== confirmPassword) {
            alert("Mật khẩu không trùng khớp.");
            return;
        }

        // Nếu không có lỗi, bạn có thể gửi form tại đây
        $(this).unbind("submit").submit();
    });

    // Kiểm tra email hợp lệ
    function isEmailValid(email) {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@gmail.com$/;
        return emailPattern.test(email);
    }
});


</script>

