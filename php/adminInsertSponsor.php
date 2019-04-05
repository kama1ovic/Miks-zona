<?php
@session_start();
require "connection.php";
if(isset($_POST['btn'])):
    $slika = $_FILES['img'];
    $slika_ime = $slika['name'];
    $slika_tip = $slika['type'];
    $slika_velicina = $slika['size'];
    $slika_tmp = $slika["tmp_name"];
    $link = $_POST["link"];
    $tipovi = ["image/jpeg","image/jpg","image/gif","image/png"];
    $errors =[];
    $ok = "Uspešno dodat sponzor";
    if(!in_array($slika_tip,$tipovi))
        $errors[] = "Tip slike nije podrzan";
    if($slika_velicina > 4000000)
        $errors[] = "Fajl mora biti manji od 4MB.";
    if(!filter_var($link,FILTER_VALIDATE_URL))
        $errors[] = "Link nije ispravan.";

    if(count($errors) == 0) :
        $naziv_fajla = time().$slika_ime;
        $nova_putanja = "../images/".$naziv_fajla;
        move_uploaded_file($slika_tmp,$nova_putanja);
        $putanja = "images/$naziv_fajla";
        $sql = "INSERT INTO sponzor (slika, link) VALUES (:slika,:link)";
        $prepare = $connection->prepare($sql);
        $prepare->bindParam(":slika",$putanja);
        $prepare->bindParam(":link",$link);
        try{
            $prepare->execute();
            $_SESSION['ok'] = $ok;
            header("Location:../dodaj-sponzora.php");
        }
        catch(PDOException $e){
            $e->getMessage();
        }
        else:
            $_SESSION['errors'] = $errors;
            header("Location:../dodaj-sponzora.php");
    endif;
endif;