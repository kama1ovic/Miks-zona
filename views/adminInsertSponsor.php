    <title>Dodaj sponzora</title>
</head>
<body>
<div id="wrapper" >
    <div id="box">
        <div id="errors">
            <?php if(isset($_SESSION['ok'])) : ?>
                <script>alert("Uspešno dodat sponzor!")</script>
            <?php endif; unset($_SESSION['ok']); ?>
            <?php if(isset($_SESSION['errors'])) :
                foreach ($_SESSION['errors'] as $error) :?>
                    <p class="feedbackAdmin er"><?=$error?></p>
                <?php endforeach; endif; unset($_SESSION['errors']);  ?>
        </div>
        <div id="header">
            <h3>Dodaj sponzora</h3>
        </div>
        <form id="forma2" action="php/adminInsertSponsor.php" method="POST" enctype="multipart/form-data">
            <div id="content1" class="admin" >
                <p class="left">Link</p>
                <input type="text" class="right sp" id="link" autofocus="autofocus" placeholder="http://www.sajt.com" name="link"/>
                <p class="left">Slika</p>
                <input type="file" class="right sp" id="img" name="img" />
               <input type="submit" value="DODAJ" class="btn" id="btn" name="btn"/>
            </div>
        </form>
        <footer>
            <h5><a href="admin.php?page=pocetna">Nazad na početnu stranu</a></h5>
        </footer>
    </div>