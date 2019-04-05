<?php
//funkcija za select upit
function select($query) {
    global $connection;
    $sum = $connection->query($query)->fetchAll();
    return $sum;
}
//funkcija za dohvatanje strana
function getPages(){
    if(isset($_GET['page']) && !isset($_GET['cat'])){
        $page = $_GET['page'];
        switch ($page){
            case'pocetna':
                include 'views/pocetna.php';
                break;
            case 'kontakt':
                include 'views/kontakt.php';
                break;
            case 'autor':
                include 'views/autor.php';
                break;
        }
    }
    else{
        require 'views/news.php';
    }
}

