<?php
require_once 'db_connect.php';

class SymptomChecker {
    private $conn;

    // Constructor initializes the DB connection
    public function __construct() {
        $db = new DbConnection();
        $this->conn = $db->getConnection();
    }

    // Fetch all symptoms from the database
    public function getSymptoms() {
        try {
            $stmt = $this->conn->prepare("CALL GetSymptoms()");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    

    // Get possible diseases based on selected symptoms
    public function getPossibleDiseases($selectedSymptoms) {
        $symptomString = implode(',', $selectedSymptoms);
        try {
            $stmt = $this->conn->prepare("CALL GetPossibleDiseases(:symptoms)");
            $stmt->bindParam(':symptoms', $symptomString, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
    // Get treatments related to the diseases
    public function getTreatments($diseaseIds) {
        if (empty($diseaseIds)) {
            return [];
        }
        
        // Convert the array of disease IDs to a comma-separated string
        $diseaseIdsString = implode(',', $diseaseIds);
        
        try {
            // Call the stored procedure with the disease IDs as a string
            $stmt = $this->conn->prepare("CALL GetTreatmentsForDiseases(:disease_ids)");
            $stmt->bindParam(':disease_ids', $diseaseIdsString, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }   

    // Destructor to close the DB connection
    public function __destruct() {
        $this->conn = null;
    }
}