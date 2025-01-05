<?php

require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "Aeki - FilteredProducts";
$templateParams["nome"] = "filteredProducts_main.php";

// Template
$templateParams["lista_prodotti"] = $dbh->getProductsList();

$templateParams["colors"] = $dbh->getColors();
$templateParams["js"] = array("js/filterProducts.js");

require 'template/base.php';

?>