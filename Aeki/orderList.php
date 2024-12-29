
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - ordini";
$templateParams["nome"] = "orderList_main.php";

$nomeUtente = "poz";
if(isset($_GET["nomeUtente"])){
    $nomeUtente = $_GET["nomeUtente"];
}

$templateParams["ordini"] = $dbh->getOrdini($nomeUtente);

foreach ($templateParams["ordini"] as &$ordine) { //& usato per non creare una copia e salvare le modifiche
    $prodotti = $dbh->getProdottiPerOrdine($ordine["IDordine"]);
    $ordine["prodotti"] = $prodotti; 
}

require 'template/base.php';
?>