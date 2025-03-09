<?php
function RedirectToUrl($url){
    header("Location: $url");
}
function nice($nombre){
    return number_format($nombre, 0, ',', '.')." fcfa/jour" ;
}
function getid_client($email,$connect){
    $sql="SELECT id_client FROM clients WHERE email = ?";
    $requete = $connect->prepare($sql);
    $requete->execute([$email]);
    $match=$requete->fetch();
    return $match['id_client'];
}
function getnom_client($email,$connect){
    $sql="SELECT nom FROM clients WHERE email = ?";
    $requete = $connect->prepare($sql);
    $requete->execute([$email]);
    $match=$requete->fetch();
    return $match['nom'];
}
function getemail_client($id_client,$connect){
    $sql="SELECT email FROM clients WHERE id_client = ?";
    $requete = $connect->prepare($sql);
    $requete->execute([$id_client]);
    $match=$requete->fetch();
    return $match['email'];
}
function getid_reservation($id_voiture,$connect){
    $sql = "SELECT id_reservation FROM reservations WHERE id_voiture = ?";
    $requete = $connect->prepare($sql);
    $requete->execute([$id_voiture]);
    $match=$requete->fetch();
    return $match['id_reservation'];

}
function notifier(){ 
    echo "<script>
    alerte=document.querySelector('.notification');
    setTimeout(() => {
        alerte.style.display = 'none';
    },2500);
    </script>";
}
function info_voiture($recherche,$id_voiture,$connect){
    $sql="SELECT $recherche FROM voitures WHERE id_voiture = ?";
    $requete = $connect->prepare($sql);
    $requete->execute([$id_voiture]);
    $match=$requete->fetch();
    return $match[$recherche];
}
function supprimer_voiture($id_voiture,$connect){
    $sql="DELETE FROM voitures WHERE id_voiture = ?";
    $requete=$connect->prepare($sql);
    $requete->execute([$id_voiture]);
}
function annuler_reservation($id_reservation,$connect){
    $sql="UPDATE reservations SET statut_reservation = ? WHERE id_reservation = ?";
    $requete = $connect->prepare($sql);
    $requete->execute(['Annulée',$id_reservation]);
}
function refuser_reservation($id_reservation,$connect){
    $sql="UPDATE reservations SET statut_reservation = ? WHERE id_reservation = ?";
    $requete = $connect->prepare($sql);
    $requete->execute(['Refusée',$id_reservation]);
}
function confirmer_reservation($id_reservation,$connect){
    $sql="UPDATE reservations SET statut_reservation = ? WHERE id_reservation = ?";
    $requete = $connect->prepare($sql);
    $requete->execute(['Confirmée',$id_reservation]);

    $sql="SELECT id_voiture FROM reservations WHERE id_reservation = ?";
    $requete = $connect->prepare($sql);
    $requete->execute([$id_reservation]);
    $match=$requete->fetch();

    $sql="UPDATE voitures SET statut = ? WHERE id_voiture = ?";
    $requete = $connect->prepare($sql);
    $requete->execute(['Louée',$match['id_voiture']]);

}
function update_statut_voiture($id_voiture,$connect){
    $sql = "SELECT date_fin FROM reservations WHERE id_voiture = ?";
    $requete = $connect->prepare($sql);
    $requete->execute([$id_voiture]);
    $date=$requete->fetch();
    $today = date("Y-m-d");
    if($date){
    $date_fin = new DateTime($date['date_fin']);
    if($today > $date_fin){
        $sql="UPDATE reservations SET statut_reservation = ? WHERE id_voiture = ?";
        $requete = $connect->prepare($sql);
        $requete->execute(['Disponible',$id_voiture]);
    }
}
}
function verifier_paiement($id_reservation,$connect){
    $sql="SELECT * FROM paiements WHERE id_reservation = ?";
    $requete = $connect->prepare($sql);
    $requete->execute([$id_reservation]);
    $match=$requete->fetch();
    if($match) return true;
    return false;   
}
function info_reservation($recherche,$id_reservation,$connect){
    $sql="SELECT $recherche FROM reservations WHERE id_reservation = ?";
    $requete = $connect->prepare($sql);
    $requete->execute([$id_reservation]);
    $match=$requete->fetch();
    return $match[$recherche]; 
}
function info_paiement($recherche,$id_reservation,$connect){
    $sql="SELECT $recherche FROM paiements WHERE id_reservation = ?";
    $requete = $connect->prepare($sql);
    $requete->execute([$id_reservation]);
    $match=$requete->fetch();
    return $match[$recherche];
}
function nb_voitures($connect){
    $sql="SELECT * FROM voitures";
    $requete = $connect->prepare($sql);
    $requete->execute();
    return $requete->rowCount();
}
function nb_voitures_louee($connect){
    $sql="SELECT * FROM voitures WHERE statut =  ?";
    $requete = $connect->prepare($sql);
    $requete->execute(['Louée']);
    return $requete->rowCount();
}
function nb_voitures_dispo($connect){
    $sql="SELECT * FROM voitures WHERE statut =  ?";
    $requete = $connect->prepare($sql);
    $requete->execute(['Disponible']);
    return $requete->rowCount();
}
function nb_reservations_att($connect){
    $sql="SELECT * FROM reservations WHERE statut_reservation =  ?";
    $requete = $connect->prepare($sql);
    $requete->execute(['En attente']);
    return $requete->rowCount();
}
function nb_messages($connect){
    $sql="SELECT * FROM messages";
    $requete = $connect->prepare($sql);
    $requete->execute();
    return $requete->rowCount();
}
function total_revenu($connect){
    $sql="SELECT SUM(montant) AS total FROM paiements";
    $requete = $connect->prepare($sql);
    $requete->execute();
    $match=$requete->fetch();
    if($match['total']==null)
    return 0;
    else return $match['total'];;
}
function total_revenu_par($mode,$connect){
    $sql="SELECT SUM(montant) AS total FROM paiements WHERE mode_paiement = ?";
    $requete = $connect->prepare($sql);
    $requete->execute([$mode]);
    $match=$requete->fetch();
    if($match['total']==null)
    return 0;
    else return $match['total'];;
}
function age_message($date_envoie){
    $today = new DateTime(date("Y-m-d"))  ;
    $date_envoie =new DateTime($date_envoie);
    $nbjour = ($date_envoie->diff($today))->days;
    if ($nbjour==0) return "Recu aujourd'hui";
    if ($nbjour==1) return "Recu hier";
    return "Recu il y'a $nbjour jours";
}