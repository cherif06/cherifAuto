<?php 
  session_start();
  require_once("../fonction.php");
  require_once("../PDO.php");
  
  if(isset($_POST['connexion'])) {
    
    if(!(empty(trim($_POST["email"])) || empty(trim($_POST["password"])) )){

        $email = $_POST["email"];
        $password = $_POST["password"];

        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $php_errormsg = "Email invalide";
        }
        elseif (strlen($password)<6) {
            $php_errormsg = "Le mot de passe doit contenir au moins 6 caractéres";
        }
        else{
            $sql="SELECT password FROM clients WHERE email = ?";
            $requete = $connect->prepare($sql);
            $requete->execute([$email]);
            $match=$requete->fetch();
            if ($match) {
                if (password_verify($password,$match['password'])) {
                    $_SESSION['message'] = "Vous etes connectés à votre compte";
                    $_SESSION['LOGGED'] = true;
                    $_SESSION['USER'] = $email;
                    RedirectToUrl("../index.php");  
                }else $php_errormsg = 'Mot de passe incorrect';
            }
            else {
                $sql="SELECT * FROM administrateurs WHERE email = ? AND password = ? ";
                $requete = $connect->prepare($sql);
                $requete->execute([$email,$password]);
                $match=$requete->fetch();
                if ($match){
                    $_SESSION['message'] = "Vous etes connectés à un compte administrateur";
                    RedirectToUrl("../admin/dashboard.php"); 
                }else{
                    $php_errormsg = 'Compte inexistant';
                }
                
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
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/connexion_inscription.css">
</head>
<body>
    <main class="connexion">
        <div class="texte">
            <div class="logo">
                <a href="../index.php"><img src="../img/logo.png"></a>
            </div>
            <h1>Content de vous revoir</h1>
            <p class="top">Entrez vos identifiants pour vous connecter.</p>
            <p>Pas encore de compte !</p>
            <a href="inscription.php"><button>Créer un compte</button></a>
        </div>
        <div class="form">
            <h1>Se connecter</h1>
            <form method="post">
                <input type="text" name="email" placeholder="Email"><br>
                <input type="password" name="password" placeholder="Mot de passe"><br>
                <button name="connexion">Se connecter</button>
                <?php if(isset($php_errormsg)) : ?>
                <p><?= $php_errormsg ?></p>
                <?php endif; ?>
            </form>
            <a id="admin" href="../admin/dashboard.php">Acceder a l'interface admin</a>
        </div>
    </main>
</body>
</html>