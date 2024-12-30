
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - ordini";
$templateParams["nome"] = "orderList_main.php";

$nomeUtente = "user1";
if(isset($_GET["nomeUtente"])){
    $nomeUtente = $_GET["nomeUtente"];
}

$templateParams["ordini"] = $dbh->getOrdini($nomeUtente);

foreach ($templateParams["ordini"] as &$ordine) { //& usato per non creare una copia e salvare le modifiche
    $prodotti = $dbh->getProdottiPerOrdine2($ordine["IDordine"]);

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