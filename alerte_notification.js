function alerte_prix(){
    $alerte=document.querySelector(".alerte_prix");
    $body=document.querySelector("main");
    $alerte.style.display = 'block';
    $body.style.opacity = '60%';
    document.querySelector('.form button').disabled = true;

}
function fermer_alerte_prix(){
    $alerte=document.querySelector(".alerte_prix");
    $body=document.querySelector("main");
    $alerte.style.display = 'none';
    $body.style.opacity = '100%';
    document.querySelector('.form button').disabled = false;

}
function alerte_reservation(){
    $alerte=document.querySelector(".alerte_reservation");
    $body=document.querySelector("main");
    $alerte.style.display = 'block';
    $body.style.opacity = '60%';
}
function fermer_alerte_reservation(){
    $alerte=document.querySelector(".alerte_reservation");
    $body=document.querySelector("main");
    $alerte.style.display = 'none';
    $body.style.opacity = '100%';
}
function alerte_paiement(id){
    alerte=document.getElementById(id);
    payer=document.getElementById(`payer${id}`);
    alerte.style.display = 'block';
    payer.style.display = 'none';
}
function fermer_alerte_paiement(id){
    alerte=document.getElementById(id);
    alerte.style.display = 'none';
    payer=document.getElementById(`payer${id}`);
    payer.style.display = 'inline';

}