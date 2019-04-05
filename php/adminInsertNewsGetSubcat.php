<?php
require "connection.php";
$code = 404;
if(isset($_GET['change'])){
    $category = $_GET['cat'];
    $query = "SELECT * FROM link WHERE ID_link_parent=:cat";
    $prepare = $connection->prepare($query);
    $prepare->bindParam(":cat",$category);
    try{
        $code = $prepare->execute() ? 200 : 500;
        $sum = $prepare->fetchAll();
        echo json_encode($sum);
    }
    catch(PDOException $exception){
        $exception->getMessage();
        $code = 409;
    }
}