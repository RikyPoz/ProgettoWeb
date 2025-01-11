
<?php
require_once 'bootstrap.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
$nomeUtente = $_SESSION['user_id'];

if($dbh->userType($nomeUtente) === "Venditore"){
    header("Location: homePage.php");
    exit;
}

$templateParams["titolo"] = "Aeki - ordini";
$templateParams["nome"] = "orderList_main.php";
$templateParams["ordini"] = $dbh->getOrdini($nomeUtente);

foreach ($templateParams["ordini"] as &$ordine) { //& usato per non creare una copia e salvare le modifiche
    $prodotti = $dbh->getProdottiPerOrdine($ordine["IDordine"]);

    $costoTotale = 0;
    foreach($prodotti as $prodotto){
        $costoTotale += $prodotto["PrezzoPagato"];
    }

    $ordine["prodotti"] = $prodotti; 
    $ordine["CostoTotale"] = $costoTotale;
}
unset($ordine);



require 'template/base.php';
?>