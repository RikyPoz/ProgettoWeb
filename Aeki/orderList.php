
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - ordini";
$templateParams["nome"] = "orderList_main.php";


if(isset($_SESSION['userId'])){
    $nomeUtente = $_SESSION['userId'];
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
}else{//poi da togliere e mettere cosa fa se utente non loggato
    $nomeUtente = "user1"; 
    $templateParams["ordini"] = $dbh->getOrdini($nomeUtente);

    foreach ($templateParams["ordini"] as &$ordine) { 
        $prodotti = $dbh->getProdottiPerOrdine($ordine["IDordine"]);

        $costoTotale = 0;
        foreach($prodotti as $prodotto){
            $costoTotale += $prodotto["PrezzoPagato"];
        }

        $ordine["prodotti"] = $prodotti; 
        $ordine["CostoTotale"] = $costoTotale;
    }
    unset($ordine);
}


require 'template/base.php';
?>