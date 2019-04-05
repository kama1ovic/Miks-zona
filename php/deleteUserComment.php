<?php
require "connection.php";
$code = 404;
if(isset($_POST['click'])){
    $com = $_POST['com'];
    $user = $_POST['user'];
    $query = "DELETE FROM glasanje WHERE ID_komentar = :comG AND ID_korisnik = :userG ";
    $query2 = "DELETE FROM komentar WHERE ID_komentar = :comK AND ID_korisnik = :userK";
    $prepare = $connection->prepare($query);
    $prepare2 = $connection->prepare($query2);
    $prepare->bindParam(":userG",$user);
    $prepare->bindParam(":comG",$com);
    $prepare2->bindParam(":comK",$com);
    $prepare2->bindParam(":userK",$user);
    try {
        $connection->beginTransaction();
        $prepare->execute();
        $prepare2->execute();
        $code = $connection->commit() ? 204 : 500;
    }
    catch (PDOException $e){
        $connection->rollBack();
        $code = 409;
        $e->getMessage();
    }
}
http_response_code($code);