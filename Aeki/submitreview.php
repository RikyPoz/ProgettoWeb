<?php
    require_once 'bootstrap.php';
    header('Content-Type: application/json');

    /*if (!isset($_SESSION['userId'])) {
        echo json_encode(['success' => false, 'message' => 'Utente non autenticato']);
        exit;
    }

    $userId = $_SESSION['userId'];*/
    $userId = "user1"; 
    $data = json_decode(file_get_contents('php://input'), true);

    $productId = isset($data['productId']) ? $data['productId'] : null;
    $rating = isset($data['rating']) ? $data['rating'] : null;
    $comment = isset($data['comment']) ? $data['comment'] : null;
    


    if (!$productId || !$rating || !$comment) {
        echo json_encode(['success' => false, 'message' => 'Dati mancanti']);
        exit;
    }

    if (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        echo json_encode(['success' => false, 'message' => 'Valutazione non valida']);
        exit;
    }

    // Sanitizza il commento per prevenire SQL Injection e XSS
    $comment = htmlspecialchars($comment);

    $result = $dbh->writeReview($userId, $productId, $rating, $comment);
    $dbh->updateProductReview($productId);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Recensione inviata con successo']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Errore query']);
    }
?>

