<?php
require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "Aeki - HomePage";
$templateParams["nome"] = "homePage_main.php";
//Home Template
//$templateParams["categorie"] = $dbh->getCategorie();
//$templateParams["ambienti"] = $dbh->getAmbienti();

require 'template/base.php';
?>