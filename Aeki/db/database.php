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
        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
        // Aggiunge username come ultimo parametro
        $valori[] = $username; 
        error_log("SQL: $sql");
        error_log("Parametri: " . implode(", ", $valori));
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

    public function updatePassword($username, $passwordAttuale, $nuovaPassword) {
        // Verifica la password attuale
        $stmt = $this->db->prepare("SELECT Password FROM Utente WHERE Username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($passwordAttuale);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    
        // Verifica se la password attuale è corretta (testo in chiaro)
        if ($passwordAttuale === $passwordAttuale) {
            // La password attuale è corretta, aggiorna la password
            $updateStmt = $this->db->prepare("UPDATE Utente SET Password = ? WHERE Username = ?");
            $updateStmt->bind_param('ss', $nuovaPassword, $username);
            $updateStmt->execute();
    
            // Se l'aggiornamento ha avuto successo, restituisci true
            return $updateStmt->affected_rows > 0;
        }

        // Se la password attuale non è corretta, restituisci false
        return false;
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

    public function getStarNumber($idProdotto){
        // Dato un username ritorna  l'ID della sua wishlist 
        $stmt = $this->db->prepare("SELECT r.stelle,COUNT(r.IDrecensione) AS numeroRecensioni
                                    FROM Recensione r
                                    WHERE r.CodiceProdotto = ?  
                                    GROUP BY r.stelle
                                    ORDER BY r.stelle DESC");
                                    
        $stmt->bind_param('i', $idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
        
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

    public function updateProductReview($productId){
        $stmt = $this->db->prepare("SELECT AVG(r.stelle) AS averageRating, COUNT(r.IDrecensione) AS totalReviews
                                        FROM Recensione AS r
                                        JOIN Prodotto AS p ON r.CodiceProdotto = p.CodiceProdotto
                                        WHERE p.CodiceProdotto = ?");
            
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $averageRating = $result["averageRating"] !== null ? $result["averageRating"] : 0;
        $totalReviews = $result["totalReviews"] !== null ? $result["totalReviews"] : 0;

        $stmt1 = $this->db->prepare("UPDATE `Prodotto` 
                                    SET `ValutazioneMedia` = ?  , `NumeroRecensioni` = ?
                                    WHERE CodiceProdotto = ?");
            
        $stmt1->bind_param('dii', $averageRating,$totalReviews,$productId);
        $stmt1->execute();
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
        $stmt = $this->db->prepare("SELECT Nome, Cognome, Username, Email, PartitaIVA,Telefono,Icona
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

    public function getSellerProductNumber($username){
        $stmt = $this->db->prepare("SELECT COUNT(*) AS prodottiTotali
                                    FROM Prodotto AS p 
                                    WHERE username = ?");
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $productsNumber = isset($data['prodottiTotali']) ? $data['prodottiTotali'] : 0;
    
        return $productsNumber;
    }

    public function getSellerOrderNumber($username){
        $stmt = $this->db->prepare("SELECT COUNT(DISTINCT IDordine) AS ordiniTotali
                                    FROM Prodotto AS p 
                                    JOIN DettaglioOrdine AS do ON p.CodiceProdotto = do.CodiceProdotto
                                    WHERE p.username = ?");
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $ordersNumber = isset($data['ordiniTotali']) ? $data['ordiniTotali'] : 0;
    
        return $ordersNumber;
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


    public function addProduct($userId,$nome,$prezzo,$descrizione,$paths,$larghezza,$altezza,$profondita,$ambiente,$categoria,$colore,$materiale,$peso) {
        
        try{
            $stmt = $this->db->prepare("INSERT INTO `Prodotto`(`Nome`, `Prezzo`, `Descrizione`, `Materiale`, `Peso`, `NomeColore`,
                                                     `Altezza`, `Larghezza`, `Profondita`, 
                                                     `NomeAmbiente`, `NomeCategoria`, `Username`) 
                                        VALUES (?,?,?,?,?,?,?,?,?,?,?)");
    
            $stmt->bind_param('sdssdsdddsss', 
                $nome, 
                $prezzo, 
                $descrizione, 
                $materiale, 
                $peso,
                $colore, 
                $altezza, 
                $larghezza, 
                $profondita, 
                $ambiente, 
                $categoria, 
                $userId
            );
    
            $stmt->execute();
            $codiceProdotto = $this->db->insert_id;

            foreach ($paths as $key => $path) {
                $stmtImg = $this->db->prepare("INSERT INTO `ImmagineProdotto`(`PercorsoImg`, `Icona`, `CodiceProdotto`) VALUES (?,?,?)");
                $icona = 'Y';  
                $stmtImg->bind_param('ssi', $path, $icona, $codiceProdotto);
                
                if (!$stmtImg->execute()) {
                    echo "Errore nell'inserimento dell'immagine: " . $stmtImg->error;
                }
            }
        
            return json_encode([
                'success' => true,
                'message' => 'Prodotto aggiunto con successo'
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

    public function getSellerReviews($username){
        $stmt = $this->db->prepare("SELECT p.CodiceProdotto, p.Nome,i.PercorsoImg, r.IDrecensione, r.Testo,r.Stelle,r.Username AS Cliente
                                    FROM Prodotto AS p 
                                    LEFT JOIN ImmagineProdotto AS i ON p.CodiceProdotto = i.CodiceProdotto AND i.Icona = 'Y'
                                    JOIN Recensione AS r ON r.CodiceProdotto = p.CodiceProdotto
                                    WHERE p.username = ?
                                    ORDER BY p.Nome DESC");
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSellerReviewsNumber($username){
        $stmt = $this->db->prepare("SELECT COUNT(*) AS recensioniTotali
                                    FROM Prodotto AS p 
                                    JOIN Recensione AS r ON p.CodiceProdotto = r.CodiceProdotto
                                    WHERE p.username = ?");
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = $result->fetch_assoc();
        $reviewsNumber = isset($data['recensioniTotali']) ? $data['recensioniTotali'] : 0;
    
        return $reviewsNumber;
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

    public function getTotalSales($username,$startDate) {
        try {
            $stmt = $this->db->prepare("SELECT SUM(do.PrezzoPagato) AS total_sales
                                        FROM DettaglioOrdine AS do
                                        JOIN Prodotto AS p ON do.CodiceProdotto = p.CodiceProdotto
                                        JOIN Ordine AS o on o.IDordine = do.IDordine
                                        WHERE p.Username = ?
                                        AND o.Data > ?");

            
            
            $stmt->bind_param('ss', $username,$startDate);  
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = $result->fetch_assoc();
            $totalSales = isset($data['total_sales']) ? $data['total_sales'] : 0;
            return $totalSales;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function getTotalSelledProduct($username,$startDate) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(DISTINCT p.CodiceProdotto) AS totalSelledProduct
                                        FROM DettaglioOrdine AS do
                                        JOIN Prodotto AS p ON do.CodiceProdotto = p.CodiceProdotto
                                        JOIN Ordine AS o on o.IDordine = do.IDordine
                                        WHERE p.Username = ?
                                        AND o.Data > ?");
            
            $stmt->bind_param('ss', $username,$startDate); 
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = $result->fetch_assoc();
            $totalSelledProduct = isset($data['totalSelledProduct']) ? $data['totalSelledProduct'] : 0;
            return $totalSelledProduct;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function getTotalSelledQuantity($username,$startDate) {
        try {
            $stmt = $this->db->prepare("SELECT SUM(do.Quantita) AS totalSelledProduct
                                        FROM DettaglioOrdine AS do
                                        JOIN Prodotto AS p ON do.CodiceProdotto = p.CodiceProdotto
                                        JOIN Ordine AS o on o.IDordine = do.IDordine
                                        WHERE p.Username = ?
                                        AND o.Data > ?");
            
            $stmt->bind_param('ss', $username,$startDate);   
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = $result->fetch_assoc();
            $totalSelledProduct = isset($data['totalSelledProduct']) ? $data['totalSelledProduct'] : 0;
            return $totalSelledProduct;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }
    
    public function getTopSellingProducts($username,$startDate) {
        try{
            $stmt = $this->db->prepare("SELECT p.Nome,p.CodiceProdotto,i.PercorsoImg, SUM(do.Quantita) AS Quantita, SUM(do.PrezzoPagato) AS RicavoTotale                                        FROM Prodotto AS p
                                        JOIN DettaglioOrdine AS do ON p.CodiceProdotto = do.CodiceProdotto
                                        LEFT JOIN ImmagineProdotto as i ON p.CodiceProdotto = i.CodiceProdotto AND Icona = 'Y'
                                        JOIN Ordine AS o on o.IDordine = do.IDordine
                                        WHERE p.Username = ?
                                        AND o.Data > ?
                                        GROUP BY p.Nome
                                        ORDER BY quantita DESC
                                        LIMIT 3");
            
            $stmt->bind_param('ss', $username,$startDate);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_all(MYSQLI_ASSOC);
            
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }
    
    public function getReviewsData($username) {
        try{
            $stmt = $this->db->prepare("SELECT AVG(r.stelle) AS averageRating, COUNT(r.IDrecensione) AS totalReviews
                                        FROM Recensione AS r
                                        JOIN Prodotto AS p ON r.CodiceProdotto = p.CodiceProdotto
                                        WHERE p.Username = ?");
            
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
            
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }
    
    public function getConversionRate($username) {
        try{
            $stmt = $this->db->prepare("SELECT (COUNT(DISTINCT o.IDordine) / COUNT(DISTINCT v.IDVisita)) * 100 AS conversion_rate
                                        FROM Visita AS v
                                        LEFT JOIN Ordine AS o ON v.IDVisita = o.IDVisita
                                        WHERE o.Username = ?");
            
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            return json_encode([
                'success' => true,
                'data' => $result->fetch_assoc()
            ]);
        } catch (mysqli_sql_exception $e) {
            return json_encode([
                'success' => false,
                'message' => 'Errore SQL: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getDelayedShipments($username) {
        try{
            $stmt = $this->db->prepare("SELECT (COUNT(*) / (SELECT COUNT(*) FROM Ordine WHERE Username = ?)) * 100 AS delayed_rate
                                        FROM Ordine AS o
                                        WHERE o.Username = ? AND o.Data > (SELECT DataPromessaSpedizione FROM DettaglioOrdine WHERE IDordine = o.IDordine)");
            
            $stmt->bind_param('ss', $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            return json_encode([
                'success' => true,
                'data' => $result->fetch_assoc()
            ]);
        } catch (mysqli_sql_exception $e) {
            return json_encode([
                'success' => false,
                'message' => 'Errore SQL: ' . $e->getMessage()
            ]);
        }
    }
    
    public function getMateriali1(){
        $stmt = $this->db->prepare("SELECT NomeMateriale FROM Materiale ");
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

    public function getIdCarrello($username){
        $stmt = $this->db->prepare("SELECT IDcarrello FROM Carrello WHERE Username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['IDcarrello'] : null;
    }

    public function getCarrello($username){
        $idCarrello = $this->getIdCarrello($username);
        if (is_null($idCarrello)) {
            return []; 
        }
        $stmt = $this->db->prepare("SELECT d.CodiceProdotto, d.Quantita ,p.Nome,p.Prezzo,i.PercorsoImg
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
        $placeholders = implode(',', array_fill(0, count($selectedProducts), '?'));
        $stmt = $this->db->prepare("SELECT CodiceProdotto, Prezzo FROM prodotto WHERE CodiceProdotto IN ($placeholders)");
        $types = str_repeat('s', count($selectedProducts));
        $stmt->bind_param($types, ...$selectedProducts);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    }
?>