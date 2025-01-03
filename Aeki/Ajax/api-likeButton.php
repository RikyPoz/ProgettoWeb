<?php
require_once '../bootstrap.php';

header('Content-Type: application/json');

if (!isset($_SESSION['userId'])) {
    echo json_encode(['success' => false,'error' => 'not_logged_in', 'message' => 'Utente non autenticato']);
    exit;
}
$userId = $_SESSION['userId'];

$userId = "user1";
echo("ciao");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data["productId"]) && isset($data["type"])) {
    $productId = $data["productId"];
    $type =  $data["type"];
    

    if ($type == "remove") {
        $result = $dbh->removeWishListProduct($userId, $productId);
        if ($result) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Errore durante la rimozione alla wishlist."]);
        }
    }else if($type == "add"){
        $result = $dbh->addWishListProduct($userId, $productId);
        if ($result) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Errore durante l'aggiunta alla wishlist."]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "Dati mancanti."]);
}
?>
