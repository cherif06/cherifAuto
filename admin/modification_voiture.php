<?php 
  session_start();
  require_once("../fonction.php");
  require_once("../PDO.php");

  if(isset($_GET['supprimer'])){
    supprimer_voiture($_GET['id_voiture'],$connect);
    $_SESSION['message'] = 'Voiture supprimmée';
    RedirectToUrl('voitures_admin.php');
    exit;
  }

  if(isset($_POST['modifier'])){

    if(empty(trim($_POST['plaque'])) || empty(trim($_POST['prix']))){
        $php_errormsg = 'Veuillez entrez toutes les nouvelles informations';
    }else{
        $sql="UPDATE voitures SET statut = ?, plaque = ?, prix = ? WHERE id_voiture = ?";
        $requete = $connect->prepare($sql);
        $test=$requete->execute([$_POST['statut'],$_POST['plaque'],$_POST['prix'],$_GET['id_voiture']]);
        if($test){
            $_SESSION['message'] = 'Voiture modifiée';
            RedirectToUrl('voitures_admin.php');
            exit;
        }
        $_SESSION['message'] = 'Erreur lors de la modification dans la base de données';
        RedirectToUrl('voitures_admin.php');
        exit;
    }
  }





?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification voiture</title>
    <link rel="stylesheet" href="../css/alerte_notification.css">
    <link rel="stylesheet" href="../css/modif_voiture.css">
    <link rel="stylesheet" href="../css/header_footer.css">
</head>
<body>

  <?= require_once('navbar.php') ?>

  <main class="reservation">
    <div class="titre">
        <a href="dashboard.php"><img src="../img/logo.png" alt=""></a>
        <h1>Modifier</h1>
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
                <div class="annee">
                    <label for="annee">Année de fabrication : </label>
                    <input type="text" name="annee" value="<?= $_GET['annee'] ?>" readonly>
                </div>
                <div class="plaque">
                    <label for="plaque">Plaque d'immatriculation : </label>
                    <input type="text" name="plaque" value="<?= $_GET['plaque'] ?>">
                </div>
                <div class="statut">
                    <label for="statut">Statut : </label>
                    <select name="statut" >
                        <option value="<?= $_GET['statut'] ?>" selected ><?= $_GET['statut'] ?></option>
                        <?php if($_GET['statut'] == 'disponible') :?>
                        <option value="En maintenance">En maintenance</option>
                        <?php endif; ?>
                        <?php if($_GET['statut'] == 'En maintenance') :?>
                        <option value="Disponible">Disponible</option>
                        <?php endif; ?>
                        <?php if($_GET['statut'] == 'Louée') :?>
                        <option value="Disponible">Disponible</option>
                        <option value="En maintenance">En maintenance</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="prix">
                    <label for="prix">Prix : </label>
                    <input type="number" name="prix" value="<?= $_GET['prix']?>"><span>fcfa/jour</span>
                </div>
                <button type="submit" name="modifier">Modifier</button>
                <a href="voitures_admin.php"><button type="button">Annuler</button></a> 
                <?php if(isset($php_errormsg)) : ?>
                    <p><?= $php_errormsg ?></p>
                <?php endif; ?>
            </form>
        </div>   
    </div>
  </main>
    
</body>
</html>