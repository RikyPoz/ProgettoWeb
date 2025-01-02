
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - recensione";
$templateParams["nome"] = "review_main.php";

$nomeUtente = "user1";
if(isset($_GET["nomeUtente"])){
    $nomeUtente = $_GET["nomeUtente"];
}

echo $nomeUtente;

$idprodotto = "PROD1";

if(isset($_GET["id"])){
    $idprodotto = $_GET["id"];
}
echo $idprodotto;
$templateParams["prodotto"] = $dbh->getProdotto($idprodotto);
$templateParams["prodotto"]["PercorsoImg"] = $dbh->getProdottoIcon($idprodotto)["PercorsoImg"];
$templateParams["js"] = array("js/review.js");





require 'template/base.php';
?>