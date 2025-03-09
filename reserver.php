<?php 
  session_start();
  require_once("PDO.php");
  require_once("fonction.php");
  $today = date("Y-m-d");

  if(isset($_POST['reserver'])){
    if(empty($_POST['date_debut']) || empty($_POST['date_fin'])){
        $php_errormsg = "Veuillez renseigner la periode de location "; 
    }else{
        $debut = new DateTime($_POST['date_debut']);
        $fin = new DateTime($_POST['date_fin']);
        if($debut >= $fin){
            $php_errormsg = "Erreur sur les dates";
        }
        else{
            $nbjour = ($debut->diff($fin))->days;
            $prix_reservation = $nbjour * (int)$_GET['prix'];
         }
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire une reservation</title>
    <link rel="stylesheet" href="css/alerte_notification.css">
    <link rel="stylesheet" href="css/connexion_inscription.css">
    <script src="alerte_notification.js" defer>document.querySelector('.form button').disabled = false;</script>
</head>
<body>
    <main class="reservation">
        <div class="titre">
            <a href="index.php"><img src="img/logo.png" alt=""></a>
            <h1>Reservation</h1>
        </div>
        <div class="corps">
            <div class="image-voiture">
                <img src="<?= $_GET['chemin_image'] ?>">
            </div>
            <div class="form">
                <form method="post">
                    <div class="marque">
                        <label for="marque">Marque : </label>
                        <input type="text" name="marque" value="<?= $_GET['marque'] ?>" readonly>
                    </div>
                    <div class="modele">
                        <label for="modele">Modele : </label>
                        <input type="text" name="modele" value="<?= $_GET['modele'] ?>" readonly>
                    </div>
                    <div class="plaque">
                        <label for="plaque">Plaque d'immatriculation : </label>
                        <input type="text" name="plaque" value="<?= $_GET['plaque'] ?>" readonly>
                    </div>
                    <div class="date_debut">
                        <label for="date_debut">Date de debut : </label>
                        <input type="date" min="<?= $today ?>" name="date_debut">
                    </div>
                    <div class="date_fin">
                        <label for="date_fin">Date de fin : </label>
                        <input type="date" min="<?= $today ?>" name="date_fin">
                    </div>
                    <div class="prix">
                        <label for="prix">Prix : </label>
                        <input type="hidden" name="prix" value="<?= $_GET['prix']?>">
                        <input type="text" value="<?= nice($_GET['prix'])?>" readonly>
                    </div>
                    <button type="submit" name="reserver">Reserver</button> 
                    <?php if(isset($php_errormsg)) : ?>
                        <p><?= $php_errormsg ?></p>
                    <?php endif; ?>
                </form>
            </div>   
        </div>
        
    </main>
    <?php if(isset($prix_reservation)) : ?>
        <div class="alerte_prix">
            <script>document.querySelector('.form button').disabled = true;</script>
            <form action="enregistrer_reservation.php" method="post">
                <input type="hidden" name="id_voiture" value="<?= $_GET['id_voiture'] ?>">
                <input type="hidden" name="date_debut" value="<?= $_POST['date_debut']?>">
                <input type="hidden" name="date_fin" value="<?= $_POST['date_fin']?>">
                <input type="hidden" name="prix" value="<?= $prix_reservation?>">
                <p>Le total de la reservation est de <?= substr(nice($prix_reservation),0,-5) ?></p>
                <button type="submit" name="enregistrer">Confirmer</button> <button type="button" onclick="fermer_alerte_prix()">Annuler</button>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>