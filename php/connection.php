<?php

require_once "config.php";

try{
    $connection = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DATABASE.";charset=utf8",MYSQL_USERNAME,MYSQL_PASSWORD);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    require "functions.php";
}
catch(PDOException $e){
    $e->getMessage();
}



