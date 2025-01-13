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
        $stmt = $this->db->prepare("SELECT Testo, Data FROM Notifica WHERE Username = ? ORDER BY Data DESC");
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
        $stmt = $this->db->prepare("SELECT Testo, Data, IdNotifica, Letta FROM Notifica WHERE Username = ? AND Data >= ? ORDER BY Data ASC, IdNotifica ASC");
        $stmt->bind_param("ss", $username, $data);
        $stmt->execute();
        $result = $stmt->get_result();
        $messaggi = $result->fetch_all(MYSQLI_ASSOC);
    
        // Libera il risultato e chiude lo statement
        $result->free();
        $stmt->close();
    
        return $messaggi;
    }
    
    public function updateLettaNotifica($idNotifica) {
        $query = "UPDATE Notifica SET Letta = 'Y' WHERE IdNotifica = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $idNotifica);
        $stmt->execute();
    
        // Restituisce true se almeno una riga è stata modificata, altrimenti false
        return $stmt->affected_rows > 0;
    }   

    public function getNumeroNotifiche($username) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM Notifica WHERE Username = ? AND Letta = 'N'");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($unread_count);
        $stmt->fetch();
        $stmt->close();
    
        return $unread_count;  // Restituisce il numero di notifiche non lette
    }
    

    public function newUtente($firstName, $lastName, $username, $email, $password, $phone) {
        $tipo = 'Cliente'; // Tipo fisso come cliente
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
        $stmt->bind_result($passwordDB);
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();
    
        // Verifica se la password attuale è corretta 
        if ($passwordAttuale === $passwordDB) {
            // Se password attuale è corretta aggiorna la password
            $updateStmt = $this->db->prepare("UPDATE Utente SET Password = ? WHERE Username = ?");
            $updateStmt->bind_param('ss', $nuovaPassword, $username);
            $updateStmt->execute();
    
            // Se l'aggiornamento ha avuto successo restituisce true
            return $updateStmt->affected_rows > 0;
        }

        // Se la password attuale non è corretta restituisce false
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

            // 7. Elimina l'utente dalla tabella Notifica
            $stmt = $this->db->prepare("DELETE FROM Notifica WHERE Username = ?");
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

    public function createCart($username) {
        $query = "INSERT INTO Carrello (Username) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
    
        return $stmt->execute();
    }

    public function createWishlist($username) {
        $query = "INSERT INTO WishList (Username) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $username);
    
        return $stmt->execute();
    }

    public function userType($username){
        $stmt = $this->db->prepare("SELECT Tipo FROM Utente WHERE username=?");
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        $row = $result["Tipo"];
    
        return $row;
    }

    //PRODOTTO

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

    public function getProductReviews($idProdotto){
        $stmt = $this->db->prepare("SELECT IDrecensione,Testo,stelle,r.Username AS Cliente
                                    FROM Recensione AS r
                                    JOIN Prodotto AS p ON p.CodiceProdotto = r.CodiceProdotto
                                    WHERE p.CodiceProdotto = ?");
                                    
        $stmt->bind_param('i', $idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
        
    }

    public function writeReview($username,$idProdotto,$valutazione,$testo){
        $stmt = $this->db->prepare("INSERT INTO `Recensione`(`Testo`, `stelle`, `Username`, `CodiceProdotto`) VALUES (?,?,?,?)");
        $stmt->bind_param('siss', $testo,$valutazione,$username,$idProdotto); 
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }

    //una volta aggiunta una nuova recensione il prodotto deve aggiornare i suoi attributi interni
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

    //WISHLIST 

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
            return true; 
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
            return true; 
        } else {
            return false; 
        }
    }

    public function removeFromAllWishLists($idProdotto){
        $stmt = $this->db->prepare("DELETE FROM DettaglioWishlist WHERE CodiceProdotto = ?");
        $stmt->bind_param('i', $idProdotto);
        $stmt->execute();
    }

    public function removeFromAllCarts($idProdotto){
        $stmt = $this->db->prepare("DELETE FROM DettaglioCarrello WHERE CodiceProdotto = ?");
        $stmt->bind_param('i', $idProdotto);
        $stmt->execute();
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
        $stmt = $this->db->prepare("SELECT d.CodiceProdotto,d.PrezzoPagato,d.Quantita,p.Nome,i.PercorsoImg,p.Rimosso
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
                                    WHERE username = ?
                                    AND p.Rimosso = 'N' ");
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
        
    }

    public function getSellerProductNumber($username){
        $stmt = $this->db->prepare("SELECT COUNT(*) AS prodottiTotali
                                    FROM Prodotto AS p 
                                    WHERE username = ?
                                    AND p.Rimosso = 'N'");
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $productsNumber = isset($data['prodottiTotali']) ? $data['prodottiTotali'] : 0;
    
        return $productsNumber;
    }

    //restituisce tutti i prodotti ordinati dai clienti
    public function getSellerOrderedProducts($username){
        $stmt = $this->db->prepare("SELECT o.IDordine,o.Data, o.Username AS Cliente, d.PrezzoPagato, d.Quantita, 
                                    d.CodiceProdotto, p.Nome,i.PercorsoImg,p.Rimosso
                                    FROM Prodotto AS p
                                    JOIN DettaglioOrdine AS d ON d.CodiceProdotto = p.CodiceProdotto
                                    JOIN Ordine AS o ON d.IDordine = o.IDordine
                                    LEFT JOIN ImmagineProdotto AS i ON p.CodiceProdotto = i.CodiceProdotto AND i.Icona = 'Y'
                                    WHERE p.username = ?
                                    AND o.Spedito = 'N'
                                    ORDER BY o.Data DESC"
                                    );
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSellerOrderNumber($username){
        $stmt = $this->db->prepare("SELECT COUNT(DISTINCT do.IDordine) AS ordiniTotali
                                    FROM Prodotto AS p 
                                    JOIN DettaglioOrdine AS do ON p.CodiceProdotto = do.CodiceProdotto
                                    JOIN Ordine AS o ON o.IDordine = do.IDordine
                                    WHERE p.username = ?
                                    AND o.Spedito = 'N'");
        
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $ordersNumber = isset($data['ordiniTotali']) ? $data['ordiniTotali'] : 0;
    
        return $ordersNumber;
    }



    public function addProduct($userId,$nome,$prezzo,$descrizione,$paths,$larghezza,$altezza,$profondita,$ambiente,$categoria,$colore,$materiale,$peso) {
        
        try{
            $stmt = $this->db->prepare("INSERT INTO `Prodotto`(`Nome`, `Prezzo`, `Descrizione`, `Materiale`, `Peso`, `NomeColore`,
                                                     `Altezza`, `Larghezza`, `Profondita`, 
                                                     `NomeAmbiente`, `NomeCategoria`, `Username`,`Rimosso`) 
                                        VALUES (?,?,?,?,?,?,?,?,?,?,?,'N')");
    
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
                $icona = ($key === 0) ? 'Y' : 'N';
            
                $stmtImg = $this->db->prepare("INSERT INTO `ImmagineProdotto`(`PercorsoImg`, `Icona`, `CodiceProdotto`) VALUES (?,?,?)");
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
    
    //deve togliere anche tutte le sue referenze
    public function removeProduct($codiceProdotto) {
        try {
            $stmt = $this->db->prepare("UPDATE Prodotto SET Rimosso = 'Y' WHERE CodiceProdotto = ?");
            $stmt->bind_param('i', $codiceProdotto);
            $stmt->execute();

            $this->notifyUsersDeletedProduct($codiceProdotto);
            $this->removeFromAllCarts($codiceProdotto);
            $this->removeFromAllWishLists($codiceProdotto);

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
   
    public function notifyUsersDeletedProduct($codiceProdotto) {
        $testoWishlist = "Il prodotto $codiceProdotto è stato rimosso dalla tua wishList";
        $testoCarrello = "Il prodotto $codiceProdotto è stato rimosso dal tuo carrello";
        $data = date('Y-m-d H:i:s');
    
        $stmtWishlist = $this->db->prepare("
            INSERT INTO `Notifica` (`Username`, `Testo`, `Data`)
            SELECT w.Username, ?, ?
            FROM DettaglioWishlist AS dw
            JOIN WishList AS w ON w.IDwishlist = dw.IDwishlist
            WHERE dw.CodiceProdotto = ?
        ");
        $stmtWishlist->bind_param('ssi', $testoWishlist, $data, $codiceProdotto);
        $stmtWishlist->execute();

        $stmtCarrello = $this->db->prepare("
            INSERT INTO `Notifica` (`Username`, `Testo`, `Data`)
            SELECT c.Username, ?, ?
            FROM DettaglioCarrello AS dc
            JOIN Carrello AS c ON c.IDcarrello = dc.IDcarrello
            WHERE dc.CodiceProdotto = ?
        ");
        $stmtCarrello->bind_param('ssi', $testoCarrello, $data, $codiceProdotto);
        $stmtCarrello->execute();

    
    }
    
    //invia un anotifica a chiunque abbia il prodotto nel carrello (prezzo cambiato)
    public function notifyCartChange($codiceProdotto,$testo){
        $data = date('Y-m-d H:i:s');

        $stmt = $this->db->prepare("
            INSERT INTO `Notifica` (`Username`, `Testo`, `Data`)
            SELECT c.Username, ?, ?
            FROM DettaglioCarrello AS dc
            JOIN Carrello AS c ON c.IDcarrello = dc.IDcarrello
            WHERE dc.CodiceProdotto = ?
        ");
        $stmt->bind_param('ssi', $testo, $data, $codiceProdotto);
        $stmt->execute();
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
        $stmt = $this->db->prepare("SELECT p.CodiceProdotto, p.Nome,p.Rimosso,i.PercorsoImg, r.IDrecensione, r.Testo,r.Stelle,r.Username AS Cliente
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

    public function getTotalLikeReceived($username) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) AS totalLikeReceived
                                        FROM DettaglioWishlist AS dw
                                        JOIN Prodotto AS p ON dw.CodiceProdotto = p.CodiceProdotto
                                        WHERE p.Username = ?");
            
            $stmt->bind_param('s', $username);   
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = $result->fetch_assoc();
            $totalLikeReceived = isset($data['totalLikeReceived']) ? $data['totalLikeReceived'] : 0;
            return $totalLikeReceived;
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }

    public function getTopLikedProducts($username) {
        try{
            $stmt = $this->db->prepare("SELECT p.CodiceProdotto,p.Nome,i.PercorsoImg,p.Rimosso, COUNT(dw.CodiceProdotto) AS likeTotali
                                        FROM Prodotto AS p
                                        JOIN DettaglioWishlist AS dw ON p.CodiceProdotto = dw.CodiceProdotto
                                        LEFT JOIN ImmagineProdotto as i ON p.CodiceProdotto = i.CodiceProdotto AND Icona = 'Y'
                                        WHERE p.Username = ?
                                        GROUP BY p.CodiceProdotto
                                        ORDER BY likeTotali DESC
                                        LIMIT 3");
            
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            return $result->fetch_all(MYSQLI_ASSOC);
            
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }
    
    public function getTopSellingProducts($username,$startDate) {
        try{
            $stmt = $this->db->prepare("SELECT p.Nome,p.CodiceProdotto,i.PercorsoImg,p.Rimosso, SUM(do.Quantita) AS Quantita, SUM(do.PrezzoPagato) AS RicavoTotale                                        FROM Prodotto AS p
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
            $data = $result->fetch_assoc();

            $averageRating = isset($data['averageRating']) ? $data['averageRating'] : '0';
            $totalReviews = isset($data['totalReviews']) ? $data['totalReviews'] : '0';

            return [
                'averageRating' => $averageRating,
                'totalReviews' => $totalReviews
            ];
            
            
        } catch (mysqli_sql_exception $e) {
            return false;
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
                WHERE i.Icona = 'Y'
                AND p.Rimosso = 'N'";

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
        $stmt = $this->db->prepare("SELECT d.CodiceProdotto, d.Quantita, d.Selezionato ,p.Nome,p.Prezzo,i.PercorsoImg, p.Disponibilita
                                    FROM DettaglioCarrello as d
                                    JOIN Prodotto as p ON d.CodiceProdotto = p.CodiceProdotto
                                    LEFT JOIN ImmagineProdotto as i ON p.CodiceProdotto = i.CodiceProdotto AND Icona = 'Y'
                                    WHERE IDcarrello = ?");
        $stmt->bind_param('s', $idCarrello);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateCart($userId, $products) {
        try {
            $carrelloId = $this->getCartId($userId);
            if (!$carrelloId) {
                throw new Exception("Carrello non trovato per l'utente.");
            }
            $query = "INSERT INTO DettaglioCarrello (IDcarrello, CodiceProdotto, Quantita, Selezionato)
                                      VALUES (?, ?, ?, ?)
                                      ON DUPLICATE KEY UPDATE Quantita = VALUES(Quantita), Selezionato = VALUES(Selezionato)";
            $stmt = $this->db->prepare($query);
    
            foreach ($products as $codiceProdotto => $dati) {
                if (isset($dati)) {
                    $selezionato = $dati['Selezionato'] ? 'Y' : 'N';
                    $stmt->bind_param("ssis", $carrelloId, $codiceProdotto, $dati['Quantita'], $selezionato);
                    $stmt->execute();
                }
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            echo "Errore durante l'aggiornamento del carrello: " . $e->getMessage();
        }
        return false;
    }

    public function removeProductToCart($username, $idProdotto){
        $idCarrello = $this->getCartId($username);
        $stmt = $this->db->prepare("DELETE FROM DettaglioCarrello WHERE CodiceProdotto = ? AND IDcarrello = ?");
        $stmt->bind_param('ss', $idProdotto, $idCarrello);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    }

    public function createOrder($username) {
        $this->db->begin_transaction();
        try {
            // Ottieni l'ID del carrello dell'utente
            $carrelloId = $this->getCartId($username);
            if (!$carrelloId) {
                throw new Exception("Carrello non trovato per l'utente.");
            }
    
            // Recupera i prodotti selezionati nel carrello dell'utente
            $querySelezionati = "SELECT dc.CodiceProdotto, dc.Quantita, p.Prezzo, p.Username AS Venditore
                                 FROM DettaglioCarrello dc
                                 JOIN Prodotto p ON dc.CodiceProdotto = p.CodiceProdotto
                                 WHERE dc.IDcarrello = ? AND dc.Selezionato = 'Y'";
            
            $stmt = $this->db->prepare($querySelezionati);
            $stmt->bind_param('i', $carrelloId);
            $stmt->execute();
            $result = $stmt->get_result();
    
            // Verifica se ci sono prodotti selezionati
            if ($result->num_rows === 0) {
                throw new Exception("Nessun prodotto selezionato nel carrello.");
            }
    
            // Crea un nuovo ordine
            $queryCreaOrdine = "INSERT INTO Ordine (Data, Username, Spedito) VALUES (NOW(), ?, 'N')";
            $stmt = $this->db->prepare($queryCreaOrdine);
            $stmt->bind_param('s', $username);
            $stmt->execute();
    
            // Ottieni l'ID del nuovo ordine
            $ordineID = $this->db->insert_id;
    
            // Inserisce i dettagli dell'ordine e crea notifiche per i venditori
            $queryDettaglioOrdine = "INSERT INTO DettaglioOrdine (IDordine, CodiceProdotto, Quantita, PrezzoPagato)
                                      VALUES (?, ?, ?, ?)";
            $stmtDettaglio = $this->db->prepare($queryDettaglioOrdine);
    
            $queryNotifica = "INSERT INTO Notifica (Username, Testo, Data) VALUES (?, ?, NOW())";
            $stmtNotifica = $this->db->prepare($queryNotifica);
    
            while ($row = $result->fetch_assoc()) {
                $codiceProdotto = $row['CodiceProdotto'];
                $quantita = $row['Quantita'];
                $prezzo = $row['Prezzo'];
                $venditore = $row['Venditore'];
    
                $stmtDettaglio->bind_param("iiid", $ordineID, $codiceProdotto, $quantita, $prezzo);
                $stmtDettaglio->execute();
    
                // Aggiorna la disponibilità del prodotto
                $stmtAggiorna = $this->db->prepare("UPDATE Prodotto SET Disponibilita = Disponibilita - ? WHERE CodiceProdotto = ?");
                $stmtAggiorna->bind_param("ii", $quantita, $codiceProdotto);
                $stmtAggiorna->execute();
    
                // Crea una notifica per il venditore
                $testoNotifica = "Il prodotto con codice $codiceProdotto è stato acquistato in quantità $quantita.";
                $stmtNotifica->bind_param("ss", $venditore, $testoNotifica);
                $stmtNotifica->execute();
            }
    
            // Elimina i prodotti selezionati dal carrello
            $queryEliminaCarrello = "DELETE FROM DettaglioCarrello WHERE IDcarrello = ? AND Selezionato = 'Y'";
            $stmtElimina = $this->db->prepare($queryEliminaCarrello);
            $stmtElimina->bind_param("i", $carrelloId);
            $stmtElimina->execute();
    
            // Commit della transazione
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Rollback in caso di errore
            $this->db->rollback();
        }
        return false;
    }
    

}
?>