
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - recensione";
$templateParams["nome"] = "review_main.php";

if(!isset($_SESSION['user_id']) || !isset($_GET["id"])){
    header("Location: homePage.php");
    exit;
}
$nomeUtente = $_SESSION['user_id'];

if($dbh->userType($nomeUtente) === "Venditore"){
    header("Location: homePage.php");
    exit;
}
$idprodotto = $_GET["id"];

$templateParams["prodotto"] = $dbh->getProdotto($idprodotto);
$templateParams["prodotto"]["PercorsoImg"] = $dbh->getProdottoIcon($idprodotto)["PercorsoImg"];
$templateParams["js"] = array("js/review.js");




require 'template/base.php';
?>