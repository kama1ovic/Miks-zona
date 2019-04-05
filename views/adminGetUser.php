    <title>Spisak korisnika</title>
</head>
<body>
<div id="wrapper1" >
    <div id="users">
            <?php
            require "php/connection.php";
            $query = "SELECT * FROM korisnik k INNER JOIN uloga u ON k.ID_uloga=u.ID_uloga INNER JOIN grad g  ON k.ID_grad=g.ID_grad";
            $sum = select($query);
            foreach ($sum as $korisnik): ?>
            <div class="item">
                    <p class="key" >Ime</p>
                    <p class="value"><?=$korisnik->ime?></p>
                    <p class="key">Prezime</p>
                    <p class="value"><?=$korisnik->prezime?></p>
                    <p class="key">Korisničko ime</p>
                    <p class="value"><?=$korisnik->username?></p>
                    <p class="key">Email</p>
                    <p class="value"><?=$korisnik->email?></p>
                    <p class="key">Aktivnost</p>
                    <p class="value"><?=$korisnik->aktivan?></p>
                    <p class="key">Status</p>
                    <p class="value"><?php if($korisnik->obrisan==0) echo"Nije obrisan";
                    else echo "Obrisan";?></p>
                    <?php if($korisnik->datum_izmene=="/") : ?>
                    <p class="key">Datum registracije</p>
                    <p class="value"><?=$korisnik->datum_registracije?></p>
                    <?php else: ?>
                    <p class="key">Datum izmene</p>
                    <p class="value"><?=$korisnik->datum_izmene?></p>
                    <?php endif;?>
                    <form action="views/adminUpdateUser.php" method="GET">
                        <input type="hidden" name="ID" value="<?=$korisnik->ID_korisnik?>"/>
                        <input type="hidden" name="firstname"  value="<?=$korisnik->ime?>" />
                        <input type="hidden" name="lastname"  value="<?=$korisnik->prezime?>" />
                        <input type="hidden" name="username"  value="<?=$korisnik->username?>" />
                        <input type="hidden" name="email"  value="<?=$korisnik->email?>" />
                        <input type="hidden" name="ID_city"  value="<?=$korisnik->ID_grad?>" />
                        <input type="hidden" name="city"  value="<?=$korisnik->grad_ime?>" />
                        <input type="hidden" name="ID_roll"  value="<?=$korisnik->ID_uloga?>" />
                        <input type="hidden" name="roll"  value="<?=$korisnik->uloga_ime?>" />
                        <input type="hidden" name="active"  value="<?=$korisnik->aktivan?>" />
                        <input type="hidden" name="gender"  value="<?=$korisnik->pol?>" />
                        <input type="hidden" name="status"  value="<?=$korisnik->obrisan?>" />
                        <input type="submit" class="edit"  name="btn" value="Izmeni"/>
                    </form>
                    <button <?php if($korisnik->obrisan==1):?> disabled="disabled" <?php endif?> class="del" data-id="<?=$korisnik->ID_korisnik?>">Obriši</button>
                </div>
                <?php  endforeach; ?>
    </div>
    <footer>
        <h5><a  href="admin.php?page=pocetna">Nazad na početnu stranu</a></h5>
    </footer>
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="js/adminDeleteUser.js" type="text/javascript"></script>