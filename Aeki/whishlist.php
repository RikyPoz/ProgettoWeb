
<?php
require_once 'bootstrap.php';



if(isset($_SESSION['userId'])){
    $nomeUtente = $_SESSION['userId'];
    $templateParams["prodotti"] = $dbh->getWishListProducts($nomeUtente);
    $templateParams["categorie"] = $dbh->getCategorie();

    $templateParams["titolo"] = "Aeki - whishlist";
    $templateParams["nome"] = "whishList_main.php";
    $templateParams["js"] = array("js/likeButton.js");
}else{
    header("Location: login.php");
    exit;
}

require 'template/base.php';
?>
