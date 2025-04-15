<?php

class dbLoginConn {
    private $host = "localhost";
    private $dbName = "login_credentials";
    private $username = "root";
    private $password = "";
    protected $conn;

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

//---------------Login Crud---------------
class userCredentialCRUD extends dbLoginConn {
   
    function __construct() {
        parent::__construct();
    }

    function checkAllUser(){
        try {
            $stmt = $this->conn->prepare("Call ShowUserAuth;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }

    function AddUser($uname, $hashpass) {
        try {
            $stmt = $this->conn->prepare("Call AddUserAuth(:Uname, :hashPass);");
            $stmt->execute([':Uname' => $uname, ':hashPass' => $hashpass]);
            return true;

        } catch (PDOException $e) {
            die("Error Sending data: " . $e->getMessage());
        }
    }

    function SearchUserByUsername($uname) {
        try {
            $stmt = $this->conn->prepare("Call SearchByUserName(:name);");
            $stmt->execute([':name' => $uname]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }
}

?>