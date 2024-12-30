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


    public function getProdottoByCategoria(){

    }

    public function getProdottoByAmbiente(){

    }

    public function getStarNumber($idProdotto){
        
    }

    function getProductsList($filters = [], $orderBy = 'Prezzo ASC') {
        $query = "SELECT p.Nome, p.Prezzo, p.ValutazioneMedia, p.NumeroRecensioni, i.PercorsoImg 
                FROM Prodotto p
                JOIN Immagine i ON p.CodiceProdotto = i.CodiceProdotto
                WHERE i.Icona = TRUE";

        $queryParams = [];
        $queryTypes = '';

        foreach ($filters as $key => $value) {
        if (!is_array($value)) {
            $query .= " AND p.$key = ?";
            $queryParams[] = $value;
            $queryTypes .= is_numeric($value) ? 'd' : 's';
        } elseif (isset($value['min']) && isset($value['max'])) {
            $query .= " AND p.$key BETWEEN ? AND ?";
            $queryParams[] = $value['min'];
            $queryParams[] = $value['max'];
            $queryTypes .= is_numeric($value['min']) ? 'd' : 's';
            $queryTypes .= is_numeric($value['max']) ? 'd' : 's';
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
    

    //TO-DO
    public function writeReview($username,$idProdotto,$valutazione,$testo){
        $stmt = $this->db->prepare("INSERT INTO `Recensione`(`Testo`, `stelle`, `IDrecensione`, `Username`, `CodiceProdotto`) VALUES (?,?,?,?,?)");
        $stmt->bind_param('sssss', $testo,$valutazione,$idRecensione,$username,$idProdotto); 
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true; // Recensione aggiunta
        } else {
            return false; 
        }
    }

    //WISHLIST QUERY

    public function getWishListId($username){
        // Dato un username ritorna  l'ID della sua wishlist 
        $stmt = $this->db->prepare("SELECT IDwishlist FROM WishList WHERE Username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['IDwishlist'] : null;
    }

    public function getWishListProducts($username){
        $idWishList = $this->getWishListId($username);
        if (!$idWishList) {
            return []; 
        }
        // Otteniamo tutti i codiciProdotti all'interno della wishlist
        $stmt = $this->db->prepare("SELECT CodiceProdotto FROM DettaglioWishlist WHERE IDwishlist = ?");
        $stmt->bind_param('s', $idWishList);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $productCodes = [];
        while ($row = $result->fetch_assoc()) {
            $productCodes[] = $row['CodiceProdotto'];
        }
        
        if (empty($productCodes)) {
            return [];
        }
    
        // Prepariamo una query per ottenere tutti i dettagli dei prodotti
        $placeholders = implode(',', array_fill(0, count($productCodes), '?')); //restituisce la stringa con tanti ? quanti sono i codici
        $query = "SELECT p.CodiceProdotto, Nome,Prezzo,PercorsoImg  FROM Prodotto as p LEFT JOIN Immagine as i ON p.CodiceProdotto = i.CodiceProdotto AND Icona = 1 WHERE p.CodiceProdotto IN ($placeholders)";
        $stmt = $this->db->prepare($query);
    
        // Bind dinamico dei parametri
        $types = str_repeat('s', count($productCodes)); //restituisce la stringa con tanti 's' quanti sono i codici
        $stmt->bind_param($types, ...$productCodes);
        $stmt->execute();
    
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    

    public function addWhishListProduct($username , $idProdotto){
        $idWishList = $this->getWishListId($username);
        // Aggiungiamo il prodotto nella wishlist
        $stmt = $this->db->prepare("INSERT INTO DettaglioWishlist (CodiceProdotto, IDwishlist) VALUES(?, ?)");
        $stmt->bind_param('ss', $idProdotto, $idWishList);  
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true; // Prodotto aggiunto con successo
        } else {
            return false; 
        }
    }
    
    
    public function removeWhishListProduct($username, $idProdotto){
        $idWishList = $this->getWishListId($username);
        // Rimuoviamo il prodotto dalla wishlist
        $stmt = $this->db->prepare("DELETE FROM DettaglioWishlist WHERE CodiceProdotto = ? AND IDwishlist = ?");
        $stmt->bind_param('ii', $idProdotto, $idWishList);  // Usa 'i' per interi
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true; // Prodotto rimosso con successo
        } else {
            return false; 
        }
    }
    
    
    //shoppingCart

    public function addProductToShoppingCart(){
    
    }

    public function removeProductToShoppingCart(){
        
    }

    public function alreadyInShoppingCart(){

    }

    public function addQuantityShoppingCart($idProdotto,$quantita){

    }

    //seller Query

    public function addProduct($idProdotto){

    }

    public function removeProduct($idProdotto){
        
    }

    public function refillProduct($idProdotto, $quantità){
        
    }

    public function modifyProductPrice($idProdotto, $newPrice){
        
    }


    //User Query

    public function getUtente(){
        
    }

    public function getOrdiniByUtente(){

    }

    public function getMessaggiByUtente(){

    }



}
?>