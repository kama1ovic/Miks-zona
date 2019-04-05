<?php
    session_start();
    require "connection.php";
    if(isset($_POST["btn"]) && $_SERVER["REQUEST_METHOD"]  == "POST") {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $errors = [];
        $reUsername = "/^[a-zšđčćž0-9]{6,15}$/";
        $rePassword = "/^[A-ZŠĐČĆŽa-zšđčćž?!&^#|$%@*\/0-9]{8,15}$/";
        if (!preg_match($reUsername, $username)) {
            array_push($errors, "Korisničko ime ne sme biti kraće od 6 i duže od 15 karaktera!<br/>Dozvoljena su mala slova i brojevi!");
        }
        if (!preg_match($rePassword, $password)) {
            array_push($errors, "Lozinka ne sme biti kraća od 8 i duža od 15 karaktera!<br/> Dozvoljeni su specijalni karakteri i velika i mala slova!");
        }
        if (count($errors) > 0) {
            foreach ($errors as $item) {
               echo "<p class='false er'>" . $item . "</p>";
            }
        }
        else {
            $password = md5($password);
            $query = "SELECT * FROM korisnik WHERE username=:username AND password=:password AND aktivan=1 AND obrisan=0";
            $prepare = $connection->prepare($query);
            $prepare->bindParam(":username", $username);
            $prepare->bindParam(":password", $password);
            try {
                $sum = $prepare->execute();
                if ($sum) {
                    if ($prepare->rowCount() == 1) {
                        $user = $prepare->fetch();
                        $_SESSION['user'] = $user;

                    }
                    else
                        $code = 401;
                }
                else
                    $code=401;
            }
            catch (PDOException $e) {
                $e->getMessage();
                $code = 501;
            }
        }
        http_response_code($code);
    }