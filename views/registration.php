<title>Registracija</title>
</head>
<body>
<div id="wrapper">
<div id="box">
    <div id="errors">
        <noscript>
            <p class="false er">Molimo Vas omogućite JavuScript kako biste se registrovali!</p>
        </noscript>
    </div>
    <p class="feedback ok" id="f200">Uspešno ste se registrovali!<br/>Poslat Vam je email sa aktivacionim linkom!</p>
    <p class="feedback er" id="f500">Trenutno se ne možete registrovati!</p>
    <div id="header">
        <h3>Registracija</h3>
    </div>
    <form id="forma2" action="php/login.php" method="POST">
        <div id="content1" >
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
            <input type="button" value="REGISTRUJ SE" class="btn" id="btn"/>
        </div>
    </form>
    <footer>
        <h5>
            Imate nalog?  <a href="prijava.php">Prijavite se</a> <br/>
            <a  href="<?= $_SERVER['HTTP_REFERER'] ?>">Nazad na prethodnu stranu</a>
        </h5 >
    </footer>
</div>
</div>
<script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="js/registration.js" type="text/javascript"></script>