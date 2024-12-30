
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - whishlist";
$templateParams["nome"] = "whishList_main.php";

$nomeUtente = "user1"; //poi da mettere vuoto ""
if(isset($_GET["nomeUtente"])){
    $nomeUtente = $_GET["nomeUtente"];
}
$templateParams["prodotti"] = $dbh->getWishListProducts($nomeUtente);
$templateParams["categorie"] = $dbh->getCategorie();

$templateParams["js"] = array("js/likeButton.js");

require 'template/base.php';
?>
