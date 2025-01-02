<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "Aeki - HomePage";
$templateParams["nome"] = "homePage_main.php";

//Home Template
$templateParams["categorie"] = $dbh->getAmbienti();
$templateParams["ambienti"] = $dbh->getCategorie();

require 'template/base.php';
?>