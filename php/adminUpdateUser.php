<?php
require "connection.php";
if(isset($_POST["btn"])) {
    $ID = $_POST['ID'];
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $city = $_POST["city"];
    $roll = $_POST["roll"];
    $active = $_POST["active"];
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $gender = $_POST["gender"];
    $status = $_POST["status"];

    $reFirst = "/^([A-ZŠĐČĆŽ][a-zšđčćž\-']{2,15})(\s[A-ZŠĐČĆŽ][a-zšđčćž\-']{2,15})*$/";
    $reLast = "/^([A-ZŠĐČĆŽ][a-zšđčćž\-']{2,25})(\s[A-ZŠĐČĆŽ][a-zšđčćž\-']{2,25})*$/";
    $reEmail = "/^[^@\s]{3,25}@[^@\s]{2,10}\.[^@\s]{2,7}$/";
    $reUsername = "/^[a-zšđčćž0-9]{6,15}$/";
    $errors = [];

    if (!preg_match($reFirst, $firstname)) {
        array_push($errors, "Ime mora početi velikim slovom!<br/>Ime ne sme biti kraće od 3 i duže od 16 karaktera!");
    }
    if (!preg_match($reLast, $lastname)) {
        array_push($errors, "Prezime mora početi velikim slovom!<br/>Prezime ne sme biti kraće od 3 i duže od 26 karaktera!");
    }
    if (!preg_match($reUsername, $username)) {
        array_push($errors, "Korisničko ime ne sme biti kraće od 6 i duže od 15 karaktera!<br/>Dozvoljena su mala slova i brojevi!");
    }
    if (!preg_match($reEmail, $email)) {
        array_push($errors, "Email nije u dobrom formatu!");
    }
    if ($city === "0") {
        array_push($errors, "Morate izabrati grad!");
    }
    if ($roll === "0") {
        array_push($errors, "Morate izabrati ulogu!");
    }
    if ($active === "null") {
        array_push($errors, "Morate izabrati aktivnost!");
    }
    if (count($errors) > 0) {
        $code=422;
        foreach ($errors as $item) {
            echo "<p class='false er'>" . $item . "</p>";
        }
    }
    else {
        $time = time();
        $date = date("d.m.Y H:i:s", $time);
        $query = "UPDATE korisnik SET ime=:ime,prezime=:prezime,email=:email,username=:username, pol=:pol, aktivan=:aktivan, datum_izmene=:datum,obrisan=:obrisan,ID_grad=:grad,ID_uloga=:uloga WHERE ID_korisnik=:ID";

        $prepare = $connection->prepare($query);

        $prepare->bindParam(":ID", $ID);
        $prepare->bindParam(":ime", $firstname);
        $prepare->bindParam(":prezime", $lastname);
        $prepare->bindParam(":email", $email);
        $prepare->bindParam(":username", $username);
        $prepare->bindParam(":grad", $city);
        $prepare->bindParam(":pol", $gender);
        $prepare->bindParam(":datum", $date);
        $prepare->bindParam(":aktivan", $active);
        $prepare->bindParam(":uloga", $roll);
        $prepare->bindParam(":obrisan", $status);
        try {
            $code = $prepare->execute() ? 204 : 500;
        }
        catch (PDOException $e) {
            $data = $e->getMessage();
            $code = 409;
        }
    }
    http_response_code($code);
}