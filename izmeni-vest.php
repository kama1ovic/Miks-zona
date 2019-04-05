<?php
        session_start();
        if(isset($_SESSION['user'])) :
            if($_SESSION['user']->ID_uloga=='1'):
                require "php/connection.php";
                require "views/login-reg-head.php";
                if (isset($_GET['btn'])) {
                    $ID = $_GET['ID'];
                    $naziv = $_GET['naziv'];
                    $slika = $_GET['slika'];
                    $tekst = $_GET['tekst'];
                    $link = $_GET['link'];
                    $link_p = $_GET['link_p'];
                    $link_n = $_GET['link_n'];
                    $obrisan = $_GET['obrisan'];
                }
        ?>
        <title>Izmena vesti</title>
        </head>
        <body>
    <div id="wrapper">
        <div class="box" >
            <div id="errors">
            </div>
            <div id="header">
                <h3>Izmena teksta</h3>
            </div>
            <div id="edit-news" class="admin">
            <form id="forma2" action="php/adminEditText.php" method="POST">
                <input type="hidden" value="<?= $ID ?>" name="ID">
                <p class="left">Potkategorija</p>
                <select name="subcat" class="right select">
                    <option selected="selected" value="<?=$link?>"><?=$link_n?></option>
                    <?php
                    $query = "SELECT * FROM link WHERE ID_link_parent = $link_p AND  ID_link != $link";
                    $sum = select($query);
                    foreach ($sum as $link): ?>
                        <option value="<?=$link->ID_link?>"><?=$link->naziv?></option>
                    <?php endforeach; ?>
                </select>
                    <p class="left">Naslov</p>
                    <input type="text" class="right" name="heading" autofocus="autofocus" value="<?= $naziv ?>"/>
                    <p class="left">Tekst</p>
                    <textarea name="text" cols="30" rows="10"><?= $tekst ?></textarea>
                    <p class="left">Status</p>
                    <select name="status" class="right select">
                        <option value="null">Izaberite...</option>
                        <?php if ($obrisan === "0") : ?>
                            <option selected="selected" value="0">Nije obrisano</option>
                            <option value="1">Obrisano</option>
                        <?php else: ?>
                            <option value="0">Nije obrisano</option>
                            <option selected="selected" value="1">Obrisano</option>
                        <?php endif; ?>
                    </select>
                <input type="submit" value="Izmeni tekst" class="btn btn1" name="btn"/>
            </form>
            </div>
            <footer>
                <h5><a href="spisak-vesti.php">Nazad na prethodnu stranicu</a></h5>
            </footer>
        </div>
        <div class="box">
            <div id="errors">
            </div>
            <div id="header">
                <h3>Izmena slike</h3>
            </div>
            <div id="edit-news" class="admin">
            <form id="forma3" action="php/adminEditPicture.php" method="POST" enctype="multipart/form-data">
                <p class="left">Slika</p>
                <input type="hidden" value="<?= $ID ?>" name="ID">
                <input class="right" type="file" name="img" >
                <input type="submit" value="Izmeni sliku" class="btn btn1" name="image"/>
            </form>
            </div>
            <footer>
                <h5><a href="spisak-vesti.php">Nazad na prethodnu stranicu</a></h5>
            </footer>
        </div>

        <?php
        require "views/login-reg-footer.php";
            else:
                header("Location:index.php?page=pocetna");
            endif;
        else:
            header("Location:index.php?page=pocetna");
        endif;