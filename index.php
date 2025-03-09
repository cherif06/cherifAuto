<?php 
  session_start();
  require_once("fonction.php");

  if(!isset($_SESSION['LOGGED'])) $_SESSION['LOGGED']=false;
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/accueil.css">
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="css/alerte_notification.css">
</head>
<body>

  <?php require_once("header.php") ?>

  <main>
    <div class="partie1">
      <h1>Bienvenue chez cherifAuto</h1>
      <p>Bienvenue chez cherifAuto, votre spécialiste en location de voitures. Que vous ayez besoin 
        d’un véhicule pour un voyage d’affaires, des vacances, un événement spécial ou simplement 
        pour votre quotidien, nous avons la solution adaptée à vos besoins.</p>
    </div>
    <div class="partie2">
      <div class="image">
        <img src="img/groupevoitures.png" alt="">
      </div>
      <div class="texte">
        <h2>Notre large collection de voitures</h2>
        <p>
          Nous offrons une large sélection de véhicules récents et 
          comfortables, des citadines aux voitures de luxe. Nos formules
          flexibles permettent une location à la journée, à la 
          semaine ou au mois, avec des tarifs attractifs et un service
          client dédié.
        </p>
        <a href="voitures.php"><button>Voir nos voitures</button></a>
      </div>
    </div>
    <?php if($_SESSION['LOGGED']) : ?>
      <div class="partie3">
        <p>Garder un oeuil sur vos réservations et l’état de leurs paiements</p>
        <a href="reservations.php"><button>Suivre mes reservations</button></a>
      </div>
    <?php endif; ?>
  </main>

  <?php require_once('footer.php'); ?>

  <?php if(isset($_SESSION['message'])) : ?>
        <div class="notification">
            <p><?= $_SESSION['message'] ?></p>
        </div>
    <?php notifier();unset($_SESSION['message']); endif; ?>

</body>
</html>
