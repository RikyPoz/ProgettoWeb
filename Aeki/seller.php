
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - seller";
$templateParams["nome"] = "seller_main.php";

if(isset($_SESSION['userId'])){
    $nomeUtente = $_SESSION['userId'];
    $templateParams["venditore"] = $dbh->getDatiVenditore($nomeUtente);

    $templateParams["js"] = array("js/likeButton.js");
}else{
    //da togliere tutto e mettere cosa fa se non è loggato 
    $nomeUtente = "user3"; 
    $templateParams["venditore"] = $dbh->getDatiVenditore($nomeUtente);

    $templateParams["js"] = array("js/seller.js?v=" . time());

}

require 'template/base.php';
?>
