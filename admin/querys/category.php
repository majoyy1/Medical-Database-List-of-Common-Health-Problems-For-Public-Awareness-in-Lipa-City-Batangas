<?php
require_once 'connection.php';

//Category CRUD
class CrudCategory extends dbconnection {

    function __construct() {
        parent::__construct();
    }

    public function read() {
        try {
            $stmt = $this->conn->prepare("Call ShowListOfCategory;"); // Use the new procedure
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

    function cleanData($dataCleaned) {
        return htmlspecialchars(trim($dataCleaned));
    }

    function createCategory($categoryName, $description) {
        try {
            $stmt = $this->conn->prepare("Call AddCategory(:categoryName, :description);");
            $stmt->execute([':categoryName' => $categoryName, ':description' => $description]);
            return 1;
            
        } catch (PDOException $e) {
            echo "<script>alert('Error Sending data: " . $e->getMessage() . "');</script>";
            
        }
    }

    function updateCategory($categoryID, $categoryName, $description) {
        try {
            $stmt = $this->conn->prepare("Call UpdateCategoryByID(:categoryID, :categoryName, :description);");
            $stmt->execute([':categoryID' => $categoryID, ':categoryName' => $categoryName, ':description' => $description]);
            return 1;
            
        } catch (PDOException $e) {
            echo "<script>alert('Error Sending data: " . $e->getMessage() . "');</script>";
            return 0;
        }
    }

    function deleteCategory($categoryID) {
        try {
            $stmt = $this->conn->prepare("Call DeleteCategory(:categoryID);");
            $stmt->execute([':categoryID' => $categoryID]);
            return 1;
            
        } catch (PDOException $e) {
            die("Error Modifiying data: " . $e->getMessage());
        }
    }

    function checkCategoryById($id) {
        try {
            $stmt = $this->conn->prepare("Call CheckCategoryOfId(:id);");
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

}


?>