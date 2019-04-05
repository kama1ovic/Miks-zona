<?php
if(isset($_GET['btn'])) :
    $ID_korisnik = $_GET['ID'];
    $firstname = $_GET['firstname'];
    $lastname = $_GET['lastname'];
    $username = $_GET['username'];
    $email = $_GET['email'];
    $ID_city = $_GET['ID_city'];
    $city = $_GET['city'];
    $ID_roll = $_GET['ID_roll'];
    $roll = $_GET['roll'];
    $active = $_GET['active'];
    $gender = $_GET['gender'];
    $status = $_GET['status'];
endif;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main-login-reg.css" type="text/css">
    <title>Izmena korisnika</title>
</head>
<body>
<div id="wrapper">
    <div id="box">
        <div id="errors">
            <noscript>
                <p class="false er">Molimo Vas omogućite JavuScript kako biste se registrovali korisnika!</p>
            </noscript>
        </div>
        <p class="feedback ok" id="f200">Uspešno ste izmenili korisnika!<br/></p>
        <p class="feedback er" id="f500">Trenutno ne možete izmeniti korisnika!</p>
        <div id="header">
            <h3>Izmena</h3>
        </div>
        <form id="forma2" action="" method="">
            <div id="content1" class="admin">
                <input type="hidden" value="<?=$ID_korisnik?>" id="ID">
                <p class="left">Ime</p>
                <input type="text"  class="right" id="first" autofocus="autofocus" value="<?=$firstname?>"/>
                <p class="left">Prezime</p>
                <input type="text" class="right" id="last" value="<?=$lastname?>"/>
                <p class="left">Email</p>
                <input type="text" class="right" id="email" value="<?=$email?>"/>
                <p class="left">Pol</p>
                <div id="pol" class="left">
                    <label for="m">Muški</label>
                    <input type="radio" name="pol" class="radio" <?php if($gender=="m"): ?> checked="checked" <?php endif;?> id="m" value="m"/>
                    <label for="f">Ženski</label>
                    <input type="radio"  name="pol" class="radio" <?php if($gender=="z"): ?> checked="checked" <?php endif;?> id="f" value="z"/>
                </div>
                <p class="left">Grad</p>
                <select class="right select" name="city" id="city">
                    <option value="0">Izaberite...</option>
                    <?php
                    require "../php/connection.php";
                    $query = "SELECT * FROM grad WHERE ID_grad != $ID_city";
                    $sum = select($query); ?>
                    <option selected="selected" value="<?=$ID_city?>"><?=$city?></option>
                    <?php foreach ($sum as $grad): ?>
                        <option value="<?=$grad->ID_grad?>"><?=$grad->grad_ime?></option>
                    <?php endforeach; ?>
                </select>
                <p class="left">Korisničko ime</p>
                <input type="text" class="right" id="username" value="<?=$username?>"/>
                <p class="left">Uloga</p>
                <select class="right select" name="roll" id="roll">
                    <option value="0">Izaberite...</option>
                    <?php
                    $query = "SELECT * FROM uloga WHERE ID_uloga != $ID_roll";
                    $sum = select($query); ?>
                        <option selected="selected" value="<?=$ID_roll?>"><?=$roll?></option>
                    <?php foreach ($sum as $uloga): ?>
                    <option value="<?=$uloga->ID_uloga?>"><?=$uloga->uloga_ime?></option>
                    <?php endforeach; ?>
                </select>
                <p class="left">Aktivnost</p>
                <select name="active" class="right select" id="active">
                    <option value="null">Izaberite...</option>
                    <?php if($active==="0") : ?>
                    <option selected="selected" value="0">Neaktivan</option>
                    <option  value="1">Aktivan</option>
                    <?php else: ?>
                    <option  value="0">Neaktivan</option>
                    <option selected="selected" value="1">Aktivan</option>
                    <?php endif;?>
                </select>
                <p class="left">Status</p>
                <select name="status" class="right select" id="a">
                    <option value="null">Izaberite...</option>
                    <?php if($status==="0") : ?>
                        <option selected="selected" value="0">Nije obrisan</option>
                        <option  value="1">Obrisan</option>
                    <?php else: ?>
                        <option  value="0">Nije obrisan</option>
                        <option selected="selected" value="1">Obrisan</option>
                    <?php endif;?>
                </select>
                <input type="button" value="Izmeni" class="btn" id="btn"/>
            </div>
        </form>
        <footer>
            <h5><a  href="<?= $_SERVER['HTTP_REFERER'] ?>">Nazad na prethodnu stranu</a></h5>
        </footer>
    </div>
    <script src="../js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="../js/adminUpdateUser.js" type="text/javascript"></script>