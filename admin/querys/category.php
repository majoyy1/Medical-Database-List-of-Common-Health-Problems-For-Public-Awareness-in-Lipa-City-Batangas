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

}


?>