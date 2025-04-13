<?php
require_once '..\connection.php';

class Connection {
    protected $dbConn;

    public function __construct() {
        $db = new dbconnection;
        $this->dbConn = $db->getConnection();
    }
}

//Disease CRUD
class CrudDisease extends Connection {
    //private $dbConn;

    function __construct(){
        parent::__construct();
    }
    
    public function read() {
        try {
            $stmt = $this->dbConn->prepare("Call ListofDisease;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

    public function createData($DisName, $description, $classification, $categoryID, $note) {
        try {
            $stmt =$this->dbConn->prepare("Call AddDisease(:DisName, :description, :classification, :categoryID, :note);");
            $stmt->execute([':DisName' => $DisName, ':description' => $description, ':classification' => $classification, ':categoryID' => $categoryID, ':note' => $note]);
            
        } catch (PDOException $e) {
            die("Error Sending data: " . $e->getMessage());
        }
    
    }

    public function deleteDiseaseData($dataId) {
        try {
            $stmt = $this->dbConn->prepare("Call DeleteDisease(:DataID);");
            $stmt->execute([':DataID' => $dataId]);
            echo "Sucess ";
            
        } catch (PDOException $e) {
            die("Error Modifiying data: " . $e->getMessage());
        }
    }

    function __deconstruct(){
        $this->dbConn = null;
    }
}

//Category CRUD
class CrudCategory extends Connection {

    function __construct() {
        parent::__construct();
    }

    public function read() {
        try {
            $stmt = $this->dbConn->prepare("Call ShowListOfCategory;"); // Use the new procedure
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

}

?>