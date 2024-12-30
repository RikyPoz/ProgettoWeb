<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "Aeki - SingleProduct";
$templateParams["nome"] = "singleProduct_main.php";
//Home Template

$idprodotto = "PROD1";

if(isset($_GET["id"])){
    $idprodotto = $_GET["id"];
}
$templateParams["prodotto"] = $dbh->getProdotto($idprodotto);

$templateParams["immagini"] = $dbh->getProdottoImages($idprodotto);
$templateParams["colori"] = $dbh->getProdottoColori($idprodotto);

$templateParams["js"] = array("js/addToCart.js");



require 'template/base.php';
?>