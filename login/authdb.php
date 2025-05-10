<?php

class dbLoginConn {
    private $host = "localhost";
    private $dbName = "login_credentials";
    // private $username = "loginAdmin";
    // private $password = "Admin";
    private $username = "root";
    private $password = "";
    protected $conn;

    function __construct() {
      try {

        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //If the database connection is failed, check if the the db has an item 
        //it must have at least one item to work
        $test = $this->conn->prepare("Call testLoginDbConnection;");
        $test->execute();
        if ($test->fetchColumn()) {
            return $this->conn;  
        } else {
            // echo "Connection Failed";
            throw new Exception("Connection Failed");
        }

        

      } catch(Exception $e) {
            die("Connection Failed: " . $e->getMessage());
      }
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

    public function SearchUserByUsername($uname) {
        try {
            $stmt = $this->conn->prepare("Call SearchByUserName(:name);");
            $stmt->execute([':name' => $uname]);
            $temp = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $temp;
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }
}

?>