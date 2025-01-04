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
        case 'addProduct':
            $name = $data['name'] ?? '';
            $price = $data['price'] ?? '';
            $image = $data['image'] ?? '';
            $description = $data['description'] ?? '';

            if (empty($name) || empty($price) || empty($image) || empty($description)) {
                echo json_encode(['success' => false, 'message' => 'Tutti i campi sono obbligatori.']);
                exit;
            }

            $result = $dbh->addProduct($userId);
            
            echo json_encode([
                'success' => true,
                'data' => $result
            ]);

            break;
    
        case 'remove':

            $result = $dbh->removeProduct($userId);
            echo json_encode([
                'success' => true,
                'data' => $result
            ]);
            break;

        case 'update':

            $result = $dbh->updateProduct($userId);
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



