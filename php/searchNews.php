<?php
session_start();
require "connection.php";
$code = 404;
if(isset($_GET['btn'])) {
    $news = $_GET['news'];
    $query= "SELECT * FROM vest WHERE vest_naziv LIKE '%$news%'";
    try {
        $sum = select($query);
        $code = 200;
        header("Content-type:application/json");
        if(isset($_SESSION['user'])) {
            $data = ["sesija" => $_SESSION['user'],"vesti" => $sum];
            echo json_encode($data);
        }
        else{
            echo json_encode($sum);
        }
        if (empty($sum)) {
            $queryAlt = "SELECT * FROM vest ORDER BY datum DESC LIMIT 6";
            $sumAlt = select($queryAlt);
            header("Content-type:application/json");
            if(isset($_SESSION['user'])) {
                $data = ["sesija" => $_SESSION['user'],"vesti" => $sumAlt];
                echo json_encode($data);
            }
            else{
                echo json_encode($sumAlt);
            }
        }
    }
    catch(PDOException $exception){
        $code = 500;
        $exception->getMessage();
    }
}
http_response_code($code);