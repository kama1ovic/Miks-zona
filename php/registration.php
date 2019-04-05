<?php
require "connection.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST["btn"]) && $_SERVER["REQUEST_METHOD"]  == "POST") {
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $city = $_POST["city"];
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $passwordConfirm = trim($_POST["passwordConfirm"]);
    $gender = $_POST["gender"];

    $reFirst = "/^([A-ZŠĐČĆŽ][a-zšđčćž\-']{2,15})(\s[A-ZŠĐČĆŽ][a-zšđčćž\-']{2,15})*$/";
    $reLast = "/^([A-ZŠĐČĆŽ][a-zšđčćž\-']{2,25})(\s[A-ZŠĐČĆŽ][a-zšđčćž\-']{2,25})*$/";
    $reEmail = "/^[^@\s]{3,25}@[^@\s]{2,10}\.[^@\s]{2,7}$/";
    $reUsername = "/^[a-zšđčćž0-9]{6,15}$/";
    $rePassword = "/^[A-ZŠĐČĆŽa-zšđčćž?!&^#|$%@*\/0-9]{8,15}$/";
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
    if (!preg_match($rePassword, $password)) {
        array_push($errors, "Lozinka ne sme biti kraća od 8 i duža od 15 karaktera!<br/>Dozvoljeni su specijalni karakteri i velika i mala slova!");
    }
    if (!preg_match($reEmail, $email)) {
        array_push($errors, "Email nije u dobrom formatu!");
    }
    if ($password != $passwordConfirm) {
        array_push($errors, "Lozinke se ne podudaraju!");
    }
    if (empty($passwordConfirm)) {
        array_push($errors, "Morate potvrditi lozinku!");
    }
    if ($city === "0") {
        array_push($errors, "Morate izabrati grad!");
    }
    if (count($errors) > 0) {
        $code=422;
        foreach ($errors as $item) {
            echo "<p class='false er'>" . $item . "</p>";
        }
    }
    else {
        $password = md5($password);
        $time = time();
        $date = date("d.m.Y H:i:s", $time);
        $token = md5($date . $username . $email . time());
        $query = "INSERT INTO korisnik (ime,prezime,email,username,password,token,pol,aktivan,datum_registracije,ID_grad,ID_uloga) VALUES(:ime,:prezime,:email,:username,:password,:token,:pol,0,:datum,:grad,2)";

        $prepare = $connection->prepare($query);

        $prepare->bindParam(":ime", $firstname);
        $prepare->bindParam(":prezime", $lastname);
        $prepare->bindParam(":email", $email);
        $prepare->bindParam(":username", $username);
        $prepare->bindParam(":password", $password);
        $prepare->bindParam(":token", $token);
        $prepare->bindParam(":grad", $city);
        $prepare->bindParam(":pol", $gender);
        $prepare->bindParam(":datum", $date);

        try {
            $code = $prepare->execute() ? 201 : 500;

            if ($code == 201) {

                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                    $mail->isSMTP();                                      // Set mailer to use SMTP
                    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers

                    $mail->SMTPAuth = true;
                    $mail->SMTPSecure = true;
                    // Enable SMTP authentication
                    $mail->Username = 'phpmailer1995@gmail.com';                 // SMTP username
                    $mail->Password = 'dusan1995';                           // SMTP password
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;                                 // TCP port to connect to

                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                    //Recipients
                    $mail->setFrom('phpmailer1995@gmail.com', 'Registracija');
                    $mail->addAddress($email);     // Add a recipient

                    //Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Aktivirajte nalog';

                    $mail->Body = '<a href="https://mikszona.000webhostapp.com/php/activation.php?param=' . $token . '">Kliknite na ovaj link da biste aktivirali nalog</a>';

                    $mail->send();
                }
                catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                }
            }
        }
        catch (PDOException $e) {
            $data = $e->getMessage();
            $code = 409;
        }
    }
    http_response_code($code);
}