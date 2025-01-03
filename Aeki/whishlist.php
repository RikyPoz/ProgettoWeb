
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - whishlist";
$templateParams["nome"] = "whishList_main.php";

if(isset($_SESSION['userId'])){
    $nomeUtente = $_SESSION['userId'];
    $templateParams["prodotti"] = $dbh->getWishListProducts($nomeUtente);
    $templateParams["categorie"] = $dbh->getCategorie();

    $templateParams["js"] = array("js/likeButton.js");
}else{
    //da togliere tutto e mettere cosa fa se non è loggato 
    $nomeUtente = "user1"; 
    $templateParams["prodotti"] = $dbh->getWishListProducts($nomeUtente);
    $templateParams["categorie"] = $dbh->getCategorie();

    $templateParams["js"] = array("js/likeButton.js");
}

require 'template/base.php';
?>
