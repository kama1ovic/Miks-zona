<?php
require "connection.php";
if(isset($_POST["btn"]) && $_SERVER["REQUEST_METHOD"]  == "POST") {
    $category = trim($_POST["category"]);
    $reCategory = "/^[A-ZŽĆČŠĐ][a-zšđčćž]{2,15}(\s[a-zšđčćž]{2,15})*$/";
    $errors = [];
    if (!preg_match($reCategory, $category)) {
        array_push($errors, "Ime mora početi velikim slovom!<br/>Ime ne sme biti kraće od 3 i duže od 16 karaktera!");
    }
    if (count($errors) > 0) {

        foreach ($errors as $item) {
            echo "<p class='false er'>{$item}</p>";
        }
    }
    else {
        $putanja = "?page=".strtolower($category);
        $query = "INSERT INTO link (naziv,putanja,ID_link_parent) VALUES(:naziv, :putanja, 0)";

        $prepare = $connection->prepare($query);

        $prepare->bindParam(":naziv", $category);
        $prepare->bindParam(":putanja", $putanja);
        try {
            $code = $prepare->execute() ? 201 : 500;
        }
        catch (PDOException $e) {
            $data = $e->getMessage();
            $code = 409;
        }
    }
    http_response_code($code);
}