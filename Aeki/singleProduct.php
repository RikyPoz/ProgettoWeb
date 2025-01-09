<?php
require_once 'bootstrap.php';


if(isset($_GET["id"])){
    $idprodotto = $_GET["id"];

    $templateParams["prodotto"] = $dbh->getProdotto($idprodotto);
    $templateParams["immagini"] = $dbh->getProdottoImages($idprodotto);
    $templateParams["reviews"] = $dbh->getStarNumber($idprodotto);
    $templateParams["prodotto"]["InWishlist"] = "false";  
    

    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];  
        if ($dbh->inWishList($idprodotto, $userId)) {
            $templateParams["prodotto"]["InWishlist"] = "true";  
        }
    }

    $templateParams["titolo"] = "Aeki - SingleProduct";
    $templateParams["nome"] = "singleProduct_main.php";
    
    $templateParams["js"] = array("js/addToCart.js","js/likeButton.js");
}else{
    header("Location: homePage.php");
    exit;
}



require 'template/base.php';
?>