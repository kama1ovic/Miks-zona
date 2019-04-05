<?php
require "connection.php";
$code = 404;
if(isset($_GET['click'])){
    $ID = $_GET['id'];
    $query = "SELECT *, km.datum AS kom_datum FROM korisnik k INNER JOIN komentar km ON k.ID_korisnik = km.ID_korisnik INNER JOIN vest v ON v.ID_vest = km.ID_vest WHERE km.ID_korisnik = :ID ORDER BY km.datum DESC";
    $prepare = $connection->prepare($query);
    $prepare->bindParam(":ID",$ID);
    try {
        $code = $prepare->execute() ? 200 : 500;
        $sum = $prepare->fetchAll();
        header("Content-type:application/json");
        echo json_encode($sum);
    }
    catch (PDOException $e){
        $code = 409;
        $e->getMessage();
    }
}