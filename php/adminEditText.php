<?php
    session_start();
    require "connection.php";
    if(isset($_POST["btn"])) {
        $ID = $_POST['ID'];
        $subcat = $_POST['subcat'];
        $text = $_POST['text'];
        $heading = $_POST['heading'];
        $status = $_POST['status'];
        $errors = [];
        $ok = "Uspešno izmenjena vest";
        if(strlen($heading) < 5 ) {
            array_push($errors, "Naslov mora biti veći od 5 karaktera");
        }
        if(strlen($heading) > 60 ) {
            array_push($errors, "Naslov ne sme biti veći od 60 karaktera");
        }
        if(strlen($text) < 20 ) {
            array_push($errors, "Tekst mora imati najmanje 20 karaktera");
        }
        if($subcat == "")
            array_push($errors, "Niste odabrali potkategoriju");
        if(count($errors) > 0 ) {
            $_SESSION['errors'] = $errors;
            header("Location:../spisak-vesti.php");
        }
        else {
            $sql = "UPDATE vest SET vest_naziv=:naziv, vest_tekst=:tekst, ID_link=:cat ,obrisan=:obrisan WHERE ID_vest = :ID";
            $prepare = $connection->prepare($sql);
            $prepare->bindParam(":naziv",$heading);
            $prepare->bindParam(":tekst",$text);
            $prepare->bindParam(":ID",$ID);
            $prepare->bindParam(":obrisan",$status);
            $prepare->bindParam(":cat",$subcat);
            try{
                $prepare->execute();
                $_SESSION['ok'] = $ok;
                header("Location:../spisak-vesti.php");
            }
            catch(PDOException $e){
                $e->getMessage();
            }
        }
    }