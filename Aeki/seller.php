
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - seller";
$templateParams["nome"] = "seller_main.php";

if(isset($_SESSION['user_id'])){
    $nomeUtente = $_SESSION['user_id'];
    $templateParams["venditore"] = $dbh->getDatiVenditore($nomeUtente);

    $templateParams["js"] = array("js/likeButton.js");
}else{
    header("Location: login.php");
    exit;
}

require 'template/base.php';
?>
