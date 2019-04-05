<?php
session_start();
if(isset($_SESSION['user'])) :
    if($_SESSION['user']->ID_uloga==1) :
        require "views/login-reg-head.php"; ?>
    <title>Sponzori</title>
<div id="sponsors">
    <?php
    require "php/connection.php";
    $query = "SELECT * FROM sponzor";
    $sum = select($query);
    if(empty($sum))
        echo "";
    foreach($sum as $item) :
        ?>
    <div class="sponsorAdmin">
            <button class="delSponsor" data-id='<?=$item->ID_sponzor?>'>Obriši</button>
            <a target="_blank" href="<?= $item->link ?>">
                <img src="<?= $item->slika ?>" alt="<?= substr($item->link,7); ?>" title="<?= substr($item->link,7); ?>" width="300" height="150">
            </a>
    </div>
    <?php
    endforeach;
    ?>

</div>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript">
                $('.delSponsor').click(function () {
                   var id = $(this).data('id');
                   $.ajax({
                       url:"php/adminDeleteSponsor.php",
                       method:"POST",
                       data:{
                           id : id,
                           click:"sent"
                       },
                       success:function (data) {
                           alert("Uspešno ste obrisali sponzora");
                           location.reload();
                       },
                       error:function (x,s,e) {
                           switch (xhr.status) {
                               case 404:
                                   window.location.href="greska.php";
                                   break;
                               case 500:
                                   alert("Izvinjavamo se zbog tehničkih problema");
                                   break;
                           }
                       }
                   })
                });
        </script>
        </body>
        </html>
<?php
    else:
        header("Location:index.php?page=pocetna");
    endif;
else:
    header("Location:index.php?page=pocetna");
endif;