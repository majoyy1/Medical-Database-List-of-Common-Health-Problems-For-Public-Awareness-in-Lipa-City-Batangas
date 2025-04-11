<?php
require_once 'connection.php';
//$test = new dbconnection;

class crud {
    public $test;

    function __construct(){
        $db = new dbconnection;
        $this->test = $db->getConnection();
    }
    
    public function read() {
        try {
            $stmt = $this->test->prepare("Call GetDisease"); // Use the new procedure
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

}

?>