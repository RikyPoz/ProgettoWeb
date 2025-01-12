
<?php
require_once 'bootstrap.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
$nomeUtente = $_SESSION['user_id'];

if($dbh->userType($nomeUtente) === "Cliente"){
    header("Location: homePage.php");
    exit;
}


$templateParams["titolo"] = "Aeki - seller";
$templateParams["nome"] = "seller_main.php";

$templateParams["venditore"] = $dbh->getDatiVenditore($nomeUtente);

$templateParams["js"] = array("js/seller.js", "js/seller-product.js", "js/getModal.js");

require 'template/base.php';
?>
