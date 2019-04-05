<div id="articles">
    <?php
    $page = null;
    $cat = null;
    if (isset($_GET['page']) && (isset($_GET['cat']))) {
        $page = $_GET['page'];
        $cat = $_GET['cat'];
    }
    $sql = "SELECT * FROM vest v INNER JOIN link l ON v.ID_link=l.ID_link  WHERE l.putanja LIKE '%$page%' AND l.putanja LIKE '%$cat%' AND obrisan=0 ORDER BY datum DESC";
    $sum = select($sql);
    foreach($sum as $news) :?>
        <div class="item">
            <div class="img">
                <img src="<?= $news->slika ?>" alt="<?= $news->vest_naziv ?>" title="<?= $news->vest_naziv ?>" width="200" height="150">
            </div>
            <div class="left-container">
                <div class="date-com">
                    <h6 class="left"><?= $news->datum ?></h6>
                    <h6 class="right" data-idnews="<?= $news->ID_vest?>"
                        <?php if(isset($_SESSION['user'])) : ?>
                            data-user="<?= $_SESSION['user']->ID_korisnik?>"
                            data-news="<?= $news->vest_naziv?>"
                        <?php endif; ?>>Komentari</h6>
                </div>
                <div class="details" data-idnews="<?=$news->ID_vest?>">
                    <h3 class="heading"><?= $news->vest_naziv ?></h3>
                    <p class="text" ><?= substr($news->vest_tekst,0,150).'...' ?></p>
                </div>
            </div>
        </div>
    <?php endforeach;
    //kada u potkategoriji nema izabrane vesti
    if(empty($sum)) :  ?>
        <div id="no">
            <h4 class="no-news">Još uvek nema vesti za izabranu kategoriju </h4>
            <h4 class="no-news">Pogledajte ostale vesti </h4>
        </div>
    <?php
        $query="SELECT * FROM vest v INNER JOIN link l ON v.ID_link=l.ID_link WHERE l.putanja LIKE '%$page%' AND obrisan=0 ORDER BY datum DESC";
    $res = select($query);
    foreach($res as $news) : ?>
        <div class="item">
            <div class="img">
                <img src="<?= $news->slika ?>" alt="<?= $news->vest_naziv ?>" title="<?= $news->vest_naziv ?>" width="200" height="150">
            </div>
            <div class="left-container">
                <div class="date-com">
                    <h6 class="left"><?= $news->datum ?></h6>
                    <h6 class="right" data-idnews="<?= $news->ID_vest?>"
                        <?php if(isset($_SESSION['user'])) : ?>
                            data-user="<?= $_SESSION['user']->ID_korisnik?>"
                            data-news="<?= $news->vest_naziv?>"
                        <?php endif; ?>>Komentari</h6>
                </div>
                <div class="details" data-idnews="<?=$news->ID_vest?>">
                    <h3 class="heading"><?= $news->vest_naziv ?></h3>
                    <p class="text" ><?= substr($news->vest_tekst,0,150).'...' ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; endif;
        //kada u kategoriji nema vesti
   if(empty($res) && empty($sum)) : ?>
   <?php
       $sql = "SELECT * FROM vest v WHERE obrisan = 0 ORDER BY RAND(),datum DESC LIMIT 4;";
       $call = select($sql);
       foreach($call as $news): ?>
           <div class="item">
               <div class="img">
                   <img src="<?= $news->slika ?>" alt="<?= $news->vest_naziv ?>" title="<?= $news->vest_naziv ?>" width="200" height="150">
               </div>
               <div class="left-container">
                   <div class="date-com">
                       <h6 class="left"><?= $news->datum ?></h6>
                       <h6 class="right" data-idnews="<?= $news->ID_vest?>"
                           <?php if(isset($_SESSION['user'])) : ?>
                               data-user="<?= $_SESSION['user']->ID_korisnik?>"
                               data-news="<?= $news->vest_naziv?>"
                           <?php endif; ?>>Komentari</h6>
                   </div>
                   <div class="details" data-idnews="<?=$news->ID_vest?>">
                       <h3 class="heading"><?= $news->vest_naziv ?></h3>
                       <p class="text" ><?= substr($news->vest_tekst,0,150).'...' ?></p>
                   </div>
               </div>
           </div>
    <?php endforeach;
    endif;?>
</div>