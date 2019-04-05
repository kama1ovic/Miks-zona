<?php
session_start();
require "connection.php";
if(isset($_POST["image"]) ) {
    $ID = $_POST['ID'];
    $image = $_FILES['img'];
    $imageName = $image['name'];
    $imageType = $image['type'];
    $imageSize = $image['size'];
    $imageTmp = $image['tmp_name'];
    $types = ["image/jpg", "image/jpeg","image/gif","image/png"];
    $errors = [];
    $ok = "Uspešno izmenjena vest";

    if($imageSize > 4000000)
        array_push($errors,"Slika mora biti manja od 4 MB");
    if(!in_array($imageType,$types))
        array_push($errors,"Tip slike nije podrzan");
    if(count($errors) > 0 ) {
        foreach ($errors as $error) {
            $_SESSION['errors'] = $errors;
            header("Location:../spisak-vesti.php");
        }
    }
    else {
        $name = time().$imageName;
        $path = "../images/".$name;
        move_uploaded_file($imageTmp,$path);
        $slika = "images/$name";
        $sql = "UPDATE vest SET slika=:slika WHERE ID_vest = :ID";
        $prepare = $connection->prepare($sql);
        $prepare->bindParam(":slika",$slika);
        $prepare->bindParam(":ID",$ID);
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