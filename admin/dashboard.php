<?php
session_start();
require_once("../PDO.php");
require_once("../fonction.php");

$today = date("Y-m-d");

if(isset($_POST['refuser_reservation'])){
    refuser_reservation($_POST['id_reservation'],$connect);
}
elseif(isset($_POST['confirmer_reservation'])){
    confirmer_reservation($_POST['id_reservation'],$connect);
}

$sql = "SELECT * FROM reservations WHERE statut_reservation = ?";
$requete = $connect->prepare($sql);
$requete->execute(['En attente']);
$reservations = $requete->fetchAll();

$sql = "SELECT * FROM paiements";
$requete = $connect->prepare($sql);
$requete->execute();
$paiements = $requete->fetchAll();
$paiements_recents=array_slice($paiements,-5);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/alerte_notification.css">
    <link rel="stylesheet" href="../css/header_footer.css">
</head>
<body>

    <?php require_once('navbar.php') ?>

    <main>

    <div class="pblocs">

        <div class="pbloc">
            <div class="top">
                <div class="left">
                    <h1><?= nb_messages($connect) ?></h1>
                    <p>MESSAGES</p>
                </div>
                <div class="right">
                    <img src="../img/icone_message.png" alt="">
                </div>
            </div>
            <div class="bottom">
                <a href="messages.php"><button>Voir les messages</button></a>
            </div>
        </div>

        <div class="pbloc">
            <div class="top">
                <div class="left">
                    <h1><?= nb_voitures($connect) ?></h1>
                    <p>VOITURES</p>
                </div>
                <div class="right">
                    <img src="../img/icone_voiture.png" alt="">
                </div>
            </div>
            <div class="bottom">
                <span>Louée: <?= nb_voitures_louee($connect)?></span>
                <span>Disponible: <?= nb_voitures_dispo($connect)?></span>
            </div>
        </div>

        <div class="pbloc">
            <div class="top">
                <div class="left">
                    <h1><?= nb_reservations_att($connect) ?></h1>
                    <p>NOUVELLES RESERVATIONS</p>
                </div>
                <div class="right">
                    <img src="../img/icone_reservation.png" alt="">
                </div>
            </div>
            <div class="bottom">
                <a href="reservations_admin.php"><button>Voir les reservations</button></a>
            </div>
        </div>

        <div class="pbloc">
            <div class="top">
                <div class="left">
                    <h2><?=substr(nice(total_revenu($connect)),0,-5)  ?></h2>
                    <p>REVENU TOTAL</p>
                </div>
                <div class="right">
                    <img src="../img/icone_revenu.png" alt="">
                </div>
            </div>
            <div class="bottom">
                <a href="revenus.php"><button>Voir les revenus</button></a>
            </div>
        </div>

    </div>

    <div class="gblocs">

        <div class="gbloc rsv">
            <div class="entete">
                <h1>Reservations en attente</h1>
                <a href="reservations_admin.php"><button>Voir tout</button></a>
            </div>
            <div class="reservations">
                <?php foreach($reservations as $reservation) :?>
                    <div class="reservation">
                    <form method="post">
                        <div class="detail_reservation">
                            <span class="email"><?= getemail_client($reservation['id_client'],$connect) ?></span>
                            <span class="voiture">Vehicule : <?= info_voiture('marque',$reservation['id_voiture'],$connect).' '.info_voiture('modele',$reservation['id_voiture'],$connect) ?></span>
                            <span class="plaque">Plaque : <?= info_voiture('plaque',$reservation['id_voiture'],$connect) ?></span>
                            <span class="periode">Du <?= $reservation['date_debut'].' au '.$reservation['date_fin'] ?></span>                            
                            <span class="montant"><?= substr(nice($reservation['montant']),0,-5) ?></span>

                        </div>
                        <div class="buttons">
                            <input type="hidden" name="id_reservation" value="<?= $reservation['id_reservation'] ?>">
                            <button name="confirmer_reservation" type="submit">Confirmer</button>
                            <button name="refuser_reservation" type="submit">Refuser</button>
                        </div>
                    </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="gbloc pmt">
            <div class="entete">
                <h1>Paiements recents</h1>
                <a href="revenus.php"><button>Voir tout</button></a>
            </div>
            <div class="paiements">
                <span class="tete">Date</span>
                <span class="tete">Utilisateurs</span>
                <span class="tete">Montant</span>
                <?php foreach($paiements_recents as $paiement) :?>
                        <span><?= $paiement['date_paiement'] ?></span>
                        <span><?= getemail_client(info_reservation('id_client',$paiement['id_reservation'],$connect),$connect) ?></span>
                        <span><?= substr(nice($paiement['montant']),0,-5) ?></span>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <?php if(isset($_SESSION['message'])) : ?>
        <div class="notification">
            <p><?= $_SESSION['message'] ?></p>
        </div>
    <?php notifier();unset($_SESSION['message']); endif; ?>

    </main>

</body>
</html>