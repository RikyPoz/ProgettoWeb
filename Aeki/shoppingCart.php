<?php
require_once 'bootstrap.php';

/*if (!isset($_SESSION['userId'])) {
    // Reindirizza alla pagina di login
    header("Location: login.php");
    exit();
}*/

$templateParams["titolo"] = "Aeki - carrello";
$templateParams["nome"] = "shoppingCart_main.php";
$nomeUtente = /*$_SESSION['userId'];*/"user1";
$templateParams["prodotti"] = $dbh->getCarrello($nomeUtente);
$templateParams["js"] = array("js/shoppingCart.js");

require 'template/base.php';
?>