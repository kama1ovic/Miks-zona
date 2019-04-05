<?php
//    session_start();
//    require "connection.php";
//    $code = 404;
//    if(isset($_POST["btn"]) && (!isset($_FILES['img']))) {
//        $ID = $_POST['ID'];
//        $text = $_POST['text'];
//        $heading = $_POST['heading'];
//        $status = $_POST['status'];
//        $errors = [];
////        var_dump($_POST);
//        if(strlen($heading) > 60 )
//            array_push($errors, "Naslov je predugačak!");
//        if(strlen($text) < 20 )
//            array_push($errors,"Tekst mora imati najmanje 20 karaktera");
//        if(count($errors) > 0 ) {
//            echo "<div id='error'>";
//            foreach ($errors as $error) {
//                echo "<p class='false er'>$error</p>";
//                $code=422;
//            }
//        }
//        else {
//            $sql = "UPDATE vest SET vest_naziv=:naziv, vest_tekst=:tekst, obrisan=:obrisan WHERE ID_vest = :ID";
//            $prepare = $connection->prepare($sql);
//            $prepare->bindParam(":naziv",$heading);
//            $prepare->bindParam(":tekst",$text);
//            $prepare->bindParam(":ID",$ID);
//            $prepare->bindParam(":obrisan",$status);
//
//            try{
//                $code =  $prepare->execute() ? 204: 500;
//                $_SESSION['ok'] = "Uspešno izmenjena vest";
//            }
//            catch(PDOException $e){
//                $e->getMessage();
//                $code=409;
//            }
//
//        }
//    }
//    else if(isset($_POST["btn"])  && (isset($_FILES['img']))) {
//        $ID = $_POST['ID'];
//        $text = $_POST['text'];
//        $heading = $_POST['heading'];
//        $status = $_POST['status'];
//        $image = $_FILES['img'];
//        $imageName = $image['name'];
//        $imageType = $image['type'];
//        $imageSize = $image['size'];
//        $imageTmp = $image['tmp_name'];
//        $types = ["image/jpg", "image/jpeg","image/gif","image/png"];
//        $errors = [];
//        var_dump($_POST);
//        if(strlen($heading) > 60 )
//            array_push($errors, "Naslov je predugačak!");
//        if(strlen($text) < 20 )
//            array_push($errors,"Tekst mora imati najmanje 20 karaktera");
//        if($imageSize > 4000000)
//            array_push($errors,"Slika mora biti manja od 4 MB");
//        if(!in_array($imageType,$types))
//            array_push($errors,"Tip slike nije podrzan");
//        if(count($errors) > 0 ) {
//            foreach ($errors as $error) {
//                echo "<script>alert($error);</script>";
//                $code=422;
//            }
//        }
//        else {
//            $name = time().$imageName;
//            $path = "../images/".$name;
//            move_uploaded_file($imageTmp,$path);
//            $slika = "images/$name";
//            $sql = "UPDATE vest SET vest_naziv=:naziv, vest_tekst=:tekst, slika=:slika ,obrisan=:obrisan WHERE ID_vest = :ID";
//            $prepare = $connection->prepare($sql);
//            $prepare->bindParam(":naziv",$heading);
//            $prepare->bindParam(":tekst",$text);
//            $prepare->bindParam(":ID",$ID);
//            $prepare->bindParam(":obrisan",$status);
//            $prepare->bindParam(":slika",$slika);
//            try{
//                $code =  $prepare->execute() ? 204: 500;
//                echo "<script>alert('Uspesno izmenja vest!');</script>";
//            }
//            catch(PDOException $e){
//                $e->getMessage();
//                $code=409;
//            }
//
//        }
//    }
//    http_response_code($code);