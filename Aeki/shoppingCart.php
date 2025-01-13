<?php
require_once 'bootstrap.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$nomeUtente = $_SESSION['user_id'];
if($dbh->userType($nomeUtente) === "Venditore"){
    header("Location: homePage.php");
    exit;
}
$templateParams["titolo"] = "Aeki - carrello";
$templateParams["nome"] = "shoppingCart_main.php";
$templateParams["prodotti"] = $dbh->getCarrello($nomeUtente);
$templateParams["js"] = array("js/shoppingCart.js");

require 'template/base.php';
?>