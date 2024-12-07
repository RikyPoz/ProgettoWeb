<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "Se vedi questo messaggio, il file PHP funziona!";
?>
<?php
//require_once 'bootsrap.php';

$templateParams["titolo"] = "Aeki - ordini";
$templateParams["nome"] = "orderList_main.php";

/*$nomeUtente = "";
if(isset($_GET["nomeUtente"])){
    $nomeUtente = $_GET["nomeUtente"];
}
$templateParams["ordini"] = $dbh->getOrdiniByUtente($nomeUtente);*/

$ordini = [{
    "idOrdine": "abcd",
    "dataOrdine":"20/10/2024"
    "costoTotale":"150$"
},
{
    "idOrdine": "1234",
    "dataOrdine":"5/12/2024"
    "costoTotale":"10$"
}]
$templateParams["ordini"] = $ordini;

//bisogna prendere anche tutti i prodotti? dipende struttura database

require 'template/base.php';
?>