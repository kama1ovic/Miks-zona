<?php
include "connection.php";
$code = 404;
    if(isset($_POST['btn'])) :
        $id = $_POST['id'];
        $sql = "UPDATE korisnik SET obrisan = 1 WHERE ID_korisnik =:id";
        $prepare = $connection->prepare($sql);
        $prepare->bindParam(":id",$id);
        try{
            $code = $prepare->execute() ? 204 : 500;
        }
        catch (PDOException $PDOException) {
            $PDOException->getMessage();
            $code = 409;
        }
    endif;
http_response_code($code);