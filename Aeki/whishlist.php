
<?php
require_once 'bootstrap.php';

$templateParams["titolo"] = "Aeki - whishlist";
$templateParams["nome"] = "whishList_main.php";

$nomeUtente = "poz"; //poi da mettere vuoto ""
if(isset($_GET["nomeUtente"])){
    $nomeUtente = $_GET["nomeUtente"];
}
$templateParams["prodotti"] = $dbh->getWishListByUtente($nomeUtente);


    $categorie = [
        [
            "NomeCategoria" => "Mobili",
        ],
        [
            "NomeCategoria" => "Letti",
        ],
        [
            "NomeCategoria" => "Armadi",
        ],
        [
            "NomeCategoria" => "Decorazioni",
        ],
        [
            "NomeCategoria" => "Illuminazione",
        ],
        [
            "NomeCategoria" => "Giardinaggio",
        ],
       
        
        ];
    $templateParams["categorie"] = $categorie;





/*
//Poz DB

public function getProdottoById($idProdotto){
        $stmt = $this->db->prepare("SELECT * FROM Prodotto WHERE CodiceProdotto=?");
        $stmt->bind_param('s',$idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    

public function getWishListByUtente($username){
    // Otteniamo l'ID della wishlist dell'utente
    $stmt = $this->db->prepare("SELECT IDwishlist FROM WishList WHERE Username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        return []; // Nessuna wishlist trovata
    }

    $idWishList = $row['IDwishlist'];
    
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
        return []; // Nessun prodotto trovato nella wishlist
    }

    // Prepariamo una query per ottenere tutti i dettagli dei prodotti
    $placeholders = implode(',', array_fill(0, count($productCodes), '?')); //restituisce la stringa con tanti ? quanti sono i codici
    $query = "SELECT * FROM Prodotto WHERE CodiceProdotto IN ($placeholders)";
    $stmt = $this->db->prepare($query);

    // Bind dinamico dei parametri
    $types = str_repeat('s', count($productCodes)); //restituisce la stringa con tanti 's' quanti sono i codici
    $stmt->bind_param($types, ...$productCodes);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}



public function addWhishListProduct($username , $idProdotto){
    // Otteniamo l'id della wishlist dell'utente
    $stmt = $this->db->prepare("SELECT IDwishlist FROM WishList WHERE Username =?");
    $stmt->bind_param('s', $username);  // Usa 's' se $username è una stringa
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verifica se è stato trovato un ID wishlist
    if ($row = $result->fetch_assoc()) {
        $idWishList = $row['IDwishlist'];
    } else {
        return []; // Nessuna wishlist trovata
    }

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
    // Otteniamo l'id della wishlist dell'utente
    $stmt = $this->db->prepare("SELECT IDwishlist FROM WishList WHERE Username =?");
    $stmt->bind_param('s', $username);  // Usa 's' se $username è una stringa
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Verifica se è stato trovato un ID wishlist
    if ($row = $result->fetch_assoc()) {
        $idWishList = $row['IDwishlist'];
    } else {
        return []; // Nessuna wishlist trovata
    }

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

public function addRecensione($username,$idProdotto,$valutazione,$testo){
    $stmt = $this->db->prepare("INSERT INTO `Recensione`(`Testo`, `stelle`, `IDrecensione`, `Username`, `CodiceProdotto`) VALUES (?,?,?,?,?)");
    $stmt->bind_param('sssss', $testo,$valutazione,$idRecensione,$username,$idProdotto); 
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return true; // Recensione aggiunta
    } else {
        return false; 
    }
}
*/

require 'template/base.php';
?>
