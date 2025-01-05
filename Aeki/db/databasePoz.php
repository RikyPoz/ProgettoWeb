<?php
/*
popolamento: togli attributo id recensioni nell aggiunta,cambia idcarrelo con idcarrello,aggiungi piu dati in ordine e in whishlist
*/
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

    //Products Query

    public function getProdotto($idProdotto){
        $stmt = $this->db->prepare("SELECT * FROM Prodotto WHERE CodiceProdotto=?");
        $stmt->bind_param('s',$idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_assoc();
    }

    public function getProdottoImages($idProdotto){
        $stmt = $this->db->prepare("SELECT PercorsoImg, Icona FROM ImmagineProdotto WHERE CodiceProdotto=?");
        $stmt->bind_param('s',$idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getProdottoIcon($idProdotto){
        $stmt = $this->db->prepare("SELECT PercorsoImg FROM ImmagineProdotto WHERE CodiceProdotto=? AND Icona='Y'");
        $stmt->bind_param('s',$idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_assoc();
    }

    public function getProdottoColori($idProdotto){
        $stmt = $this->db->prepare("SELECT NomeColore FROM Colorazione WHERE CodiceProdotto=?");
        $stmt->bind_param('s',$idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }



    public function getStarNumber($idProdotto){
        
    }

    //TO-DO
    public function writeReview($username,$idProdotto,$valutazione,$testo){
        $stmt = $this->db->prepare("INSERT INTO `Recensione`(`Testo`, `stelle`, `Username`, `CodiceProdotto`) VALUES (?,?,?,?)");
        $stmt->bind_param('siss', $testo,$valutazione,$username,$idProdotto); 
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
        $stmt = $this->db->prepare("SELECT d.CodiceProdotto ,p.Nome,p.Prezzo,i.PercorsoImg
                                    FROM DettaglioWishlist as d
                                    JOIN Prodotto as p ON d.CodiceProdotto = p.CodiceProdotto
                                    LEFT JOIN ImmagineProdotto as i ON p.CodiceProdotto = i.CodiceProdotto AND Icona = 'Y'
                                    WHERE IDwishlist = ?");
        $stmt->bind_param('s', $idWishList);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    
    
    public function addWishListProduct($username , $idProdotto){
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
    
    
    public function removeWishListProduct($username, $idProdotto){
        $idWishList = $this->getWishListId($username);
        // Rimuoviamo il prodotto dalla wishlist
        $stmt = $this->db->prepare("DELETE FROM DettaglioWishlist WHERE CodiceProdotto = ? AND IDwishlist = ?");
        $stmt->bind_param('ss', $idProdotto, $idWishList);  // Usa 'i' per interi
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true; // Prodotto rimosso con successo
        } else {
            return false; 
        }
    }

    public function inWishList($productId,$username){
        $idWishList = $this->getWishListId($username);
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM DettaglioWishlist WHERE CodiceProdotto = ? AND IDwishlist = ?");
        $stmt->bind_param('ss', $productId, $idWishList);  // Usa 'i' per interi
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    
    //shoppingCart

    public function addProductToCart($userId, $productId, $quantity) {
        $cartId = $this->getCartId($userId); 
        if (!$cartId) {
            return false;  
        }
        
        if ($this->alreadyInShoppingCart($cartId, $productId)) {
            $stmt = $this->db->prepare("UPDATE `DettaglioCarrello` SET `Quantita` = `Quantita` + ? WHERE `IDcarrello` = ? AND `CodiceProdotto` = ?");
            $stmt->bind_param('sss', $quantity, $cartId, $productId); // Usa 'iss' 
            $stmt->execute();
        } else {
            $stmt = $this->db->prepare("INSERT INTO `DettaglioCarrello` (`IDcarrello`, `CodiceProdotto`, `Quantita`) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $cartId, $productId, $quantity); // Usa 'ssi' 
            $stmt->execute();
        }
    
        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            return false; 
        }
    }
    
    
    
    
    public function getCartId($userId){
        $stmt = $this->db->prepare("SELECT IDCarrello FROM Carrello WHERE Username=?");
        $stmt->bind_param('s', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['IDCarrello'] : null; 
    }
    
    

    

    public function removeProductToShoppingCart(){
        
    }

    public function alreadyInShoppingCart($cartId, $productId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM `DettaglioCarrello` WHERE `IDcarrello` = ? AND `CodiceProdotto` = ?");
        
        $stmt->bind_param('ss', $cartId, $productId);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }
    


    //ORDERS

    public function getOrdini($username){
        $stmt = $this->db->prepare("SELECT IDordine ,Data FROM Ordine WHERE Username=?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProdottiPerOrdine($idOrdine){
        $stmt = $this->db->prepare("SELECT d.CodiceProdotto,d.PrezzoPagato,d.Quantita,p.Nome,i.PercorsoImg
                                    FROM DettaglioOrdine AS d
                                    JOIN Prodotto AS p ON d.CodiceProdotto = p.CodiceProdotto
                                    LEFT JOIN ImmagineProdotto AS i ON p.CodiceProdotto = i.CodiceProdotto AND i.Icona = 'Y'
                                    WHERE d.IDordine = ?");
        $stmt->bind_param('s',$idOrdine);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //SELLER

    public function getDatiVenditore($username){
        $stmt = $this->db->prepare("SELECT Nome, Cognome, Username, Email, PartitaIVA,Telefono
                                    FROM Utente 
                                    WHERE username = ?");
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getSellerProducts($username){
        $stmt = $this->db->prepare("SELECT p.CodiceProdotto, Nome, Prezzo, ValutazioneMedia, NumeroRecensioni,Disponibilita, i.PercorsoImg 
                                    FROM Prodotto AS p 
                                    LEFT JOIN ImmagineProdotto AS i ON p.CodiceProdotto = i.CodiceProdotto AND i.Icona = 'Y'
                                    WHERE username = ?");
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
        
    }

    public function getSellerOrderedProducts($username){
        $stmt = $this->db->prepare("SELECT o.IDordine,o.Data, o.Username AS Cliente, d.PrezzoPagato, d.Quantita, 
                                    d.CodiceProdotto, p.Nome,i.PercorsoImg 
                                    FROM Prodotto AS p
                                    JOIN DettaglioOrdine AS d ON d.CodiceProdotto = p.CodiceProdotto
                                    JOIN Ordine AS o ON d.IDordine = o.IDordine
                                    LEFT JOIN ImmagineProdotto AS i ON p.CodiceProdotto = i.CodiceProdotto AND i.Icona = 'Y'
                                    WHERE p.username = ?
                                    ORDER BY o.Data DESC"
                                    );
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSellerStats(){
        
    }

    public function addProduct($nome, $prezzo, $descrizione, $materiale, $peso, $disponibilita, $altezza, $larghezza, $profondita, $nomeAmbiente, $nomeCategoria, $username) {
        
        
       
        try{
            $stmt = $this->db->prepare("INSERT INTO `Prodotto`(`Nome`, `Prezzo`, `Descrizione`, `Materiale`, `Peso`,
                                                     `Disponibilita`, `Altezza`, `Larghezza`, `Profondita`, 
                                                     `NomeAmbiente`, `NomeCategoria`, `Username`) 
                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
    
        $stmt->bind_param('ssssssssssss', 
            $nome, 
            $prezzo, 
            $descrizione, 
            $materiale, 
            $peso, 
            $disponibilita, 
            $altezza, 
            $larghezza, 
            $profondita, 
            $nomeAmbiente, 
            $nomeCategoria, 
            $username
        );
    
        $stmt->execute();
            return json_encode([
                'success' => true,
                'message' => 'Prodotto rimosso con successo'
            ]);
        } catch (mysqli_sql_exception $e) {
                return json_encode([
                    'success' => false,
                    'message' => 'Errore SQL: ' . $e->getMessage()
                ]);
    
        }
    }
    

    public function removeProduct($codiceProdotto) {
        try {
            $stmt = $this->db->prepare("DELETE FROM prodotto WHERE CodiceProdotto = ?");
            $stmt->bind_param('i', $codiceProdotto);
            $stmt->execute();
            return json_encode([
                'success' => true,
                'message' => 'Prodotto rimosso con successo'
            ]);
        } catch (mysqli_sql_exception $e) {
            return json_encode([
                'success' => false,
                'message' => 'Errore SQL: ' . $e->getMessage()
            ]);
        }
    }
    

    public function updateProductPrice($codiceProdotto, $nuovoPrezzo) {
        try{
        $stmt = $this->db->prepare("UPDATE Prodotto SET Prezzo = ? WHERE CodiceProdotto = ?");
        $stmt->bind_param('ss',$nuovoPrezzo,$codiceProdotto);
        $stmt->execute();
        return json_encode([
            'success' => true,
            'message' => 'Prodotto aggiornato con successo'
        ]);
        } catch (mysqli_sql_exception $e) {
            return json_encode([
                'success' => false,
                'message' => 'Errore SQL: ' . $e->getMessage()
            ]);
        }
    }

    public function updateProductAvailability($codiceProdotto, $nuovaDisponibilita) {
        
        try{
            $stmt = $this->db->prepare("UPDATE Prodotto SET Disponibilita = Disponibilita + ? WHERE CodiceProdotto = ?");
            $stmt->bind_param('ss', $nuovaDisponibilita,$codiceProdotto);
            $stmt->execute();   
            return true;
        }catch(mysqli_sql_exception $e){
            return json_encode("sql error". $e->getMessage());
        }
    }
    
    
    

    public function getMateriali1(){
        $materials = [
            ["NomeMateriale" => "Legno"],
            ["NomeMateriale" => "Plastica"],
            ["NomeMateriale" => "Metallo"],
            ["NomeMateriale" => "Vetro"],
            ["NomeMateriale" => "Ceramica"],
            ["NomeMateriale" => "Tessuto"],
            ["NomeMateriale" => "Carta"],
            ["NomeMateriale" => "Pelle"],
            ["NomeMateriale" => "Gomma"],
            ["NomeMateriale" => "Bambù"]
        ];
        
        return $materials;
    }
    public function getColori1(){
        $stmt = $this->db->prepare("SELECT NomeColore FROM Colore ");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getAmbienti1(){
        $stmt = $this->db->prepare("SELECT NomeAmbiente FROM Ambiente ");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getCategorie1(){
        $stmt = $this->db->prepare("SELECT NomeCategoria FROM Categoria ");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    


}
?>