<?php
session_start();
require_once("../PDO.php");
require_once("../fonction.php");

if (isset($_POST['ajout'])) {
 
    if(!(empty(trim($_POST["marque"])) || empty(trim($_POST["modele"])) || empty(trim($_POST["annee_fabrication"])) || empty(trim($_POST["plaque"])) || empty(trim($_POST["statut"])) || empty(trim($_POST["prix"])) )){

        $marque = $_POST["marque"];
        $modele = $_POST["modele"];
        $annee_fabrication = $_POST["annee_fabrication"];
        $plaque = $_POST["plaque"];
        $statut = $_POST["statut"];
        $prix = $_POST["prix"];

        

        if(!empty($_FILES['image']['name'])){ 
            
            $file = $_FILES['image'];
            $file_name = $_FILES['image']['name'];
            $file_tmpname = $_FILES['image']['tmp_name'];
            $file_size = $_FILES['image']['size'];
            $file_error = $_FILES['image']['error'];
            $file_type = $_FILES['image']['type'];

            if (!$file_error) {
                $file_type = $_FILES['image']['type'];
                $typesAutorises = ["image/jpg", "image/jpeg", "image/png", "image/gif"];
                if(!in_array($file_type,$typesAutorises)){
                    $php_errormsg = "format d'image invalide";
                }
                elseif ($file_size > 5000000){
                    $php_errormsg = "Image trop volumineuse"; 
                }
                else $chemin_image = 'img/'.basename($file_name);
            } else $php_errormsg = "Erreur lors de l'envoie du fichier";
        } else $chemin_image = "img/defaultcar.png";

        if(!isset($php_errormsg)){
            $sql = "INSERT INTO voitures (marque,modele,annee_fabrication,plaque,statut,prix,chemin_image) VALUES (?,?,?,?,?,?,?) ";
            $requete = $connect->prepare($sql);
            $insertion = $requete->execute([$marque,$modele,$annee_fabrication,$plaque,$statut,$prix,$chemin_image]);
            if($insertion){
                $_SESSION['message'] = "Voiture enregistré";
                if(!isset($php_errormsg)) move_uploaded_file($file_tmpname,'../img/'.basename($file_name));
                RedirectToUrl('voitures_admin.php');       
            } else $php_errormsg = "Erreur lors de la creation du compte";
        }

    }else $php_errormsg = "Veuillez remplir tous les champs";

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer une voiture</title>
    <link rel="stylesheet" href="../css/ajout_voiture.css">
    <link rel="stylesheet" href="../css/alerte_notification.css">
    <link rel="stylesheet" href="../css/header_footer.css">
</head>
<body>

    <?= require_once('navbar.php') ?>

    <main>
        <form  method="post" enctype="multipart/form-data">
            <h1>Nouvelle voiture</h1>
            <input type="text" name="marque" placeholder="Marque"><br>
            <input type="text" name="modele" placeholder="Modele"><br>
            <input type="number" name="annee_fabrication" placeholder="Année de fabrication"><br>
            <input type="text" name="plaque" placeholder="Plaque d'immatriculation"><br>
            <select name="statut">
                <option value="Disponible">Disponible</option>
                <option value="Louée">Louée</option>
                <option value="En maintenance">En maintenance</option>
            </select><br>
            <input class="prix" type="number" name="prix" placeholder="Prix"><span>fcfa/jour</span><br>
            <label for="image">Image du vehicule (facultatif)</label><br>
            <input class="file" type="file" name="image"><br>
            <button type="submit" name="ajout">Enregistrer</button>
            <?php if(isset($php_errormsg)) : ?>
                <p><?= $php_errormsg ?></p>
            <?php endif; ?>
        </form>
    </main>
</body>
</html>