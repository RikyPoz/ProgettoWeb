<?php
require_once '../bootstrap.php';

header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false,'error' => 'not_logged_in', 'message' => 'Utente non autenticato']);
    exit;
}
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data["productId"])) {
    $result = $dbh->removeProductToCart($_SESSION['user_id'], $data["productId"]);
    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Errore durante la rimozione dal carrello."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati mancanti."]);
}
?>