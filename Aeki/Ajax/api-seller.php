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
            $products = $dbh->getSellerProducts($userId);
            $productNumber = $dbh->getSellerProductNumber($userId);
            $result = [
                'products' => $products,
                'productNumber' => $productNumber
            ];
            echo json_encode([
                'success' => true,
                'data' => $result
            ]);
            break;
        

        case 'orders':
            $orders = $dbh->getSellerOrderedProducts($userId);
            $orderNumber = $dbh->getSellerOrderNumber($userId);
            $result = [
                'orders' => $orders,
                'orderNumber' => $orderNumber
            ];
            echo json_encode([
                'success' => true,
                'data' => $result
            ]);
            break;

            case 'stats':

                $periodo = isset($data['periodo']) ? $data['periodo'] : 'all';  

                switch($periodo){
                    case 'week':
                        $startDate = date('Y-m-d', strtotime('-7 days'));
                        break;
                    case 'month':
                        $startDate = date('Y-m-d', strtotime('-30 days'));
                        break;
                    case 'all':
                        $startDate = '1970-01-01';
                        break;
                    default:
                        $startDate = '1970-01-01';
                        break;
                }
                

                
                $stats = [];
                $allSuccess = true; // Variabile per tenere traccia dello stato complessivo delle operazioni
            
                // Chiamata alle funzioni di statistica
                $totalSelledProduct = $dbh->getTotalSelledProduct($userId,$startDate);
                $totalSelledQuantity = $dbh->getTotalSelledQuantity($userId,$startDate);
                $totalSales = $dbh->getTotalSales($userId,$startDate);
                $topSellingProducts = $dbh->getTopSellingProducts($userId,$startDate);
                $reviewsData = $dbh->getReviewsData($userId);
                /*$reviews = json_decode($dbh->getReviewsData($userId), true);
                $conversionRate = json_decode($dbh->getConversionRate($userId), true);
                $delayedShipments = json_decode($dbh->getDelayedShipments($userId), true);*/
                
                $stats['totalSelledQuantity'] = $totalSelledQuantity;
                $stats['reviewsData'] = $reviewsData;
                if ($totalSelledProduct === false) {
                    $allSuccess = false;
                    $stats['totalSelledProduct'] = "sql error -> totaSelledProduct";
                } else {
                    $stats['totalSelledProduct'] = $totalSelledProduct;
                }

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

                $stats['periodo'] = $periodo;
            
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
            
            
        case 'reviews':
            $reviews = $dbh->getSellerReviews($userId);
            $reviewsNumber = $dbh->getSellerReviewsNumber($userId);
            $result = [
                'reviews' => $reviews,
                'reviewsNumber' => $reviewsNumber
            ];
            echo json_encode([
                'success' => true,
                'data' => $result
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



