<?php

require_once '../bootstrap.php';
require_once '../utils/functions.php';
header('Content-Type: application/json');
$filters = json_decode(file_get_contents('php://input'), true);
$dbFilters = [];
// Mappa i filtri JSON ai filtri del database
if (isset($filters['Colore']) && !empty($filters['Colore'])) {
    $dbFilters['NomeColore'] = $filters['Colore'];
}
if (isset($filters['Prezzo']['min']) && isset($filters['Prezzo']['max'])) {
    $dbFilters['Prezzo'] = [
        'min' => $filters['Prezzo']['min'],
        'max' => $filters['Prezzo']['max']
    ];
}
if (isset($filters['ValutazioneMedia']) && $filters['ValutazioneMedia'] !== null) {
    $dbFilters['ValutazioneMedia'] = [
        'min' => $filters['ValutazioneMedia'],
        'max' => 5
    ];
}

// Ottieni la lista filtrata
$filteredProducts = $dbh->getProductsList($dbFilters);
foreach ($filteredProducts as &$product) {
    $product["ValutazioneMedia"] = getStars($product["ValutazioneMedia"]);
}
// Restituisci i prodotti come JSON
echo json_encode($filteredProducts);
?>