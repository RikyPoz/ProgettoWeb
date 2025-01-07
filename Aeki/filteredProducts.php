<?php

require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - FilteredProducts";
$templateParams["nome"] = "filteredProducts_main.php";

if (isset($_GET['ambient'])) {
    $templateParams["tipoSelezione"] = "NomeAmbiente";
    $templateParams["nomeSelezione"] = $_GET['ambient'];
} else if (isset($_GET['categories'])) {
    $templateParams["tipoSelezione"] = "NomeCategoria";
    $templateParams["nomeSelezione"] = $_GET['categories'];
} else if (isset($_GET["search"])) {
    $templateParams["tipoSelezione"] = "Nome";
    $templateParams["nomeSelezione"] = $_GET['search'];
}

$templateParams["colors"] = $dbh->getColors();

$templateParams["js"] = array("js/filterProducts.js");
require 'template/base.php';

?>