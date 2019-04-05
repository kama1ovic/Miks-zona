<div id="right-side">
    <?php
        $query = "SELECT * FROM sponzor ORDER BY RAND() LIMIT 4;";
        $sum = select($query);
        if(empty($sum))
            echo "";
        foreach($sum as $item) :
    ?>
    <div class="sponsor">
        <a target="_blank" href="<?= $item->link ?>">
            <img src="<?= $item->slika ?>" alt="<?= substr($item->link,7); ?>" title="<?= substr($item->link,7); ?>" width="300" height="150">
        </a>
    </div>
    <?php
        endforeach;
    ?>
</div>
</div>