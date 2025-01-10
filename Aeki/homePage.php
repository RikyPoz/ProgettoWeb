<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "Aeki - HomePage";
$templateParams["nome"] = "homePage_main.php";

//Home Template
$templateParams["categorie"] = $dbh->getCategorie();
$templateParams["ambienti"] = $dbh->getAmbienti();

if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}

require 'template/base.php';
?>
