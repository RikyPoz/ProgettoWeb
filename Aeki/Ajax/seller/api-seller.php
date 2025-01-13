<?php
require_once '../../bootstrap.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false,'error' => 'not_logged_in', 'message' => 'Utente non autenticato']);
    exit;
}
$seller = $_SESSION['user_id'];

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['action'])) {
    $action = $data['action']; 

    switch ($action) {
        case 'products':
            $products = $dbh->getSellerProducts($seller);
            $productNumber = $dbh->getSellerProductNumber($seller);
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
            $orders = $dbh->getSellerOrderedProducts($seller);

            echo json_encode([
                'success' => true,
                'data' => $orders
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
            
                $totalSelledProduct = $dbh->getTotalSelledProduct($seller,$startDate);
                $totalSelledQuantity = $dbh->getTotalSelledQuantity($seller,$startDate);
                $totalSales = $dbh->getTotalSales($seller,$startDate);
                $topSellingProducts = $dbh->getTopSellingProducts($seller,$startDate);
                $topLikedProducts = $dbh->getTopLikedProducts($seller);
                $totalLikeReceived = $dbh->getTotalLikeReceived($seller);
                $reviewsData = $dbh->getReviewsData($seller);
                
                $stats['totalLikeReceived'] = $totalLikeReceived;
                $stats['topLikedProducts'] = $topLikedProducts;
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
            $reviews = $dbh->getSellerReviews($seller);
            $reviewsNumber = $dbh->getSellerReviewsNumber($seller);
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



