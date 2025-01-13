<?php
require_once '../../bootstrap.php';
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false,'error' => 'not_logged_in', 'message' => 'Utente non autenticato']);
    exit;
}
header('Content-Type: application/json');
$cart = $dbh->getCarrello($_SESSION['user_id']);
echo json_encode($cart);
?>