<?php
    if(isset($_SESSION['user']))
        header("Location:index.php");
    else {
        require_once "php/login.php";
        require_once "views/login-reg-head.php";
        require_once "views/login.php";
        require_once "views/login-reg-footer.php";
    }