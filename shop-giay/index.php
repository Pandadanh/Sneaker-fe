

<?php
 ob_start();
require_once("header.php");
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case "home":
            require_once("home.php");
            break;
        case "login":
            require_once("login.php");
            break;
        case "sign-up":
            require_once("sign-up.php");
            break;
        case "product":
            require_once("product.php");
            break;
        case "chitietsp":
            require_once("giohang.php");
            break;
        case "active_account":
            require_once("active_account.php");
            break;
        case "out":
            require_once("out.php");
            break;
        case "giohang":
            require_once("giohang.php");
            break;
        case "forgot-pass":
            require_once("forgot-pass.php");
            break;
        case "check-reset-pass-ajax":
            require_once("check-reset-pass-ajax.php");
            break;
        case "lienhe":
            require_once("lienhe.php");
            break;
        case "reset_pass":
            require_once("reset_pass.php");
            break;
        case "Profile-edit":
            require_once("Profile-edit.php");
            break;
        default:
            require_once("home.php");
            break;
    }
} else {
    require_once("home.php");
}
require_once("footer.php");
ob_end_flush();
?>