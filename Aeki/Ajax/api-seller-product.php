<?php
require_once '../bootstrap.php';

header('Content-Type: application/json');

/*if (!isset($_SESSION['userId'])) {
    echo json_encode(['success' => false,'error' => 'not_logged_in', 'message' => 'Utente non autenticato']);
    exit;
}*/
$userId = "user3";  

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['action'])) {
    $action = $data['action'];

    switch ($action) {
        case 'add-product':
            $nome = $data['nome'] ?? '';
            $prezzo = $data['prezzo'] ?? '';
            $descrizione = $data['descrizione'] ?? '';
            $paths = $data['percorsoImgs'] ?? ''; 
            $larghezza = $data['larghezza'] ?? '';
            $altezza = $data['altezza'] ?? '';
            $profondita = $data['profondita'] ?? '';
            $ambiente = $data['ambiente'] ?? '';
            $categoria = $data['categoria'] ?? '';
            $colore = $data['colore'] ?? '';
            $materiale = $data['materiale'] ?? '';
            $peso = $data['peso'] ?? '';
            

            if (!$nome || !$prezzo || !$descrizione || !$paths || !$larghezza || !$altezza || !$profondita || !$ambiente || !$categoria || !$colore || !$materiale ||!$peso||!$userId) {
                echo json_encode(['success' => false, 'message' => 'Dati mancanti o non validi']);
                exit;
            }
            
            $result = $dbh->addProduct($userId,$nome,$prezzo,$descrizione,$paths,$larghezza,$altezza,$profondita,$ambiente,$categoria,$colore,$materiale,$peso);
            echo $result;
            break;

        case 'update-availability':
            if (isset($data['codiceProdotto']) && isset($data['nuovaDisponibilita'])) {
                $codiceProdotto = $data['codiceProdotto'];
                $nuovaDisponibilita = $data['nuovaDisponibilita'];

                try {
                    $result = $dbh->updateProductAvailability($codiceProdotto, $nuovaDisponibilita);
                    echo json_encode([
                        'success' => true,
                        'data' => $result,
                    ]);
                } catch (Exception $e) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Errore durante la modifica del prodotto: ' . $e->getMessage(),
                    ]);
                }

            } else {
                echo json_encode(['success' => false, 'message' => 'Errore Dati non sufficienti']);
            }
            break;

        case 'delete-product':
            if (isset($data['codiceProdotto'])) {
                $codiceProdotto = $data['codiceProdotto'];
                $result = $dbh->removeProduct($codiceProdotto);
                echo $result;
            } else {
                echo json_encode(['success' => false, 'message' => 'Errore Dati non sufficienti']);
            }
            break;

        case 'update-price':
            if (isset($data['codiceProdotto']) && isset($data['nuovoPrezzo'])) {
                $codiceProdotto = $data['codiceProdotto'];
                $nuovoPrezzo = $data['nuovoPrezzo'];

                $result = $dbh->updateProductPrice($codiceProdotto, $nuovoPrezzo);
                echo $result;
            } else {
                echo json_encode(['success' => false, 'message' => 'Dati insufficienti']);
            }
            break;
    }
} else {
    echo json_encode(["success" => false, "message" => "Azione non specificata."]);
}

?>
