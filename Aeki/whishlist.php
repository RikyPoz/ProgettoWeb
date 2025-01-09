
<?php
require_once 'bootstrap.php';

if(isset($_SESSION['user_id'])){
    $nomeUtente = $_SESSION['user_id'];
    $templateParams["prodotti"] = $dbh->getWishListProducts($nomeUtente);

    $templateParams["titolo"] = "Aeki - whishlist";
    $templateParams["nome"] = "whishList_main.php";
    $templateParams["js"] = array("js/likeButton.js");
}else{
    header("Location: login.php");
    exit;
}

require 'template/base.php';
?>
