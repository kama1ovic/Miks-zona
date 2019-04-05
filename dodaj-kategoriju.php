<?php
session_start();
if(isset($_SESSION['user'])) :
    if($_SESSION['user']->ID_uloga==1) :
        require "php/adminInsertCategory.php";
        require "views/login-reg-head.php"; ?>
<title>Dodavanje kategorije</title>
</head>
<body>
<div id="wrapper" >
    <div id="box">
        <div id="errors">
            <noscript>
                <p class="false er">Molimo Vas omogućite JavuScript kako biste dodali kategoriju!</p>
            </noscript>
        </div>
        <p class="feedback ok" id="f200">Uspešno ste dodali kategoriju!<br/></p>
        <p class="feedback er" id="f500">Trenutno ne možete dodati kategoriju</p>
        <div id="header">
            <h3>Dodaj kategoriju</h3>
        </div>
        <form id="forma2" action="" method="">
            <div id="content1" class="admin" >
                <p class="left">Dodaj kategoriju</p>
                <input type="text"  class="right" id="category" autofocus="autofocus" placeholder="Kategorija"/>
                <input type="button" value="DODAJ" class="btn" id="btn"/>
            </div>
        </form>
        <footer>
            <h5><a  href="<?= $_SERVER['HTTP_REFERER'] ?>">Nazad na prethodnu stranu</a></h5>
        </footer>
    </div>
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="js/adminInsertCategory.js" type="text/javascript"></script>
        <?php
        require "views/login-reg-footer.php";
else:
    header("Location:index.php?page=pocetna");
    endif;
else:
    header("Location:index.php?page=pocetna");
endif;
