<?php

class dbconnection {
    private $host = "localhost";
    private $dbName =   "";
    private $username = "root";
    private $password = "";
    private $conn;

    function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
          }
    }

  function __deconstruct() {
    $this->conn = null;
  }

}
?>