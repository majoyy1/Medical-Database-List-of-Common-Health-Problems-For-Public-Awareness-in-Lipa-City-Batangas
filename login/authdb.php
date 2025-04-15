<?php

class dbLoginConn {
    private $host = "localhost";
    private $dbName = "login_credentials";
    private $username = "loginAdmin";
    private $password = "Admi";
    protected $conn;

    function __construct() {
      try {

        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $test = $this->conn->query("Call testLoginDbConnection;");

        if ($test && $test->fetchColumn()) {
            echo "Connection Success";
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
            $temp = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($temp == null){
                // echo 'Null';
                // throw new Exception("No Matched Value");
                return $temp;
            }
            return $temp;
            
        } catch (PDOException $e) {
            die("Error fetching data: " . $e->getMessage());
        }
    }
}

?>