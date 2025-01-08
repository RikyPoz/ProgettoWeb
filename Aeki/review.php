
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - recensione";
$templateParams["nome"] = "review_main.php";


if(isset($_SESSION['userId']) && isset($_GET["id"])){
    $nomeUtente = $_SESSION['userId'];
    $idprodotto = $_GET["id"];

    $templateParams["prodotto"] = $dbh->getProdotto($idprodotto);
    $templateParams["prodotto"]["PercorsoImg"] = $dbh->getProdottoIcon($idprodotto)["PercorsoImg"];
    $templateParams["js"] = array("js/review.js");
}else{
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'homepage.php'; 
    header("Location: " . $referer); 
    exit;
}



require 'template/base.php';
?>