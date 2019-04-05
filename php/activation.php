<?php
    if(isset($_GET['param'])) {

    $token = $_GET['param'];

    require "connection.php";
    $upit = "SELECT * FROM korisnik WHERE token = :token";
    $prepare = $connection->prepare($upit);

    $prepare->bindParam(":token", $token);
    try {
        $sum = $prepare->execute();
        if ($sum) {
            $user = $prepare->fetch();
            if (empty($user))
                header("register.php");
            else {
                $query = " UPDATE korisnik SET aktivan = 1 WHERE token=:token";
                $prepare = $connection->prepare($query);
                $prepare->bindParam(":token", $token);
                $sum = $prepare->execute();
            }
            if ($sum)
                header("Location:prijava.php");
            else
                header("Location:greska.php");
        }
    } catch (PDOException $PDOException) {
        $PDOException->getMessage();
    }
}
?>