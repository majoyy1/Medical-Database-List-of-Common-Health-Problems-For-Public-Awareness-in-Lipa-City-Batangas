<?php
require_once 'connection.php';

//Treatment CRUD
class CrudTreatment extends dbconnection {

    function __construct() {
        parent::__construct();
    }

    public function read() {
        try {
            $stmt = $this->conn->prepare("Call ShowListOfTreatment;"); // Use the new procedure
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

    function cleanData($dataCleaned) {
        return htmlspecialchars(trim($dataCleaned));
    }

    function createTreatment($TreatmentName, $description, $note) {
        try {
            $stmt = $this->conn->prepare("Call AddTreatment(:TreatmentName, :description, :note);");
            $stmt->execute([':TreatmentName' => $TreatmentName, ':description' => $description , ':note' => $note]);
            return 1;
            
        } catch (PDOException $e) {
            echo "<script>alert('Error Sending data: " . $e->getMessage() . "');</script>";
            
        }
    }

    function updateTreatment($TreatmentID, $TreatmentName, $description) {
        try {
            
            $stmt = $this->conn->prepare("Call UpdateTreatmentByID(:TreatmentID, :TreatmentName, :description);");
            $stmt->execute([':TreatmentID' => $TreatmentID, ':TreatmentName' => $TreatmentName, ':description' => $description]);
            return 1;
            
        } catch (PDOException $e) {
            echo "<script>alert('Error Sending data: " . $e->getMessage() . "');</script>";
            return 0;
        }
    }

    function deleteTreatment($TreatmentID) {
        try {
            $stmt = $this->conn->prepare("Call DeleteTreatment(:TreatmentID);");
            $stmt->execute([':TreatmentID' => $TreatmentID]);
            return 1;
            
        } catch (PDOException $e) {
            die("Error Modifiying data: " . $e->getMessage());
            return 0;
        }
    }

    function checkTreatmentById($id) {
        try {
            $stmt = $this->conn->prepare("Call CheckTreatmentOfId(:id);");
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

}


?>