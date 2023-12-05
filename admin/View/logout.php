<?php 
ob_start();
include '../Control/inc/config.php'; 
session_start();
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']); // Nếu tồn tại, loại bỏ nó
}

ob_flush();
header("Location: /DOANWED/admin/View/login.php");
?>