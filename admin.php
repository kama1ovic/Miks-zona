<?php
    session_start();
    if(isset($_SESSION['user'])) {
        if ($_SESSION['user']->ID_uloga == 1) {
            require_once "php/connection.php";
            require_once "views/headerAdmin.php";
            require_once "views/left-sideAdmin.php";
            getPages();
            require_once "views/right-side.php";
            require_once "views/footerAdmin.php";
        }
        else
            header("Location:index.php?page=pocetna");
    }
    else
        header("Location:index.php?page=pocetna");