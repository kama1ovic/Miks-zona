    <title>Dodaj potkategoriju</title>
</head>
<body>
<div id="wrapper" class="resize">
    <div id="box">
        <div id="errors">
            <noscript>
                <p class="false er">Molimo Vas omogućite JavuScript kako biste dodali potkategoriju!</p>
            </noscript>
        </div>
        <p class="feedback ok" id="f200">Uspešno ste dodali potkategoriju!<br/></p>
        <p class="feedback er" id="f500">Trenutno ne možete dodati potkategoriju</p>
        <div id="header">
            <h3>Dodaj potkategoriju</h3>
        </div>
        <form id="forma2" action="" method="">
            <div id="content1" class="admin" >
                <p class="left">Izaberi kategoriju</p>
                <select class="right select" name="category" id="category" autofocus="autofocus">
                    <option value="0">Izaberite...</option>
                    <?php
                    $query = "SELECT * FROM link WHERE ID_link_parent = 0";
                    $sum = select($query);
                    foreach ($sum as $link): ?>
                        <option value="<?=$link->ID_link?>"><?=$link->naziv?></option>
                    <?php  endforeach; ?>
                </select>
                <p class="left">Dodaj potkategoriju</p>
                <input type="text"  class="right" id="subcategory"  placeholder="Potkategorija"/>
                <input type="button" value="DODAJ" class="btn" id="btn"/>
            </div>
        </form>
        <footer>
            <h5><a  href="<?= $_SERVER['HTTP_REFERER'] ?>">Nazad na prethodnu stranu</a></h5>
        </footer>
    </div>
    <script src="js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="js/adminInsertSubCategory.js" type="text/javascript"></script>