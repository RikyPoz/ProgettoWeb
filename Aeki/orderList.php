
<?php
require_once 'bootstrap.php';


if(isset($_SESSION['user_id'])){
    $nomeUtente = $_SESSION['user_id'];
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
    $templateParams["titolo"] = "Aeki - ordini";
    $templateParams["nome"] = "orderList_main.php";
}else{
    header("Location: login.php");
    exit;
}


require 'template/base.php';
?>