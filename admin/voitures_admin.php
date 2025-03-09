<?php 
  session_start();
  require_once("../fonction.php");
  require_once("../PDO.php");

  $sql = "SELECT * FROM voitures ";
  $requete = $connect->prepare($sql);
  $requete->execute();
  $voitures=$requete->fetchAll();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voitures</title>
    <link rel="stylesheet" href="../css/alerte_notification.css">
    <link rel="stylesheet" href="../css/header_footer.css">
    <link rel="stylesheet" href="../css/voitures_admin.css">
</head>
<body>
     <?php require_once('navbar.php') ?>

    <main>
            <div class="ajout_voiture">
            <a href="enregistrement_voiture.php">
                <span>+</span>
                <p>Ajouter une voiture</p>
            </a>
            </div>
        <?php foreach ($voitures as $voiture) : ?>
            <?= update_statut_voiture($voiture['id_voiture'],$connect) ?>
            <div class="voiture">
            <form action="modification_voiture.php"  method="get">
                <div class="marque">
                    <?= $voiture['marque'] ?>
                    <input type="hidden" name="id_voiture" value="<?= $voiture['id_voiture'] ?>">
                    <input type="hidden" name="marque" value="<?= $voiture['marque'] ?>">
                </div>
                <div class="img">
                    <img src="../<?= $voiture['chemin_image'] ?>">
                    <input type="hidden" name="chemin_image" value="../<?= $voiture['chemin_image'] ?>">
                </div>
                <div class="detail">
                    <div class="modele">
                        <?= $voiture['modele'] ?>
                        <input type="hidden" name="modele" value="<?= $voiture['modele'] ?>">
                    </div>
                    <div class="annee">
                        Année: <?= $voiture['annee_fabrication'] ?>
                        <input type="hidden" name="annee" value="<?= $voiture['annee_fabrication'] ?>">
                    </div>
                    <div class="plaque">
                        <?= $voiture['plaque'] ?>
                        <input type="hidden" name="plaque" value="<?= $voiture['plaque'] ?>">
                    </div>
                    <div class="statut">
                        Statut: <span><?= $voiture['statut'] ?></span>
                        <input type="hidden" name="statut" value="<?= $voiture['statut'] ?>">
                    </div>
                    <div class="prix">
                        <?= nice($voiture['prix']) ?>
                        <input type="hidden" name="prix" value="<?= $voiture['prix'] ?>">
                    </div>
                    <button type="submit" name="modifier">Modifier</button>
                    <button type="submit" name="supprimer">Supprimer</button>
                    <?php if($voiture['statut'] == 'Louée') : ?>
                        <a href="reservations_admin.php#<?= getid_reservation($voiture['id_voiture'],$connect) ?>"><button type="button" class="vr">Voir la reservation</button></a>
                    <?php endif; ?>
                </div>
            </form>
            </div>
        <?php endforeach; ?>
        <?php if(isset($_SESSION['message'])) : ?>
        <div class="notification">
            <p><?= $_SESSION['message'] ?></p>
        </div>
        <?php notifier();unset($_SESSION['message']); endif; ?>
    </main>

    
</body>
</html>