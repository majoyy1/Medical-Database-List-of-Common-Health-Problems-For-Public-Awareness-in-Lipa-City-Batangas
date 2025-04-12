<?php

class dbconnection {
    private $host = "localhost";
    private $dbName = "local_disease_registry_lipa_city";
    private $username = "root";
    private $password = "";
    private $conn;

    function __construct() {
      try {
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       // echo "Connection Successful";
      } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
      }
      return $this->conn;  
    }

    public function getConnection() {
      return $this->conn;
    } 
   
    function __deconstruct() {
      $this->conn = null;
    }
  }
?>