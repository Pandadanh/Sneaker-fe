<?php 
ob_start();
unset($_SESSION["user"]);
unset($_SESSION["user1"]);
header("location: index.php?page=home");
ob_end_flush();
?>