<?php
require_once 'bootstrap.php';


if(!isset($_GET["id"])){
    header("Location: homePage.php");
    exit;
}

$templateParams["titolo"] = "Aeki - SingleProduct";
$templateParams["nome"] = "singleProduct_main.php";

$idprodotto = $_GET["id"];
$templateParams["prodotto"] = $dbh->getProdotto($idprodotto);
$templateParams["immagini"] = $dbh->getProdottoImages($idprodotto);
$templateParams["reviewsStats"] = $dbh->getStarNumber($idprodotto);
$templateParams["reviews"] = $dbh->getProductReviews($idprodotto);
$templateParams["prodotto"]["InWishlist"] = "false";  


if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];  
    if ($dbh->inWishList($idprodotto, $userId)) {
        $templateParams["prodotto"]["InWishlist"] = "true";  
    }
    $templateParams["userType"] = $dbh->userType($userId);
}else{
    $templateParams["userType"] = "Cliente";
}


$templateParams["js"] = array("js/addToCart.js","js/likeButton.js");



require 'template/base.php';
?>