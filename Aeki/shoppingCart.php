<?php
require_once 'bootstrap.php';

if (!isset($_SESSION['user_id'])) {
    // Reindirizza alla pagina di login
    header("Location: login.php");
    exit();
}

$templateParams["titolo"] = "Aeki - carrello";
$templateParams["nome"] = "shoppingCart_main.php";
$nomeUtente = $_SESSION['user_id'];
$templateParams["prodotti"] = $dbh->getCarrello($nomeUtente);
$templateParams["js"] = array("js/shoppingCart.js");

require 'template/base.php';
?>