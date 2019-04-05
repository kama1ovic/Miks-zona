<?php
 require "connection.php";
 $code = 404;
 if(isset($_POST['click'])) {
     $news = $_POST['news'];
     $user = $_POST['user'];
     $com = $_POST['com'];
     $query = "UPDATE komentar SET komentar_like=komentar_like+1 WHERE ID_komentar = :komentar";
     $query2 = "INSERT INTO glasanje (ID_komentar, ID_korisnik) VALUES(:korisnikG, :komentarG)";
     $prepare = $connection->prepare($query);
     $prepare2 = $connection->prepare($query2);
     $prepare2->bindParam(":korisnikG",$user);
     $prepare->bindParam(":komentar",$com);
     $prepare2->bindParam(":komentarG",$com);
     try {
             $connection->beginTransaction();
             $prepare->execute();
             $prepare2->execute();
             $code = $connection->commit() ? 204 : 500;
     } catch (PDOException $exception) {
             $connection->rollBack();
             $exception->getMessage();
             $code = 409;
     }
 }
http_response_code($code);