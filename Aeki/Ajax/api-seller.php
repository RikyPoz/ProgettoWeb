<?php
require_once '../bootstrap.php';

header('Content-Type: application/json');

/*if (!isset($_SESSION['userId'])) {
    echo json_encode(['success' => false,'error' => 'not_logged_in', 'message' => 'Utente non autenticato']);
    exit;
}
$userId = $_SESSION['userId'];*/
$userId = "user3";

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['action'])) {
    $action = $data['action']; 

    switch ($action) {
        case 'products':
            $result = $dbh->getSellerProducts($userId);
            echo json_encode([
                'success' => true,
                'data' => $result
            ]);
            break;
        

        case 'orders':
            $result = $dbh->getSellerOrderedProducts($userId);
            echo json_encode([
                'success' => true,
                'data' => $result
            ]);
            break;

            case 'stats':
                
                $stats = [];
                $allSuccess = true; // Variabile per tenere traccia dello stato complessivo delle operazioni
            
                // Chiamata alle funzioni di statistica
                $totalSales = $dbh->getTotalSales($userId);
                $topSellingProducts = $dbh->getTopSellingProducts($userId);
                /*$reviews = json_decode($dbh->getReviewsData($userId), true);
                $conversionRate = json_decode($dbh->getConversionRate($userId), true);
                $delayedShipments = json_decode($dbh->getDelayedShipments($userId), true);*/
                
            
                // Verifica se ogni operazione ha avuto successo
                if ($totalSales === false) {
                    $allSuccess = false;
                    $stats['totalSales'] = "sql error -> totaSales";
                } else {
                    $stats['totalSales'] = $totalSales;
                }
            
                if ($topSellingProducts === false) {
                    $allSuccess = false;
                    $stats['topSellingProducts'] = "sql error -> topSellingProduct";
                } else {
                    $stats['topSellingProducts'] = $topSellingProducts;
                }
            
                /*if ($reviews['success'] === false) {
                    $allSuccess = false;
                    $stats['reviews'] = $reviews; // Ritorna l'errore se c'è
                } else {
                    $stats['reviews'] = $reviews['data'];
                }
            
                if ($conversionRate['success'] === false) {
                    $allSuccess = false;
                    $stats['conversionRate'] = $conversionRate; // Ritorna l'errore se c'è
                } else {
                    $stats['conversionRate'] = $conversionRate['data'];
                }
            
                if ($delayedShipments['success'] === false) {
                    $allSuccess = false;
                    $stats['delayedShipments'] = $delayedShipments; // Ritorna l'errore se c'è
                } else {
                    $stats['delayedShipments'] = $delayedShipments['data'];
                }*/
            
                // Ritorna il risultato finale
                echo json_encode([
                    'success' => $allSuccess,
                    'data' => $stats
                ]);
                break;
            
            

        default:
            echo json_encode(["success" => false, "message" => "Azione sconosciuta."]);
            break;
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati mancanti."]);
}
?>



