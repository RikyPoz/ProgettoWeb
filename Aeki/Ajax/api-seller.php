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
            
            break;

        case 'stats':
            
            break;

        default:
            echo json_encode(["success" => false, "message" => "Azione sconosciuta."]);
            break;
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati mancanti."]);
}
?>



