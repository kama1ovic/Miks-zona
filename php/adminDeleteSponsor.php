<?php
include "connection.php";
$code = 404;
if(isset($_POST['click'])) :
    $id = $_POST['id'];
    $sql = "DELETE FROM sponzor WHERE ID_sponzor =:id";
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
