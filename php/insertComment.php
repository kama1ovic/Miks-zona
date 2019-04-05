<?php
    require "connection.php";
    $code = 404;
    if(isset($_POST['btn'])) {
        $iduser = $_POST['iduser'];
        $idnews = $_POST['idnews'];
        $comment = $_POST['comment'];
        $errors = [];
        if (strlen($comment) < 5 && strlen($comment) > 200)
            array_push($errors, "Greška!");
        if (count($errors) > 0) {
            $code = 422;
        } else {
            $date = date("d.m.Y");
            $query = "INSERT INTO komentar (komentar_tekst,ID_korisnik,ID_vest,datum) VALUES (:komentar,:ID_k,:ID_v,:datum)";
            $prepare = $connection->prepare($query);
            $prepare->bindParam(":komentar", $comment);
            $prepare->bindParam(":ID_k", $iduser);
            $prepare->bindParam(":ID_v", $idnews);
            $prepare->bindParam(":datum", $date);
            try {
                $code = $prepare->execute() ? 201 : 500;
            } catch (PDOException $ex) {
                $code = 409;
                $ex->getMessage();
            }
        }
    }
http_response_code($code);