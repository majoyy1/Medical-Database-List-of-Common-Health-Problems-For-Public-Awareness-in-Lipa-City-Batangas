<?php
require_once 'connection.php';

//Treatment CRUD
class CrudTreatment extends dbconnection {

    function __construct() {
        parent::__construct();
    }

    public function read() {
        try {
            $stmt = $this->conn->prepare("CALL ShowListOfTreatment();"); // Ensure proper syntax for stored procedure call
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching data: " . $e->getMessage()); // Log error instead of using die
            return [];
        }
    }

    function cleanData($dataCleaned) {
        return htmlspecialchars(trim($dataCleaned));
    }

    function createTreatment($TreatmentName, $description) {
        try {
            $stmt = $this->conn->prepare("Call AddTreatment(:TreatmentName, :description);");
            $stmt->execute([':TreatmentName' => $TreatmentName, ':description' => $description]);
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
            error_log("Error deleting treatment: " . $e->getMessage()); // Log error instead of using die
            return 0;
        }
    }

    function checkTreatmentById($id) {
        try {
            $stmt = $this->conn->prepare("Call CheckCategoryOfId(:id);");
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching treatment by ID: " . $e->getMessage()); // Log error instead of using die
            return [];
        }
    }

}
$test = new CrudTreatment();
var_dump($test->read());
echo "hello";

?>