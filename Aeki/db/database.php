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
        $stmt = $this->db->prepare("SELECT idcategoria, nomecategoria, imgcategoria FROM categoria ORDER BY nomecategoria");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAmbienti(){
        $stmt = $this->db->prepare("");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //Products Query

    public function getProdotto(){

    }

    public function getProdottoByCategoria(){

    }

    public function getProdottoByAmbiente(){

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