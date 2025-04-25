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
            return 1;
            
        } catch (PDOException $e) {
            error_log("Error Sending data: " . $e->getMessage());
            return 0;
        }
    
    }

    public function deleteDiseaseData($dataId) {
        try {
            $stmt = $this->dbConn->prepare("Call DeleteDisease(:DataID);");
            $stmt->execute([':DataID' => $dataId]);
            // echo "Sucess ";
            
        } catch (PDOException $e) {
            die("Error Modifiying data: " . $e->getMessage());
        }
    }

    function cleanData($dataCleaned){
        $temp = trim($dataCleaned);
        return htmlspecialchars($temp);
    }

    function modifyData($Id, $Name, $Description, $Classification, $CategoryID, $Note) {
        try {
            $disName = $this->cleanData($Name);
            $description = $this->cleanData($Description);
            $classification = $this->cleanData($Classification);
            $note = $this->cleanData($Note);
            echo $Id;
    
            $stmt = $this->dbConn->prepare("Call modifyDiseasebyID(:DataID, :DisName, :description, :classification, :categoryID, :note);");
            $stmt->execute([
                ':DataID' => $Id,
                ':DisName' => $disName,
                ':description' => $description,
                ':classification' => $classification,
                ':categoryID' => $CategoryID,
                ':note' => $note
            ]);
            return true; // Return true on success
        } catch (PDOException $e) {
            error_log("Error Modifying data: " . $e->getMessage());
            return false; // Return false on failure
        }
    }

    function checkDataById($dataId) {
        try {
            $stmt = $this->dbConn->prepare("Call SearchDisByID(:DataID);");
            $stmt->execute([':DataID' => $dataId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

    public function checkDataByName($name) {
        try {
            $stmt = $this->dbConn->prepare("CALL SearchDiseaseByName(:searchLetter)");
            $stmt->execute([':searchLetter' => $name]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching data by name: " . $e->getMessage());
            return [];
        }
    }

    public function checkDataByLetter($name) {
        try {
            $stmt = $this->dbConn->prepare("CALL SearchDiseaseByLetter(:searchLetter)");
            $stmt->execute([':searchLetter' => $name]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching data by name: " . $e->getMessage());
            return [];
        }
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