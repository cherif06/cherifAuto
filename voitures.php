 <?php 
  session_start();
  require_once("fonction.php");
  require_once("PDO.php");

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
    <title>Nos voitures</title>
    <link rel="stylesheet" href="css/voitures.css">
    <link rel="stylesheet" href="css/header_footer.css">
    <link rel="stylesheet" href="css/alerte_notification.css">
    <script src="alerte_notification.js" defer></script>
</head>
<body>

    <div class="alerte_reservation">
        <p>Vous devez etre connecté a votre compte pour reserver une voiture</p>
        <button onclick="window.location.href='compte/connexion.php'" >Se connecter</button> <button onclick="fermer_alerte_reservation()">OK</button>
    </div>   

    <?php require_once("header.php") ?>
    
    <main>
        <div class="texte">
            <h1>Trouvez la voiture ideale</h1>
            <p>
                Vous avez un large choix de vehicules
                allant des SUV aux voitures de sport en passant par les berlines 
            </p>
        </div>
        <div class="voitures">
        <?php foreach ($voitures as $voiture) : ?>
            <?= update_statut_voiture($voiture['id_voiture'],$connect) ?>
            <div class="voiture">
            <form action="reserver.php" method="get">
                <div class="marque">
                    <?= $voiture['marque'] ?>
                    <input type="hidden" name="id_voiture" value="<?= $voiture['id_voiture'] ?>">
                    <input type="hidden" name="marque" value="<?= $voiture['marque'] ?>">
                </div>
                <div class="img">
                    <img src="<?= $voiture['chemin_image'] ?>">
                    <input type="hidden" name="chemin_image" value="<?= $voiture['chemin_image'] ?>">
                </div>
                <div class="detail">
                    <div class="modele">
                        <?= $voiture['modele'] ?>
                        <input type="hidden" name="modele" value="<?= $voiture['modele'] ?>">
                    </div>
                    <div class="annee">
                        Année: <?= $voiture['annee_fabrication'] ?>
                    </div>
                    <div class="plaque">
                        <?= $voiture['plaque'] ?>
                        <input type="hidden" name="plaque" value="<?= $voiture['plaque'] ?>">
                    </div>
                    <div class="statut">
                        Statut: <span><?= $voiture['statut'] ?></span>
                    </div>
                    <div class="prix">
                        <?= nice($voiture['prix']) ?>
                        <input type="hidden" name="prix" value="<?= $voiture['prix'] ?>">
                    </div>
                    <?php if($voiture['statut'] == "Disponible") : ?>
                        <?php if($_SESSION['LOGGED']==true) : ?>
                            <button type="submit">Reserver</button>
                        <?php else : ?>
                            <button type="button" onclick="alerte_reservation()">Reserver</button>
                        <?php endif;
                    endif; ?> 
                </div>
            </form>
            </div>
        <?php endforeach; ?>
        </div> 
    </main>

  <?php require_once('footer.php'); ?>

  <?php if(isset($_SESSION['message'])) : ?>
        <div class="notification">
            <p><?= $_SESSION['message'] ?></p>
        </div>
    <?php notifier();unset($_SESSION['message']); endif; ?>
   
</body>
</html>