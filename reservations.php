<?php 
  session_start();
  require_once("PDO.php");
  require_once("fonction.php");
  
  $today = date("Y-m-d");
  $sql = "SELECT * FROM reservations WHERE id_client = ? ";
  $requete = $connect->prepare($sql);
  $requete->execute([getid_client($_SESSION['USER'],$connect)]);
  $reservations = $requete->fetchAll();

  if(isset($_POST['annuler_reservation'])){
    annuler_reservation($_POST['id_reservation'],$connect);
  }
  if(isset($_POST['confirmer_paiement'])){
    $sql = "INSERT INTO paiements (id_reservation,montant,date_paiement,mode_paiement) VALUES (?,?,?,?) ";
    $requete = $connect->prepare($sql);
    $insertion = $requete->execute([$_POST['id_reservation'],$_POST['montant'],$today,$_POST['mode_paiement']]);
    if($insertion){
        $_SESSION['message'] = "Paiement effectué";
    } else{
        $_SESSION['message'] = "Erreur lors de l'enregistrement du paiement";
    } 
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="css/alerte_notification.css">    
    <link rel="stylesheet" href="css/reservations.css">
    <script src="alerte_notification.js"></script>
</head>
<body>

  <?php require_once("header.php") ?>
  
  <main>
    <div class="entete">
        <h1>Mes reservations</h1>
        <p>Toutes vos commandes precedentes et actuelles ainsi 
            que l’etat de leur paiement.
        </p>
    </div>
    <?php if($reservations) :?>
        <div class="reservations">
            <?php foreach($reservations as $reservation) :?>
                <div class="reservation">
                    <div class="image_voiture">
                        <img src="<?= info_voiture('chemin_image',$reservation['id_voiture'],$connect) ?>" >
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
                                <button type="button">En attente</button>
                                <button type="submit" name="annuler_reservation">Annuler</button>
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
                                <p>Date paiement: <?=info_paiement('date_paiement',$reservation['id_reservation'],$connect) ?> </p>
                                <p>Mode de paiement: <?=info_paiement('mode_paiement',$reservation['id_reservation'],$connect) ?> </p>
                            <?php else : ?>
                                <form method="post">                            
                                    <input type="hidden" name="montant" value="<?=$reservation['montant'] ?>">
                                    <input type="hidden" name="id_reservation" value="<?= $reservation['id_reservation'] ?>">
                                    <button id="payer<?=$reservation['id_reservation']?>" type="button" onclick="alerte_paiement(<?=$reservation['id_reservation']?>)">Payer</button>
                                </form>
                                <div class="alerte_paiement" id="<?=$reservation['id_reservation']?>">
                                    <form method="post">
                                        <h3>Mode de paiement</h3>
                                        <select name="mode_paiement"> 
                                            <option value="Par espéce">Par espéce</option>
                                            <option value="Par carte">Par carte</option>
                                            <option value="Par cheque">Par cheque</option>
                                        </select><br>
                                        <input type="hidden" name="montant" value="<?= $reservation['montant'] ?>">
                                        <input type="hidden" name="id_reservation" value="<?= $reservation['id_reservation'] ?>">
                                        <button type="button" onclick="fermer_alerte_paiement(<?=$reservation['id_reservation']?>)">Annuler</button>
                                        <button type="submit" name="confirmer_paiement">Confirmer</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php else : ?>
                            <p><?= $reservation['statut_reservation'] ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else :?>
        <p class="no_reserv">Aucune reservation</p>
    <?php endif;?>
  </main>

  <?php require_once('footer.php'); ?>

  <?php if(isset($_SESSION['message'])) : ?>
        <div class="notification">
            <p><?= $_SESSION['message'] ?></p>
        </div>
    <?php notifier();unset($_SESSION['message']); endif; ?>

</body>
</html>