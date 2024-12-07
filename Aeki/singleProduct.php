<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "Aeki - SingleProduct";
$templateParams["nome"] = "singleProduct_main.php";
//Home Template

$idprodotto = -1;
if(isset($_GET["id"])){
    $idprodotto = $_GET["id"];
}
$templateParams["prodotto"] = $dbh->getProductbyId($idprodotto);

require 'template/base.php';
?>