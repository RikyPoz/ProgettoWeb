<?php
//Da aggiungere sotto il footer di base
    /*if(isset($templateParams["js"])):
        foreach($templateParams["js"] as $script):
    ?>
        <script src="<?php echo $script; ?>"></script>
    <?php
        endforeach;
    endif;*/
    ?>

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

    //Products Query

    public function getProdotto($idProdotto){
        $stmt = $this->db->prepare("SELECT * FROM Prodotto WHERE CodiceProdotto=?");
        $stmt->bind_param('s',$idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_assoc();
    }

    public function getProdottoImages($idProdotto){
        $stmt = $this->db->prepare("SELECT PercorsoImg, Icona FROM Immagine WHERE CodiceProdotto=?");
        $stmt->bind_param('s',$idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
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
        $stmt = $this->db->prepare("SELECT IDordine DataOrdine,CostoTotale FROM Ordini WHERE Username=?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function getProdottiPerOrdine($idOrdine){
        $stmt = $this->db->prepare("SELECT CodiceProdotto FROM DettaglioOrdine WHERE IDordine=?");
        $stmt->bind_param('s',$idOrdine);
        $stmt->execute();
        $result = $stmt->get_result();

        $productCodes = [];
        while ($row = $result->fetch_assoc()) {
            $productCodes[] = $row['CodiceProdotto'];
        }
        
        if (empty($productCodes)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($productCodes), '?')); 
        $query = "SELECT p.CodiceProdotto, Nome,Prezzo,PercorsoImg  FROM Prodotto as p LEFT JOIN Immagine as i ON p.CodiceProdotto = i.CodiceProdotto AND Icona = 1 WHERE p.CodiceProdotto IN ($placeholders)";
        $stmt = $this->db->prepare($query);
    
        // Bind dinamico dei parametri
        $types = str_repeat('s', count($productCodes)); 
        $stmt->bind_param($types, ...$productCodes);
        $stmt->execute();
    
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    



}
?>