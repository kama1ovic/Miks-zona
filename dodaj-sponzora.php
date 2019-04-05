<?php
session_start();
if(isset($_SESSION['user'])) :
    if($_SESSION['user']->ID_uloga==1) :
        require "views/login-reg-head.php";
        require "views/adminInsertSponsor.php";
        require "views/login-reg-footer.php";
    else:
        header("Location:index.php?page=pocetna");
    endif;
else:
    header("Location:index.php?page=pocetna");
endif;


