  <header>
    <div class="logo">
        <a href="index.php"><img src="img/logo.png" alt="logo"></a>
    </div>
    <div class="option-header">
        <?php if($_SESSION["LOGGED"]) : ?>
        <a href="voitures.php">Offres Voitures</a>
        <a href="reservations.php">Mes Reservations</a>
        <a href="compte/deconnexion.php">Se deconnecter</a>
        <?php else: ?>
        <a href="voitures.php">Offres Voitures</a>
        <a href="compte/connexion.php">Se Connecter</a>
        <a href="compte/inscription.php">Creer un compte</a>
        <?php endif; ?>
    </div>
  </header> 