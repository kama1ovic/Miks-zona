<?php
    session_start();
    $code = 404;
    require "connection.php";
    if(isset($_GET['btn'])){
        $ID = $_GET['id'];
        $query = "SELECT *, k.ID_korisnik AS bingo FROM vest v INNER JOIN komentar k ON v.ID_vest=k.ID_vest INNER JOIN korisnik kr ON kr.ID_korisnik=k.ID_korisnik  WHERE v.ID_vest = :ID  ORDER BY k.datum DESC";
        $prepare = $connection->prepare($query);
        $prepare->bindParam(":ID",$ID);

        try {
            $code = $prepare->execute() ? 200 :500;
            $sum = $prepare->fetchAll();
            header("Content-type:application/json");
            if (isset($_SESSION['user'])) {
                $data = ["sesija" => $_SESSION['user'], "vesti" => $sum];
                echo json_encode($data);
            } else {
                echo json_encode($sum);
            }
        }
        catch (PDOException $e){
            $code = 409;
            $e->getMessage();
        }
    }
