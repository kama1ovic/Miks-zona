<?php
session_start();
    if(isset($_SESSION['user'])):
        if($_SESSION['user']->ID_uloga==1):
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <title>Spisak vesti</title>
</head>
<body>
<div id="wrapper">
    <div id="admin-news">
    <?php
    require "php/connection.php";
    $page = null;
    $cat = null;
    if (isset($_GET['page']) && (isset($_GET['cat']))) {
        $page = $_GET['page'];
        $cat = $_GET['cat'];
    }
    $sql = "SELECT * FROM vest v INNER JOIN link l ON v.ID_link=l.ID_link WHERE l.putanja LIKE '%$page%' AND l.putanja LIKE '%$cat%' ";
    $sum = select($sql);
    foreach($sum as $news) : ?>
        <?php if(isset($_SESSION['ok'])) : ?>
        <script>alert("Uspešno izmenjena vest!")</script>
    <?php endif; unset($_SESSION['ok']); ?>
    <?php if(isset($_SESSION['errors'])) :
    foreach ($_SESSION['errors'] as $error) :?>
        <div class="errors"><p class="feedbackAdmin er"><?=$error?></p></div>
    <?php endforeach; endif; unset($_SESSION['errors']);  ?>
        <div class="item">
            <div class="img">
                <img src="<?= $news->slika ?>" alt="<?= $news->vest_naziv ?>" title="<?= $news->vest_naziv ?>" width="200" height="150">
            </div>
            <div class="text">
                    <form action="izmeni-vest.php" method="GET">
                        <input type="hidden" name="ID" value="<?= $news->ID_vest ?>">
                        <input type="hidden" name="link_p" value="<?= $news->ID_link_parent ?>">
                        <input type="hidden" name="link" value="<?= $news->ID_link ?>">
                        <input type="hidden" name="link_n" value="<?= $news->naziv ?>">
                        <input type="hidden" name="naziv" value="<?= $news->vest_naziv ?>">
                        <input type="hidden" name="slika" value="<?= $news->slika ?>">
                        <input type="hidden" name="tekst" value="<?= $news->vest_tekst ?>">
                        <input type="hidden" name="obrisan" value="<?= $news->obrisan ?>">
                        <input type="submit" value="Izmeni" name="btn" class="edit">
                    </form>
                <span class="heading">
            <h6><?= $news->datum ?></h6>
            <h3><?= $news->vest_naziv ?></h3>
                    <h4>Status : <?php if($news->obrisan==1) echo "Obrisano"; else echo "Nije obrisano";?></h4>
        </span>
                <div class="details"><?= substr($news->vest_tekst,0,150).'...' ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
        <footer class="ftr">
            <h5 ><a href="admin.php?page=pocetna">Nazad na početnu stranu</a></h5>
        </footer>
</div>
</body>
</html>
<?php
        else:
            header("Location:index.php?page=pocetna");
        endif;
    else:
        header("Location:index.php?page=pocetna");
    endif;