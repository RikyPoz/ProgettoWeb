<?php
    session_start(); 

    // Verifica se il form è stato inviato
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recupera l'username dalla sessione
        $username = $_SESSION['username'];

        // Recupera i valori dei campi dal form
        $nome = !empty($_POST['nome']) ? trim($_POST['nome']) : null;
        $cognome = !empty($_POST['cognome']) ? trim($_POST['cognome']) : null;
        $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
        $telefono = !empty($_POST['telefono']) ? trim($_POST['telefono']) : null;

        try {
            // Usa la funzione updateUtente per aggiornare i dati
            $result = $dbh->updateUtente($nome, $cognome, $email, $telefono, $username);
            // Controlla il risultato
            if ($result > 0) {
                // Reindirizza alla pagina del profilo con messaggio di successo
                header("Location: profile.php?status=success");
                exit();
            } else {
                // Se nessuna riga è stata modificata
                header("Location: profile.php?status=no_change");
                exit();
            }
        } catch (Exception $e) {
            // Gestione degli errori
            echo "Errore durante l'aggiornamento del profilo: " . $e->getMessage();
            exit();
        }
    }
?>
