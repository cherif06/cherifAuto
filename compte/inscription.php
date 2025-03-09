<?php 
  session_start();
  require_once("../fonction.php");
  require_once("../PDO.php");

  if(isset($_POST['inscription'])) {
    

    if(!(empty(trim($_POST["prenom"])) || empty(trim($_POST["nom"])) || empty(trim($_POST["email"])) || empty(trim($_POST["password"])) || empty(trim($_POST["date_naissance"])) || empty(trim($_POST["adresse"])) || empty(trim($_POST["num_permis"])) )){

        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $date_naissance = $_POST["date_naissance"];
        $adresse = $_POST["adresse"];
        $num_permis = $_POST["num_permis"];

        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $php_errormsg = "Email invalide";
        }
        elseif (strlen($password)<6) {
            $php_errormsg = "Le mot de passe doit contenir au moins 6 caractéres";
        }
        else{
            $sql="SELECT email FROM clients";
            $requete = $connect->prepare($sql);
            $requete->execute();
            $match=$requete->fetch();
            if ($match==$email) {
                $php_errormsg = 'Compte deja existant';
            }else{
                $password = password_hash($password, PASSWORD_BCRYPT);
                $sql = "INSERT INTO clients (nom,prenom,email,password,date_naissance,adresse,num_permis) VALUES (?,?,?,?,?,?,?) ";
                $requete = $connect->prepare($sql);
                $insertion = $requete->execute([$nom,$prenom,$email,$password,$date_naissance,$adresse,$num_permis]);
                if($insertion){
                    $_SESSION['message'] = "Compte creé";
                    $_SESSION['LOGGED'] = true;
                    $_SESSION['USER'] = $email;
                    RedirectToUrl("../index.php");
                } else $php_errormsg = "Erreur lors de la creation du compte";
            }
        }

    } else $php_errormsg="Veuillez remplir tout les champs";

  }
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../css/connexion_inscription.css">
</head>
<body>  
    <main class="inscription">
        <div class="form">
            <h1>Créer un compte</h1>
            <form method="post">
                <input type="text" name="prenom" placeholder="Prenom">
                <input type="text" name="nom" placeholder="Nom"><br>
                <input class="email" type="text" name="email" placeholder="Email"><br>
                <input type="password" name="password" placeholder="Mot de passe">
                <input type="date" name="date_naissance"><br>
                <input type="text" name="adresse" placeholder="Adresse">
                <input type="text" name="num_permis" placeholder="Numero permis"><br>
                <button name="inscription">S'inscrire</button>
                <?php if(isset($php_errormsg)) : ?>
                <p><?= $php_errormsg ?></p>
                <?php endif; ?>
            </form>
        </div>
        <div class="texte">
            <div class="logo">
                <a href="../index.php"><img src="../img/logo.png"></a>
            </div>
            <h1>Bienvenue cher client</h1>
            <p class='top'>Entrez vos informations personnelles et commencez votre journée avec nous.</p>
            <p>Vous avez deja un compte !</p>
            <a href="connexion.php"><button>Se connecter</button></a>
        </div>
    </main>
</body>
</html>