<?php
session_start();
require_once('fonction.php');
require_once('PDO.php');

if (!isset($_POST['mess']) || empty(trim($_POST['mess']))) {
    $_SESSION['message'] = 'Le message ne peut pas être vide';
    header('Location: ' . ($_SERVER["HTTP_REFERER"] ?? 'index.php'));
    exit;
}
$date = date("Y-m-d");

if ($_SESSION['LOGGED']) {
    $email = $_SESSION['USER'];
    $nom = getnom_client($email,$connect);
}else{
    if(!(empty(trim($_POST['nom'])) || empty(trim($_POST['email'])))){
        if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = "Email invalide";
            header('Location: ' . ($_SERVER["HTTP_REFERER"] ?? 'index.php'));
            exit;
        }
        $email = $_POST['email'];
        $nom = $_POST['nom'];
    }else{
        $_SESSION['message'] = "Veuillez entrer toutes les informations";
        header('Location: ' . ($_SERVER["HTTP_REFERER"] ?? 'index.php'));
        exit;
    } 

}

try {
    $sql = "INSERT INTO messages (email, date_envoie, message,nom) VALUES (?, ?, ?,?)";
    $requete = $connect->prepare($sql);
    $requete->execute([$email, $date, $_POST['mess'],$nom]);

    $_SESSION['message'] = "Message envoyé avec succès";
} catch (Exception $e) {
    $_SESSION['message'] = "Erreur lors de l'envoi du message : " . $e->getMessage();
}

header('Location: ' . ($_SERVER["HTTP_REFERER"] ?? 'index.php'));
exit;

