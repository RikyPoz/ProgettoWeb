<?php
require_once '../../bootstrap.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false,'error' => 'not_logged_in', 'message' => 'Utente non autenticato']);
    exit;
} 
$seller = $_SESSION['user_id'];

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
            

            if (!$nome || !$prezzo || !$descrizione || !$paths || !$larghezza || !$altezza || !$profondita || !$ambiente || !$categoria || !$colore || !$materiale ||!$peso||!$seller) {
                echo json_encode(['success' => false, 'message' => 'Dati mancanti o non validi']);
                exit;
            }
            
            $result = $dbh->addProduct($seller,$nome,$prezzo,$descrizione,$paths,$larghezza,$altezza,$profondita,$ambiente,$categoria,$colore,$materiale,$peso);
            echo $result;
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

        case 'update-availability':
            if (isset($data['codiceProdotto']) && isset($data['nuovaDisponibilita']) && isset($data['vecchiaDisponibilita'])) {
                $codiceProdotto = $data['codiceProdotto'];
                $nuovaDisponibilita = $data['nuovaDisponibilita'];

                $result = $dbh->updateProductAvailability($codiceProdotto, $nuovaDisponibilita);

                if($data['vecchiaDisponibilita'] == 0){
                    $testo = "Il prodotto #$codiceProdotto è tornato disponibile!";
                    $dbh->notifyCartChange($codiceProdotto,$testo);
                }
               
                echo $result;

            } else {
                echo json_encode(['success' => false, 'message' => 'Errore Dati non sufficienti']);
            }
            break;

        case 'update-price':
            if (isset($data['codiceProdotto']) && isset($data['nuovoPrezzo'])) {
                $codiceProdotto = $data['codiceProdotto'];
                $nuovoPrezzo = $data['nuovoPrezzo'];
                $testo = "Il prodotto #$codiceProdotto ha subito una variazione di prezzo!";

                $result = $dbh->updateProductPrice($codiceProdotto, $nuovoPrezzo);
                $dbh->notifyCartChange($codiceProdotto,$testo);
                echo $result;
            } else {
                echo json_encode(['success' => false, 'message' => 'Dati insufficienti']);
            }
            break;
        case 'send-order':
            if (isset($data['idOrdine'])) {
                $idOrdine = $data['idOrdine'];

                $result = $dbh->sendOrder($idOrdine,$seller);
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
