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
    echo $action;

    switch ($action) {
        case 'addProduct':
            $nome = $data['nome'] ?? '';
            $prezzo = $data['prezzo'] ?? '';
            $descrizione = $data['descrizione'] ?? '';
            $percorsoImg = $data['percorsoImg'] ?? '';
            $larghezza = $data['larghezza'] ?? '';
            $altezza = $data['altezza'] ?? '';
            $profondita = $data['profondita'] ?? '';
            $ambiente = $data['ambiente'] ?? '';
            $categoria = $data['categoria'] ?? '';
            $colore = $data['colore'] ?? '';
            $materiale = $data['materiale'] ?? '';
        
            try {
                $result = $dbh->addProduct(
                    $userId,
                    $nome,
                    $prezzo,
                    $descrizione,
                    $percorsoImg,
                    $larghezza,
                    $altezza,
                    $profondita,
                    $ambiente,
                    $categoria,
                    $colore,
                    $materiale
                );
        
                echo json_encode([
                    'success' => true,
                    'data' => $result,
                ]);
            } catch (Exception $e) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Errore durante l\'aggiunta del prodotto: ' . $e->getMessage(),
                ]);
            }
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



