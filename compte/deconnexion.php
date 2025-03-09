<?php 
    session_start();
    require_once('../fonction.php');

    $_SESSION['LOGGED'] = false;
    $_SESSION['message'] = "Vous etes deconnecté de votre compte";
    unset($_SESSION['USER']);
    RedirectToUrl("../index.php")
?> 
