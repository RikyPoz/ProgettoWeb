<?php
require_once 'bootstrap.php';


$templateParams["titolo"] = "Aeki - SingleProduct";
$templateParams["nome"] = "singleProduct_main.php";

if(isset($_GET["id"])){
    $idprodotto = $_GET["id"];
    $templateParams["prodotto"] = $dbh->getProdotto($idprodotto);

    $templateParams["immagini"] = $dbh->getProdottoImages($idprodotto);
    $templateParams["colori"] = $dbh->getProdottoColori($idprodotto);
    $templateParams["prodotto"]["InWishlist"] = "false";  

    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];  
        if ($dbh->inWishList($idprodotto, $userId)) {
            $templateParams["prodotto"]["InWishlist"] = "true";  
        }
    }else{
        // da togliere caso else (se non è loggato semplicemente icona bianca)
        $userId = "user1"; 
        if($dbh->inWishList($idprodotto,$userId)){
            $templateParams["prodotto"]["InWishlist"] = "true";
        }
    }
    $templateParams["js"] = array("js/addToCart.js","js/likeButton.js");
}else{
    //poi da togliere tutto e fare se non c'è id nella get
    $idprodotto = 1; 
    $templateParams["prodotto"] = $dbh->getProdotto($idprodotto);

    $templateParams["immagini"] = $dbh->getProdottoImages($idprodotto);
    $templateParams["colori"] = $dbh->getProdottoColori($idprodotto);
    $templateParams["prodotto"]["InWishlist"] = "false";  

    if (isset($_SESSION['userId'])) {
        $userId = $_SESSION['userId'];  
        if ($dbh->inWishList($idprodotto, $userId)) {
            $templateParams["prodotto"]["InWishlist"] = "true";  
        }
    }else{
        $userId = "user1"; 
        if($dbh->inWishList($idprodotto,$userId)){
            $templateParams["prodotto"]["InWishlist"] = "true";
        }
    }
    $templateParams["js"] = array("js/addToCart.js","js/likeButton.js");
}



require 'template/base.php';
?>