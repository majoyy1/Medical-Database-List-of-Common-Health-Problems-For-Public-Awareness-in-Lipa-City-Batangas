<?php
require_once 'connection.php';

//Disease CRUD
class CrudDisease extends dbconnection {
    public $db;
    function __construct(){
        parent::__construct();
        $this->db = $this->getConnection();
    }
    
    public function read() {
        try {
            $stmt = $this->conn->prepare("Call ShowView_list_of_diseases;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

    public function createData($DisName, $description, $classification, $categoryID, $note, $symptomIDs) {
        try {
            // Validate inputs
            if (empty($DisName) || empty($classification) || empty($categoryID)) {
                throw new Exception("Disease Name, Classification, and Category ID are required.");
            }

            // Insert the disease
            $stmt = $this->conn->prepare("CALL AddDisease(:DisName, :description, :classification, :categoryID, :note);");
            $stmt->execute([
                ':DisName' => $DisName,
                ':description' => $description,
                ':classification' => $classification,
                ':categoryID' => $categoryID,
                ':note' => $note
            ]);

            // Get the created Disease ID
            $createdID = $this->getCreatedID();
            if (empty($createdID) || !isset($createdID[0]['Disease_ID'])) {
                throw new Exception("Failed to retrieve the created Disease ID.");
            }
            $diseaseID = $createdID[0]['Disease_ID'];

            // Insert symptoms if provided
            if (!empty($symptomIDs) && is_array($symptomIDs)) {
                foreach ($symptomIDs as $symptomID) {
                    if (!is_numeric($symptomID)) {
                        throw new Exception("Invalid Symptom ID: $symptomID");
                    }
                    $stmt = $this->conn->prepare("CALL AddDiseaseSymptom(:diseaseID, :symptomID);");
                    $stmt->execute([':diseaseID' => $diseaseID,':symptomID' => $symptomID]);
                }
            }

            return 1; // Success
        } catch (PDOException $e) {
            error_log("Database error creating disease: " . $e->getMessage());
            return 0; // Failure
        } catch (Exception $e) {
            error_log("Error creating disease: " . $e->getMessage());
            return 0; // Failure
        }
    }

    function getCreatedID() {
        try {
            $stmt = $this->conn->prepare("CALL GetLastDiseaseID();");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching last Disease ID: " . $e->getMessage());
            return [];
        }
    }

    function deleteDiseaseData($dataId) {
        try {
            $stmt = $this->conn->prepare("Call DeleteDisease(:DataID);");
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
    
            $stmt = $this->conn->prepare("Call UpdateDiseaseByID(:DataID, :DisName, :description, :classification, :categoryID, :note);");
            $stmt->execute([':DataID' => $Id, ':DisName' => $disName, ':description' => $description, 
                ':classification' => $classification, ':categoryID' => $CategoryID, ':note' => $note]);
            return 1;
        } catch (PDOException $e) {
            die("Error Modifying data: " . $e->getMessage());
            return 0; // Return false on failure
        }
    }

    function checkDataById($dataId) {
        try {
            $stmt = $this->conn->prepare("Call SearchDiseaseByID(:DataID);");
            $stmt->execute([':DataID' => $dataId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

    public function checkDataByName($name) {
        try {
            $stmt = $this->conn->prepare("CALL SearchDiseaseByName(:searchLetter)");
            $stmt->execute([':searchLetter' => $name]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching data by name: " . $e->getMessage());
            return [];
        }
    }

    public function checkDataByLetter($name) {
        try {
            $stmt = $this->conn->prepare("CALL SearchDiseaseByLetter(:searchLetter)");
            $stmt->execute([':searchLetter' => $name]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching data by name: " . $e->getMessage());
            return [];
        }
    }
}

