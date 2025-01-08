<?php
require_once '../bootstrap.php';
header('Content-Type: application/json');
$selectedProducts = json_decode(file_get_contents('php://input'), true);
$logger->log(array_keys($selectedProducts));
$prodotti = $dbh->getPricesFromSelected(array_keys($selectedProducts));
$totale = 0;
$num = 0;
foreach ($prodotti as $prodotto) {
    $totale += $prodotto['Prezzo'] * $selectedProducts[$prodotto['CodiceProdotto']];
    $num += $selectedProducts[$prodotto['CodiceProdotto']];
}
$totIva = $totale * 0.22;
$spedizione = 5.00; // Costo fisso di spedizione
$totNoIva = $totale - $totIva;

echo json_encode([
    'numArticoli' => $num,
    'totNoIva' => $totNoIva,
    'totIva' => $totIva,
    'spedizione' => $spedizione,
    'tot' => $totale
]);

