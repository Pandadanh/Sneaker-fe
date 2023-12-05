<?php
session_start();
if (isset($_POST["error"])) {
    $_SESSION["ERROR"] = $_POST["error"];
    $_SESSION["error"]="";
    $_SESSION["success"]="";

}

?>
