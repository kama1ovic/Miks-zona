<?php
@session_start();
    if(isset($_SESSION['user'])) {
        if ($_SESSION['user']->ID_uloga == 2) {
            require_once "php/connection.php";
            require_once "views/headerKorisnik.php";
            require_once "views/left-sideKorisnik.php";
            getPages();
            require_once "views/right-side.php";
            require_once "views/footer.php";
        } else
            header("Location:index.php?page=pocetna");
    }
else
header("Location:index.php?page=pocetna");