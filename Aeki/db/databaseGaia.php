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
            return 0; // Nessuna modifica
        }
    
        // Aggiungi l'username alla fine dei parametri
        $campi[] = "Username = ?";
        $valori[] = $username;
    
        // Crea la query dinamica
        $sql = "UPDATE Utente SET " . implode(", ", $campi) . " WHERE Username = ?";
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
    
    }
?>