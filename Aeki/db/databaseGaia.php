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
    
        
    }
?>