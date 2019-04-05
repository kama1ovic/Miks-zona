<?php
require "connection.php";
if(isset($_POST["btn"]) && $_SERVER["REQUEST_METHOD"]  == "POST") {
    $categoryID = $_POST["categoryID"];
    $categoryText = $_POST["categoryText"];
    $subCategory = trim($_POST["subCategory"]);
    $reSubCategory = "/^[A-ZŽĆČŠĐa-zšđčćž]{2,15}(\s[A-ZŽĆČŠĐa-zšđčćž]{2,15})*$/";
    $errors = [];
    if ($categoryID === "0") {
        array_push($errors, "Morate izabrati kategoriju!");
    }
    if (!preg_match($reSubCategory, $subCategory)) {
        array_push($errors, "Ime mora početi velikim slovom!<br/>Ime ne sme biti kraće od 3 i duže od 16 karaktera!");
    }
    if (count($errors) > 0) {
        foreach ($errors as $item) {
            echo "<p class='false er'>" . $item . "</p>";
        }
    }
    else {
        $subCategorySmall = substr($subCategory,0,3);
        $pageToLower = strtolower($categoryText);
        $subCatToLower = strtolower($subCategorySmall);
        $putanja = "?page=".$pageToLower."&cat=".$subCatToLower;
        $query = "INSERT INTO link (naziv,putanja,ID_link_parent) VALUES(:naziv, :putanja,:parent)";

        $prepare = $connection->prepare($query);

        $prepare->bindParam(":naziv", $subCategory);
        $prepare->bindParam(":parent", $categoryID);
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