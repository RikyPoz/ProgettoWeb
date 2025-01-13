<?php
require_once '../../bootstrap.php';
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false,'error' => 'not_logged_in', 'message' => 'Utente non autenticato']);
    exit;
}
$userId = $_SESSION['user_id'];
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data["spedizione"])) {
    $result = $dbh->createOrder($userId, $data["spedizione"]);
    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Errore durante la fase di acquisto."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Errore! Dati mancanti."]);
}
?>