<?php
session_start();
require_once("../PDO.php");
require_once("../fonction.php");

$sql = "SELECT * FROM paiements";
$requete = $connect->prepare($sql);
$requete->execute();
$paiements = $requete->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenus</title>
    <link rel="stylesheet" href="../css/alerte_notification.css">
    <link rel="stylesheet" href="../css/header_footer.css">
    <link rel="stylesheet" href="../css/revenus.css">
</head>
<body>
     <?php require_once('navbar.php') ?>

    <main>

        <div class="pblocs">

        <div class="pbloc">
            <div class="top">
                <div class="left">
                    <h2><?= substr(nice(total_revenu_par('Par carte',$connect)),0,-5) ?></h2>
                    <p>REVENU PAR CARTE</p>
                </div>
                <div class="right">
                    <img src="../img/logo_carte.png" alt="">
                </div>
            </div>
            <div class="bottom">
                <p><span><?= round(total_revenu_par('Par carte',$connect)/total_revenu($connect)*100) ?>%</span> du revenu total</p>
            </div>
        </div>

        <div class="pbloc">
            <div class="top">
                <div class="left">
                    <h2><?= substr(nice(total_revenu_par('Par espéce',$connect)),0,-5) ?></h2>
                    <p>REVENU PAR ESPECES</p>
                </div>
                <div class="right">
                    <img src="../img/logo_espece.png" alt="">
                </div>
            </div>
            <div class="bottom">
                <p><span><?= round(total_revenu_par('Par espéce',$connect)/total_revenu($connect)*100) ?>%</span> du revenu total</p>
            </div>
        </div>

        <div class="pbloc">
            <div class="top">
                <div class="left">
                    <h2><?=substr(nice(total_revenu_par('Par cheque',$connect)),0,-5)  ?></h2>
                    <p>REVENU PAR CHEQUE</p>
                </div>
                <div class="right">
                    <img src="../img/logo_cheque.png" alt="">
                </div>
            </div>
            <div class="bottom">
                <p><span><?= round(total_revenu_par('Par cheque',$connect)/total_revenu($connect)*100) ?>%</span> du revenu total</p>
            </div>
        </div>

    </div>

    <div class="gblocs">

        <div class="gbloc pmt">
            <div class="entete">
                <h1>Paiements</h1>
            </div>
            <div class="paiements">
                <span class="tete">Date</span>
                <span class="tete">Utilisateurs</span>
                <span class="tete">Montant</span>
                <span class="tete">Mode paiement</span>
                <?php foreach($paiements as $paiement) :?>
                        <span><?= $paiement['date_paiement'] ?></span>
                        <span><?= getemail_client(info_reservation('id_client',$paiement['id_reservation'],$connect),$connect) ?></span>
                        <span><?= substr(nice($paiement['montant']),0,-5) ?></span>
                        <span><?= $paiement['mode_paiement'] ?></span>
                <?php endforeach; ?>
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