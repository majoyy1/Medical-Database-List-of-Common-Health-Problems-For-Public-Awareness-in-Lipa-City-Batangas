<?php 
//Symptom Crud
require_once 'connection.php';

class CrudSymptoms extends dbconnection {

    function __construct(){
        parent::__construct();
    }
    
    public function read() {
        try {
            $stmt = $this->conn->prepare("Call ShowAllSymptom;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

    function checkSymptomOfId($id) {
        try {
            $stmt = $this->conn->prepare("Call CheckSymptomOfIdByDisease(:id);");
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

    function checkDataByID ($id){
        try {
            $stmt = $this->conn->prepare("Call CheckSymptomById(:id);");
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

    public function createData($symptomName, $description, $severity, $note) {
        try {
            $stmt =$this->conn->prepare("Call AddSymptom(:symptomName, :description, :severity, :note);");
            $stmt->execute([':symptomName' => $symptomName, ':description' => $description, ':severity' => $severity ,':note' => $note]);
            return 1;
            
        } catch (PDOException $e) {
            echo "<script>alert('Error Sending data: " . $e->getMessage() . "');</script>";
            return 0;
        }
    
    } 

    public function updateSymptom($id, $symptomName, $description, $severity, $note){
        
        try {
            $stmt =$this->conn->prepare("Call UpdateSymptom(:id, :symptomName, :description, :severity, :note);");
            $stmt->execute([':id' => $id, ':symptomName' => $symptomName, ':description' => $description, ':severity' => $severity ,':note' => $note]);
            return 1;
            
        } catch (PDOException $e) {
            echo "<script>alert('Error Sending data: " . $e->getMessage() . "');</script>";
            return 0;
        }
    }

    public function deleteSymptomData($dataId) {
        try {
            $stmt = $this->conn->prepare("Call DeleteSymptom(:DataID);");
            $stmt->execute([':DataID' => $dataId]);
            return 1;
            
        } catch (PDOException $e) {
            die("Error Modifiying data: " . $e->getMessage());
        }
    }

    function cleanData($dataCleaned){
        return htmlspecialchars(trim($dataCleaned));
    }

    function addDiseaseSymptomConnector($symptomID, $diseaseID) {
        try {
            $stmt = $this->conn->prepare("Call AddDiseaseSymptom(:symptomID, :diseaseID);");
            $stmt->execute([':symptomID' => $symptomID, ':diseaseID' => $diseaseID]);
            return 1;
            
        } catch (PDOException $e) {
            die("Error Modifiying data: " . $e->getMessage());
        }
    }
//still no procedure for this, just reminder
    function deleteDiseaseSymptomConnector($symptomID, $diseaseID) {
        try {
            $stmt = $this->conn->prepare("Call DeleteDiseaseSymptom(:symptomID, :diseaseID);");
            $stmt->execute([':symptomID' => $symptomID, ':diseaseID' => $diseaseID]);
            return 1;
            
        } catch (PDOException $e) {
            die("Error Modifiying data: " . $e->getMessage());
        }
    }

}


?>