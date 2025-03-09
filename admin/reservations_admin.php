<?php 
session_start();
require_once("../PDO.php");
require_once("../fonction.php");

if(isset($_POST['refuser_reservation'])){
    refuser_reservation($_POST['id_reservation'],$connect);
}
elseif(isset($_POST['confirmer_reservation'])){
    confirmer_reservation($_POST['id_reservation'],$connect);
}


$sql = "SELECT * FROM reservations";
$requete = $connect->prepare($sql);
$requete->execute();
$reservations = $requete->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les reservations</title>
    <link rel="stylesheet" href="../css/alerte_notification.css">
    <link rel="stylesheet" href="../css/header_footer.css">
    <link rel="stylesheet" href="../css/reservations_admin.css">
</head>
<body>
   
    <?php require_once('navbar.php') ?>

    <main>
    <?php if($reservations) :?>
        <div class="reservations" >
            <?php foreach($reservations as $reservation) :?>
            <div class="bloc">
                <div class="entete">
                    <h2><?= getemail_client($reservation['id_client'],$connect) ?></h2>
                </div>
                <div class="reservation" id="<?=$reservation['id_reservation']?>">
                    <div class="image_voiture">
                        <img src="../<?= info_voiture('chemin_image',$reservation['id_voiture'],$connect) ?>" >
                    </div> 
                    <div class="detail_reservation">
                    <form  method="post">
                        <div class="marque">
                            <input type="hidden" name="id_reservation" value="<?= $reservation['id_reservation'] ?>">
                            <label for="">Marque:</label>
                            <input type="text" value="<?= info_voiture('marque',$reservation['id_voiture'],$connect) ?>" readonly>
                        </div>
                        <div class="modele">
                            <label for="">Modele:</label>
                            <input type="text" value="<?= info_voiture('modele',$reservation['id_voiture'],$connect) ?>" readonly>
                        </div>
                        <div class="plaque">
                            <label for="">Plaque d'immatriculation:</label>
                            <input type="text" value="<?= info_voiture('plaque',$reservation['id_voiture'],$connect) ?>" readonly>
                        </div>
                        <div class="date_debut">
                            <label for="">Date de debut:</label>
                            <input type="text" value="<?= $reservation['date_debut'] ?>" readonly>
                        </div>
                        <div class="date_fin">
                            <label for="">Date de fin:</label>
                            <input type="text" value="<?= $reservation['date_fin'] ?>" readonly>
                        </div>
                        <div class="buttons">
                            <?php if($reservation['statut_reservation'] == 'En attente'): ?>
                                <button type="submit" name="refuser_reservation">Refuser</button>
                                <button type="submit" name="confirmer_reservation">Confirmer</button>
                            <?php else: ?>
                                <button type="button"><?= $reservation['statut_reservation'] ?></button>
                            <?php endif; ?>
                        </div>
                    </form>
                    </div>
                    <div class="paiement">
                        <h2>Paiement</h2>
                        <p>Montant: <?= substr(nice($reservation['montant']),0,-5) ?></p>
                        <?php if($reservation['statut_reservation'] == 'Confirmée') :?>
                            <?php if(verifier_paiement($reservation['id_reservation'],$connect)) :?>
                                <p>Date paiement:  <?=info_paiement('date_paiement',$reservation['id_reservation'],$connect) ?></p>
                                <p>Mode de paiement: <?=info_paiement('mode_paiement',$reservation['id_reservation'],$connect) ?> </p>
                            <?php else : ?>
                                <p>Paiement en attente</p>
                            <?php endif; ?>
                        <?php else : ?>
                            <p><?= $reservation['statut_reservation'] ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else :?>
        <p class="no_reserv" >Aucune reservation</p>
    <?php endif;?>

        <?php if(isset($_SESSION['message'])) : ?>
        <div class="notification">
            <p><?= $_SESSION['message'] ?></p>
        </div>
    <?php notifier();unset($_SESSION['message']); endif; ?>

  </main>
   
</body>
</html>