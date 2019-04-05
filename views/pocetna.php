<div id="articles">
        <?php
        $sql = "SELECT * FROM vest WHERE obrisan = 0 ORDER BY datum DESC LIMIT 4";
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
        <?php endforeach; ?>
</div>