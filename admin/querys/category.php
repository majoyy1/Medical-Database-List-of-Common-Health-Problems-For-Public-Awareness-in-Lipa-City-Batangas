<?php
require_once 'connection.php';

//Category CRUD
class CrudCategory extends Connection {

    function __construct() {
        parent::__construct();
    }

    public function read() {
        try {
            $stmt = $this->dbConn->prepare("Call ShowListOfCategory;"); // Use the new procedure
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

}


?>