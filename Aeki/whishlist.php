
<?php
require_once 'bootstrap.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
$nomeUtente = $_SESSION['user_id'];

if($dbh->userType($nomeUtente) === "Venditore"){
    header("Location: homePage.php");
    exit;
}

$nomeUtente = $_SESSION['user_id'];
$templateParams["prodotti"] = $dbh->getWishListProducts($nomeUtente);

$templateParams["titolo"] = "Aeki - whishlist";
$templateParams["nome"] = "whishList_main.php";
$templateParams["js"] = array("js/likeButton.js");


require 'template/base.php';
?>
