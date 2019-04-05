<?php
    session_start();
    require "connection.php";
    if(isset($_POST["btn"])) {
        $subcat = $_POST['subcategory'];
        $text = $_POST['text'];
        $heading = $_POST['heading'];
        $image = $_FILES['img'];
        $imageName = $image['name'];
        $imageType = $image['type'];
        $imageSize = $image['size'];
        $imageTmp = $image['tmp_name'];
        $types = ["image/jpg", "image/jpeg", "image/gif", "image/png"];
        $errors = [];
        if($subcat == null)
            array_push($errors, "Niste odabrali kategoriju!");
        if (strlen($heading) > 60)
            array_push($errors, "Naslov je predugačak!");
        if(strlen($heading) < 5 )
            array_push($errors, "Naslov je prekratak!");
        if (strlen($text) < 15)
            array_push($errors, "Tekst mora imati najmanje 15 karaktera!");
        if ($imageSize > 4000000)
            array_push($errors, "Slika mora biti manja od 4 MB!");
        if (!in_array($imageType, $types) && ($imageName !== ""))
            array_push($errors, "Tip slike nije podrzan!");
        if($imageName === "")
            array_push($errors, "Slika nije odabrana!");
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $_SESSION['errors'] = $errors;
                header("Location:".$_SERVER["HTTP_REFERER"]);
            }
        }
        else {
            $name = time() . $imageName;
            $path = "../images/" . $name;
            move_uploaded_file($imageTmp, $path);
            $slika = "images/$name";
            $date = date("d.m.Y");
            $sql = "INSERT INTO vest (vest_naziv,vest_tekst,ID_link,datum,slika) VALUES (:naziv,:tekst,:ID,:datum,:slika)";
            $prepare = $connection->prepare($sql);
            $prepare->bindParam(":naziv", $heading);
            $prepare->bindParam(":tekst", $text);
            $prepare->bindParam(":ID", $subcat);
            $prepare->bindParam(":datum", $date);
            $prepare->bindParam(":slika", $slika);
            header("Location:".$_SERVER["HTTP_REFERER"]);
            try {
                $prepare->execute();
                $_SESSION['ok'] = "Uspešno ste dodali vest";
                header("Location:".$_SERVER['HTTP_REFERER']);
            }
            catch (PDOException $e) {
                $e->getMessage();
            }
        }
    }