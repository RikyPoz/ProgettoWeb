<?php
class DatabaseHelper{
    private $db;

    //constructor with database connection
    public function __construct($servername, $username, $password, $dbname){
        $this->db = new mysqli($servername, $username, $password, $dbname);
        if ($this->db->connect_error) {
            die("Connessione fallita: "/* . $db->connect_error*/);
        }        
    }

    public function getCategorie(){
        $stmt = $this->db->prepare("SELECT NomeCategoria, PercorsoImmagine FROM Categoria ORDER BY NomeCategoria");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAmbienti(){
        $stmt = $this->db->prepare("SELECT NomeAmbiente, PercorsoImmagine FROM Ambiente ORDER BY NomeAmbiente");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUtente($username) {
        $stmt = $this->db->prepare("SELECT * FROM Utente WHERE Username = ?");
        $stmt->bind_param("s", $username); 
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    public function getUtenteByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM Utente WHERE Email = ?");
        $stmt->bind_param("s", $email); 
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    public function getOrdiniByUtente($username) {
        $stmt = $this->db->prepare("SELECT * FROM Ordine WHERE Username = ? ORDER BY Data DESC");
        $stmt->bind_param("s", $username);  
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    
    public function getMessaggiByUtente($username) {
        $stmt = $this->db->prepare("SELECT Testo, Data FROM Notifiche WHERE Username = ? ORDER BY Data DESC");
        $stmt->bind_param("s", $username);  
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }  
    
    public function getRecensioniByUtente($username) {
        $stmt = $this->db->prepare("SELECT * FROM Recensione WHERE Username = ?");
        $stmt->bind_param("s", $username);  
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getMessaggiByData($username, $data) {
        $stmt = $this->db->prepare("SELECT Testo, Data FROM Notifiche WHERE Username = ? AND Data > ? ORDER BY Data DESC");
        $stmt->bind_param("ss", $username, $data);
        $stmt->execute();
        $result = $stmt->get_result();
        $messaggi = $result->fetch_all(MYSQLI_ASSOC);
    
        // Libera il risultato e chiude lo statement
        $result->free();
        $stmt->close();
    
        return $messaggi;
    }

    public function newUtente($firstName, $lastName, $username, $email, $password, $phone) {
        $tipo = 'cliente'; // Tipo fisso come cliente
        $partitaIVA = NULL; // PartitaIVA impostata a NULL
        $icona = NULL; // Icona impostata a NULL
        $stmt = $this->db->prepare("INSERT INTO Utente (Nome, Cognome, Username, Email, Password, Tipo, PartitaIVA, Telefono, Icona) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $firstName, $lastName, $username, $email, $password, $tipo, $partitaIVA, $phone, $icona);
        $stmt->execute();
        $result = $stmt->get_result();
        // Controlla se l'inserimento ha avuto successo
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }    

    public function updateUtente($nome, $cognome, $email, $telefono, $username) {
        // Prepara i campi da aggiornare e i parametri per il bind
        $campi = [];
        $valori = [];
        
        if (!empty($nome)) {
            $campi[] = "Nome = ?";
            $valori[] = $nome;
        }
        if (!empty($cognome)) {
            $campi[] = "Cognome = ?";
            $valori[] = $cognome;
        }
        if (!empty($email)) {
            $campi[] = "Email = ?";
            $valori[] = $email;
        }
        if (!empty($telefono)) {
            $campi[] = "Telefono = ?";
            $valori[] = $telefono;
        }
        
        // Se non è stato specificato alcun campo da aggiornare interrompe l'esecuzione
        if (empty($campi)) {
            return 0; 
        }
        
        // Crea la query dinamica
        $sql = "UPDATE Utente SET " . implode(", ", $campi) . " WHERE Username = ?";
        $valori[] = $username; // Aggiunge l'username come ultimo parametro
        // Prepara la query
        $stmt = $this->db->prepare($sql);
        // Associa i parametri in base al numero di campi
        $tipi = str_repeat('s', count($valori)); 
        $stmt->bind_param($tipi, ...$valori);
        // Esegue la query
        $stmt->execute();
    
        // Ritorna il numero di righe modificate
        return $stmt->affected_rows;
    }
    
    public function deleteUtente($username) {
        // Inizia una transazione per garantire consistenza
        $this->db->begin_transaction();
    
        try {
            // 1. Aggiorna gli ordini dell'utente
        $stmt = $this->db->prepare("UPDATE Ordine SET Username = 'anonimo' WHERE Username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        error_log("Aggiornato Ordine: " . $stmt->affected_rows . " righe modificate.");

        // 2. Aggiorna le recensioni dell'utente
        $stmt = $this->db->prepare("UPDATE Recensione SET Username = 'anonimo' WHERE Username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        error_log("Aggiornato Recensione: " . $stmt->affected_rows . " righe modificate.");

    
            // 3. Elimina i record nella tabella DettaglioWishlist
            $stmt = $this->db->prepare("DELETE FROM DettaglioWishlist WHERE IDwishlist IN (SELECT IDwishlist FROM WishList WHERE Username = ?)");
            $stmt->bind_param('s', $username);
            $stmt->execute();
    
            // 4. Elimina il record nella tabella WishList
            $stmt = $this->db->prepare("DELETE FROM WishList WHERE Username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
    
            // 5. Elimina i record nella tabella DettaglioCarrello
            $stmt = $this->db->prepare("DELETE FROM DettaglioCarrello WHERE IDcarrello IN (SELECT IDcarrello FROM Carrello WHERE Username = ?)");
            $stmt->bind_param('s', $username);
            $stmt->execute();
    
            // 6. Elimina il record nella tabella Carrello
            $stmt = $this->db->prepare("DELETE FROM Carrello WHERE Username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();

            // 7. Elimina l'utente dalla tabella Notifiche
            $stmt = $this->db->prepare("DELETE FROM Notifiche WHERE Username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
    
            // 8. Elimina l'utente dalla tabella Utente
            $stmt = $this->db->prepare("DELETE FROM Utente WHERE Username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
    
            // Commit della transazione
            $this->db->commit();

            // Ritorna il numero di righe eliminate
            return $stmt->affected_rows;
    
        } catch (Exception $e) {
            // In caso di errore, esegui il rollback della transazione
            $this->db->rollback();
    
            // Gestione errore: rilancia l'eccezione o ritorna un errore personalizzato
            throw new Exception("Errore durante l'eliminazione dell'utente: " . $e->getMessage());
        }
    }
    
    
    
    }
?>