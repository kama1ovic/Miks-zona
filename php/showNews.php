<?php
session_start();
require "connection.php";
$code = 404;
if(isset($_GET['btn'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM vest WHERE ID_vest = :vest";
    $prepare = $connection->prepare($query);
    $prepare->bindParam(":vest", $id);
    try {
        $code = $prepare->execute() ? 200 : 500;
        $sum = $prepare->fetchAll();
        header("Content-type:application/json");
        if(isset($_SESSION['user'])) {
            $data = ["sesija" => $_SESSION['user'],"vesti" => $sum];
            echo json_encode($data);
        }
        else{
            echo json_encode($sum);
        }
    }
    catch (PDOException $exc) {
        $exc->getMessage();
    }
}
http_response_code($code);