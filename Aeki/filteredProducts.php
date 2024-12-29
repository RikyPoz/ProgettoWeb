<?php

require_once 'bootstrap.php';

//Base Template
$templateParams["titolo"] = "Aeki - FilteredProducts";
$templateParams["nome"] = "filteredProducts_main.php";

// Template
$templateParams["lista_prodotti"] = $dbh->getProductsList();

$templateParams["colors"] = $dbh->getColors();

require 'template/base.php';

?>