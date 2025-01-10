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

    //HomePage Query

    public function getCategorie(){
        $stmt = $this->db->prepare("SELECT NomeCategoria FROM Categoria ORDER BY nomecategoria");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAmbienti(){
        $stmt = $this->db->prepare("SELECT NomeAmbiente, ImgAmbiente FROM Ambiente ORDER BY NomeAmbiente");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getColors(){
        $stmt = $this->db->prepare("SELECT NomeColore FROM Colore ORDER BY NomeColore");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Products Query

    public function getProdotto($idProdotto){
        //Problema:come ritorna tutte le immagini 
        $stmt = $this->db->prepare("SELECT * FROM Prodotto as p JOIN Immagine as i ON p.CodiceProdotto = i.CodiceProdotto AND CodiceProdotto=?");
        $stmt->bind_param('s',$idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getColori1(){
        $stmt = $this->db->prepare("SELECT NomeColore FROM Colore ");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCartId($userId){
        $stmt = $this->db->prepare("SELECT IDCarrello FROM Carrello WHERE Username=?");
        $stmt->bind_param('s', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['IDCarrello'] : null; 
    }
    



    function getProductsList($filters = [], $orderBy = 'Prezzo ASC') {
        $query = "SELECT p.CodiceProdotto, p.Nome, p.Prezzo, p.ValutazioneMedia, p.NumeroRecensioni, i.PercorsoImg 
                FROM Prodotto p
                JOIN ImmagineProdotto i ON p.CodiceProdotto = i.CodiceProdotto
                WHERE i.Icona = 'Y'";

        $queryParams = [];
        $queryTypes = '';

        
        foreach ($filters as $key => $value) {
        if (!is_array($value)) {
            if ($key == "Nome") {
                $query .= " AND p.$key LIKE ?";
                $queryParams[] = "%$value%";
            } else {
                $query .= " AND p.$key = ?";
                $queryParams[] = $value;
            }
            $queryTypes .= 's';
            } elseif (isset($value['min']) && isset($value['max'])) {
                $query .= " AND p.$key BETWEEN ? AND ?";
                $queryParams[] = $value['min'];
                $queryParams[] = $value['max'];
                $queryTypes .= 'dd';
            } elseif (isset($value[0])) {
                $placeholders = implode(',', array_fill(0, count($value), '?'));
                $query .= " AND p.NomeColore IN ($placeholders)";
                foreach ($value as $color) {
                    $queryParams[] = $color;
                    $queryTypes .= 's';
                }
            }
        }
        $query .= " ORDER BY p.$orderBy";
        $stmt = $this->db->prepare($query);
        if (!empty($queryParams)) {
            $stmt->bind_param($queryTypes, ...$queryParams);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPriceMinMax($filterType, $filterValue) {
        $query = "SELECT MIN(p.Prezzo) AS min, MAX(p.Prezzo) AS max FROM Prodotto AS p WHERE ";
        if ($filterType == "Nome") {
            $query .= "p.$filterType LIKE ?";
            $queryParams = "%$filterValue%";
        } else {
            $query .= "p.$filterType = ?";
            $queryParams = $filterValue;
        }
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $queryParams);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCarrello($username){
        $idCarrello = $this->getCartId($username);
        if (is_null($idCarrello)) {
            return []; 
        }
        $stmt = $this->db->prepare("SELECT d.CodiceProdotto, d.Quantita ,p.Nome,p.Prezzo,i.PercorsoImg, p.Disponibilita
                                    FROM DettaglioCarrello as d
                                    JOIN Prodotto as p ON d.CodiceProdotto = p.CodiceProdotto
                                    LEFT JOIN ImmagineProdotto as i ON p.CodiceProdotto = i.CodiceProdotto AND Icona = 'Y'
                                    WHERE IDcarrello = ?");
        $stmt->bind_param('s', $idCarrello);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPricesFromSelected($selectedProducts) {
        if (empty($selectedProducts)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($selectedProducts), '?'));
        $stmt = $this->db->prepare("SELECT CodiceProdotto, Prezzo FROM prodotto WHERE CodiceProdotto IN ($placeholders)");
        $types = str_repeat('s', count($selectedProducts));
        $stmt->bind_param($types, ...$selectedProducts);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function removeProductToCart($username, $idProdotto){
        $idCarrello = $this->getCartId($username);
        // Rimuoviamo il prodotto dalla wishlist
        $stmt = $this->db->prepare("DELETE FROM DettaglioCarrello WHERE CodiceProdotto = ? AND IDcarrello = ?");
        $stmt->bind_param('ss', $idProdotto, $idCarrello);  // Usa 'i' per interi
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }
}
?>