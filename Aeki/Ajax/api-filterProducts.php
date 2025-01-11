<?php

require_once '../bootstrap.php';
require_once '../utils/functions.php';
header('Content-Type: application/json');
$filters = json_decode(file_get_contents('php://input'), true);
$filteredProducts = $dbh->getProductsList($filters);
foreach ($filteredProducts as &$product) {
    $product["ValutazioneMedia"] = getStars($product["ValutazioneMedia"]);
}
echo json_encode($filteredProducts);
?>