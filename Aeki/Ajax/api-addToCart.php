<?php
require_once 'bootstrap.php';

// Imposta l'intestazione per ricevere JSON
header('Content-Type: application/json');

if (!isset($_SESSION['userId'])) {
    echo json_encode(['success' => false,'error' => 'not_logged_in', 'message' => 'Utente non autenticato']);
    exit;
}
$userId = $_SESSION['userId'];

//legge i dati inviati dal client
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data["productId"]) && isset($data["quantity"])) {
    $productId = $data["productId"];
    $quantity = (int) $data["quantity"];

    if ($quantity <= 0) {
        echo json_encode(["success" => false, "message" => "Quantità non valida."]);
        exit;
    }

    //aggiungere il prodotto al carrello
    $result = $dbh->addProductToCart($userId, $productId, $quantity);

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Errore durante l'aggiunta al carrello."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati mancanti."]);
}
?>