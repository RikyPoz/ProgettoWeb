<?php
require_once '../bootstrap.php';
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false,'error' => 'not_logged_in', 'message' => 'Utente non autenticato']);
    exit;
}
$userId = $_SESSION['user_id'];
header('Content-Type: application/json');
$result = $dbh->createOrder($userId);
if ($result) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Errore durante la fase di acquisto."]);
}
?>