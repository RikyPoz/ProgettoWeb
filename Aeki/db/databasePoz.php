<?php
/*
create table Recensione (
    IDrecensione int AUTO_INCREMENT,
     Testo VARCHAR(50) not null,
     stelle int not null,
     CodiceProdotto VARCHAR(50) not null,
     Username VARCHAR(50) not null,
     constraint ID_Recensione_ID primary key (IDrecensione);
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
    
    
    //shoppingCart

    public function addProductToCart($userId, $productId, $quantity){
        $cartId = $this->getCartId();
        $stmt = $this->db->prepare("INSERT INTO DettaglioCarrello (`IDcarrello`, `CodiceProdotto`, `Quantita`) VALUES (?,?,?");
        $stmt->bind_param('ssi',$cartId,$idProdotto,$quantity);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    
    }

    public function getCartId($userId){
        $stmt = $this->db->prepare("SELECT IDCarrello FROM Carrello WHERE Username=?");
        $stmt->bind_param('s',$userId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_assoc();
    }

    

    public function removeProductToShoppingCart(){
        
    }

    public function alreadyInShoppingCart(){

    }

    public function addQuantityShoppingCart($idProdotto,$quantita){

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
        $stmt = $this->db->prepare("SELECT 
                                    d.CodiceProdotto,
                                    d.PrezzoPagato,
                                    d.Quantita,
                                    p.Nome,
                                    i.PercorsoImg
                                FROM 
                                    DettaglioOrdine AS d
                                JOIN 
                                    Prodotto AS p ON d.CodiceProdotto = p.CodiceProdotto
                                LEFT JOIN 
                                    ImmagineProdotto AS i ON p.CodiceProdotto = i.CodiceProdotto AND i.Icona = 'Y'
                                WHERE 
                                    d.IDordine = ?
                                ");
        $stmt->bind_param('s',$idOrdine);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }


}
?>