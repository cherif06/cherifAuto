<?php
session_start();
require_once("../PDO.php");
require_once("../fonction.php");

$sql = "SELECT * FROM messages";
$requete = $connect->prepare($sql);
$requete->execute();
$messages = $requete->fetchAll();



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="../css/alerte_notification.css">
    <link rel="stylesheet" href="../css/header_footer.css">
    <link rel="stylesheet" href="../css/messages.css">
</head>
<body>
     <?php require_once('navbar.php') ?>

    <main>

        <?php if($messages) : ?>
            <div class="messages">
                <?php foreach($messages as $message) :?>
                    <div class="message">
                        <div class="detail_message">
                            <h1>De <?= $message['nom'] ?></h1>
                            <p><?= age_message($message['date_envoie']) ?></p>
                        </div>
                        <div class="contenu_message">
                            <p><?= $message['message'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="sansmess">Aucun message </p>
        <?php endif; ?>

        <?php if(isset($_SESSION['message'])) : ?>
        <div class="notification">
            <p><?= $_SESSION['message'] ?></p>
        </div>
        <?php notifier();unset($_SESSION['message']); endif; ?>
    </main>

    
</body>
</html>