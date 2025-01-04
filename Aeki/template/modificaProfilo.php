<?php
include 'database.php';

// Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    var_dump($_SESSION);

    // Prepara la query di aggiornamento
    $query = "UPDATE Utente SET Nome = ?, Cognome = ?, Email = ?, Telefono = ? WHERE Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $nome, $cognome, $email, $telefono, $username);

    if ($stmt->execute()) {
        echo "Profilo aggiornato con successo!";
        // Rimanda l'utente alla pagina del profilo
        header("Location: profile.php");
    } else {
        echo "Errore nell'aggiornamento del profilo: " . $stmt->error;
    }
}

?>
