<?php

class Database {
   
    private $host = "localhost";    
    private $username = "root";   
    private $password = "";        
    private $dbname = "library";   

    // Property to hold the PDO object
    protected $conn;

    // Method to connect to the database
    public function connect() {
        $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);

        return $this->conn;
    }
}

// Example usage:
// $obj = new Database();
// var_dump($obj->connect()); // Shows PDO object if successful
