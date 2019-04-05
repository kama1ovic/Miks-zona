<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/main-login-reg.css" type="text/css">
<title>Registracija</title>
</head>
<body>
<div id="wrapper" >
    <div id="box">
        <div id="errors">
            <noscript>
                <p class="false er">Molimo Vas omogućite JavuScript kako biste se registrovali korisnika!</p>
            </noscript>
        </div>
        <p class="feedback ok" id="f200">Uspešno ste registrovali korisnika!<br/></p>
        <p class="feedback er" id="f500">Trenutno ne možete registrovati korisnika!</p>
        <div id="header">
            <h3>Registracija</h3>
        </div>
        <form id="forma2" action="" method="">
            <div id="content1" class="admin" >
                <p class="left">Ime</p>
                <input type="text"  class="right" id="first" autofocus="autofocus" placeholder="Petar"/>
                <p class="left">Prezime</p>
                <input type="text" class="right" id="last" placeholder="Petrović"/>
                <p class="left">Email</p>
                <input type="text" class="right" id="email" placeholder="petar@domen.com"/>
                <p class="left">Pol</p>
                <div id="pol" class="left">
                    <label   for="m">Muški</label>
                    <input type="radio"  name="pol" class="radio" checked="checked" id="m" value="m"/>
                    <label for="f">Ženski</label>
                    <input type="radio"  name="pol" class="radio"  id="f" value="z"/>
                </div>
                <p class="left">Grad</p>
                <select class="right select" name="city" id="city">
                    <option value="0">Izaberite...</option>
                    <?php
                    $query = "SELECT * FROM grad";
                    $sum = select($query);
                    foreach ($sum as $grad): ?>
                        <option value="<?=$grad->ID_grad?>"><?=$grad->grad_ime?></option>
                    <?php  endforeach; ?>
                </select>
                <p class="left">Korisničko ime</p>
                <input type="text" class="right" id="username" placeholder="korisnik1"/>
                <p class="left">Lozinka</p>
                <input type="password" class="right" id="password" placeholder="Lozinka1#$%"/>
                <p class="left">Potvrdi lozinku</p>
                <input type="password" class="right" id="password1" placeholder="Lozinka1#$%"/>
                <p class="left">Uloga</p>
                <select class="right select" name="roll" id="roll">
                    <option value="0">Izaberite...</option>
                    <?php
                    $query = "SELECT * FROM uloga";
                    $sum = select($query);
                    foreach ($sum as $uloga): ?>
                        <option value="<?=$uloga->ID_uloga?>"><?=$uloga->uloga_ime?></option>
                    <?php  endforeach; ?>
                </select>
                <p class="left">Aktivnost</p>
                <select name="active" class="right select" id="active">
                    <option value="null">Izaberite...</option>
                    <option value="0">Neaktivan</option>
                    <option value="1">Aktivan</option>
                </select>
                <input type="button" value="REGISTRUJ" class="btn" id="btn"/>

            </div>
        </form>
        <footer>

            <h5><a  href="<?= $_SERVER['HTTP_REFERER'] ?>">Nazad na prethodnu stranu</a></h5>

        </footer>

    </div>
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="js/registrationAdmin.js" type="text/javascript"></script>