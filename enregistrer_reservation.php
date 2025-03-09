<?php
require_once('PDO.php');
require_once('fonction.php');
session_start();

if(isset($_POST['enregistrer'])){
    $id_client = getid_client($_SESSION['USER'],$connect);

    $sql = "INSERT INTO reservations (id_client,id_voiture,date_debut,date_fin,statut_reservation,montant) VALUES (?,?,?,?,?,?) ";
    $requete = $connect->prepare($sql);
    $insertion = $requete->execute([$id_client,$_POST['id_voiture'],$_POST['date_debut'],$_POST['date_fin'],'En attente',$_POST['prix']]);
    if($insertion){
        $_SESSION['message'] = "Reservation enregistrée";
        RedirectToUrl('reservations.php');
    } else{
        $_SESSION['message'] = "Erreur lors de l'enregistrement de la reservation";
        RedirectToUrl('voitures.php');
    } 
}
RedirectToUrl('reservations.php');
