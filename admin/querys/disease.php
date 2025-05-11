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

    public function createData($DisName, $description, $classification, $categoryID, $note, $symptomIDs, $treatmentIDs) {
        try {
            if (empty($DisName) || empty($classification) || empty($categoryID)) {
                throw new Exception("Disease Name, Classification, and Category ID are required.");
            }

            $stmt = $this->conn->prepare("CALL AddDisease(:DisName, :description, :classification, :categoryID, :note);");
            $stmt->execute([
                ':DisName' => $DisName,
                ':description' => $description,
                ':classification' => $classification,
                ':categoryID' => $categoryID,
                ':note' => $note
            ]);

            $createdID = $this->getCreatedID();
            if (empty($createdID) || !isset($createdID[0]['Disease_ID'])) {
                throw new Exception("Failed to retrieve the created Disease ID.");
            }
            $diseaseID = $createdID[0]['Disease_ID'];

            if (!empty($symptomIDs) && is_array($symptomIDs)) {
                foreach ($symptomIDs as $symptomID) {
                    if (!is_numeric($symptomID)) {
                        throw new Exception("Invalid Symptom ID: $symptomID");
                    }
                    $stmt = $this->conn->prepare("CALL AddDiseaseSymptom(:diseaseID, :symptomID);");
                    $stmt->execute([':diseaseID' => $diseaseID, ':symptomID' => $symptomID]);
                }
            }

            if (!empty($treatmentIDs) && is_array($treatmentIDs)) {
                foreach ($treatmentIDs as $treatmentID) {
                    if (!is_numeric($treatmentID)) {
                        throw new Exception("Invalid Treatment ID: $treatmentID");
                    }
                    $stmt = $this->conn->prepare("CALL AddDiseaseTreatment(:diseaseID, :treatmentID);");
                    $stmt->execute([':diseaseID' => $diseaseID, ':treatmentID' => $treatmentID]);
                }
            }

            return 1;
        } catch (PDOException $e) {
            die("Database error creating disease: " . $e->getMessage());
            return 0;
        } catch (Exception $e) {
            die("Error creating disease: " . $e->getMessage());
            return 0;
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

    function modifyData($Id, $Name, $Description, $Classification, $CategoryID, $Note, $symptomIDs, $treatmentIDs) {
        try {
            $disName = $this->cleanData($Name);
            $description = $this->cleanData($Description);
            $classification = $this->cleanData($Classification);
            $note = $this->cleanData($Note);

           
            $stmt = $this->conn->prepare("CALL UpdateDiseaseByID(:DataID, :DisName, :description, :classification, :categoryID, :note);");
            $stmt->execute([
                ':DataID' => $Id,
                ':DisName' => $disName,
                ':description' => $description,
                ':classification' => $classification,
                ':categoryID' => $CategoryID,
                ':note' => $note
            ]);

            $stmt = $this->conn->prepare("CALL DeleteDiseaseSymptom(:diseaseID);");
            $stmt->execute([':diseaseID' => $Id]);

            $stmt = $this->conn->prepare("CALL DeleteDiseaseTreatment(:diseaseID);");
            $stmt->execute([':diseaseID' => $Id]);

            foreach ($symptomIDs as $symptomID) {
                if (!is_numeric($symptomID)) {
                    throw new Exception("Invalid Symptom ID: $symptomID");
                }
                $stmt = $this->conn->prepare("CALL AddDiseaseSymptom(:diseaseID, :symptomID);");
                $stmt->execute([':diseaseID' => $Id, ':symptomID' => $symptomID]);
            }

            foreach ($treatmentIDs as $treatmentID) {
                if (!is_numeric($treatmentID)) {
                    throw new Exception("Invalid Treatment ID: $treatmentID");
                }
                $stmt = $this->conn->prepare("CALL AddDiseaseTreatment(:diseaseID, :treatmentID);");
                $stmt->execute([':diseaseID' => $Id, ':treatmentID' => $treatmentID]);
            }

            return 1; 
        } catch (PDOException $e) {
            error_log("Database error modifying disease: " . $e->getMessage());
            return 0;
        } catch (Exception $e) {
            error_log("Error modifying disease: " . $e->getMessage());
            return 0;
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

