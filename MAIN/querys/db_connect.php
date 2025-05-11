<?php

class dbconnection {
    private $host = "localhost";
    private $dbName = "local_disease_registry_lipa_city";
    private $username = "root";
    private $password = "";
    protected $conn;

    // Constructor to establish the database connection
    function __construct() {
        try {
            // Attempt to create a connection to the database using PDO
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Test the connection by running a simple query
            $test = $this->conn->query("CALL testMainDbConnection;");
            
            if ($test && $test->fetchColumn()) {
                // Uncomment below if you want a success message
                // echo "Connection Success";
                return $this->conn;
            }

            throw new Exception("Database Error");

        } catch(Exception $e) {
            // Log the error message if the connection fails
            error_log("Connection failed: " . $e->getMessage());
            die("Connection Failed: No Database Connected" . $e->getMessage());
        }
    }

    // Get the connection object
    public function getConnection() {
        return $this->conn;
    }

    // Destructor to close the database connection
    function __destruct() {
        $this->conn = null;
    }
}

?>
