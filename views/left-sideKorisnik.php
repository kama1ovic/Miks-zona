<div id="container">
<div id="left-side">
    <ul>
        <?php
        $query="SELECT * FROM link WHERE ID_link_parent=0";
        $sum = select($query);
        foreach ($sum as $item) : ?>
            <li><h3><?=$item->naziv?></h3>
                <ul >
                    <?php
                    $query1= "SELECT * FROM link WHERE ID_link_parent=$item->ID_link";
                    $sum1= select($query1);
                    foreach ($sum1 as $item1):?>
                        <li class="hide"><a href='korisnik.php?<?=$item1->putanja?>'><?=$item1->naziv?></a></li>
                    <?php endforeach;?>
                </ul>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
