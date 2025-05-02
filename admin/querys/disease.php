<?php
require_once 'connection.php';

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

    public function createData($DisName, $description, $classification, $categoryID, $note, $symptomIDs) {
        try {
            $stmt = $this->dbConn->prepare("CALL AddDisease(:DisName, :description, :classification, :categoryID, :note);");
            $stmt->execute([':DisName' => $DisName, ':description' => $description, ':classification' => $classification, ':categoryID' => $categoryID, ':note' => $note]);

            $createdID = $this->getCreatedID();
            if (!empty($createdID) && isset($createdID[0]['Disease_ID'])) {
                $diseaseID = $createdID[0]['Disease_ID'];
                

                foreach ($symptomIDs as $symptomID) {
                    $stmt = $this->dbConn->prepare("CALL AddDiseaseSymptom(:diseaseID, :symptomID);");
                    $stmt->execute([':diseaseID' => $diseaseID, ':symptomID' => $symptomID]);
                    echo "<script>console.log('Created Disease ID: " . $diseaseID . "');</script>";
                }
            } else {
                throw new Exception("Failed to retrieve the created disease ID.");
            }

            return 1;
        } catch (PDOException $e) {
            error_log("Error creating disease: " . $e->getMessage());
            return 0;
        } catch (Exception $e) {
            error_log("Error: " . $e->getMessage());
            return 0;
        }
    }

    function getCreatedID() {
        try {
            $stmt = $this->dbConn->prepare("Call GetLastDiseaseID;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
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

