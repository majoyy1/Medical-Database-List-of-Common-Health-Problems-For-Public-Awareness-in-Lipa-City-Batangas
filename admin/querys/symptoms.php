<?php 
//Symptom Crud
require_once 'connection.php';

class CrudSymptoms {
    private $dbConn;

    function __construct(){
        $db = new dbconnection;
        $this->dbConn = $db->getConnection();
    }
    
    public function read() {
        try {
            $stmt = $this->dbConn->prepare("Call ShowAllSymptom;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

    function checkSymptomOfId($id) {
        try {
            $stmt = $this->dbConn->prepare("Call CheckSymptomOfId(:id);");
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

    public function createData($symptomName, $description, $severity, $note) {
        try {
            $stmt =$this->dbConn->prepare("Call AddSymptom(:symptomName, :description, :severity, :note);");
            $stmt->execute([':symptomName' => $symptomName, ':description' => $description, ':severity' => $severity ,':note' => $note]);
            return 1;
            
        } catch (PDOException $e) {
            error_log("Error Sending data: " . $e->getMessage());
            return 0;
        }
    
    }

    public function deleteSymptomData($dataId) {
        try {
            $stmt = $this->dbConn->prepare("Call DeleteSymptom(:DataID);");
            $stmt->execute([':DataID' => $dataId]);
            
        } catch (PDOException $e) {
            die("Error Modifiying data: " . $e->getMessage());
        }
    }

    function cleanData($dataCleaned){
        return htmlspecialchars(trim($dataCleaned));
    }

    function addDiseaseSymptomConnector($symptomID, $diseaseID) {
        try {
            $stmt = $this->dbConn->prepare("Call AddDiseaseSymptom(:symptomID, :diseaseID);");
            $stmt->execute([':symptomID' => $symptomID, ':diseaseID' => $diseaseID]);
            
        } catch (PDOException $e) {
            die("Error Modifiying data: " . $e->getMessage());
        }
    }
//still no procedure for this, just reminder
    function deleteDiseaseSymptomConnector($symptomID, $diseaseID) {
        try {
            $stmt = $this->dbConn->prepare("Call DeleteDiseaseSymptom(:symptomID, :diseaseID);");
            $stmt->execute([':symptomID' => $symptomID, ':diseaseID' => $diseaseID]);
            
        } catch (PDOException $e) {
            die("Error Modifiying data: " . $e->getMessage());
        }
    }
}


?>