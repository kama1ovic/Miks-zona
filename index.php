<?php
@session_start();
require "php/connection.php";
if(isset($_SESSION['user'])) {
    if ($_SESSION['user']->ID_uloga == 1)
        header("Location:admin.php?page=pocetna");
    elseif($_SESSION['user']->ID_uloga == 2)
        header("Location:korisnik.php?page=pocetna");
}
else {
    require "views/header.php";
    require "views/left-side.php";
    getPages();
    require "views/right-side.php";
    require "views/footer.php";
}