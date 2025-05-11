<?php

class dbconnection {
    private $host = "localhost";
    private $dbName = "local_disease_registry_lipa_city";
    // private $username = "loginAdmin";
    // private $password = "Admin";
    private $username = "root";
    private $password = "";
    protected $conn;

    function __construct() {
      try {

        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $test = $this->conn->query("Call testMainDbConnection;");

        if ($test && $test->fetchColumn()) {
          // echo "Connection Success";
          return $this->conn;  
        }

        throw new Exception("Database Error");

      } catch(Exception $e) {
        error_log("Connection failed: " . $e->getMessage());
        die("Connection Failed: No Database Connected");
      }
    }

    public function getConnection() {
      return $this->conn;
    } 
   
    function __deconstruct() {
      $this->conn = null;
    }
  }
?>