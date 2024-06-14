<?php

class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = 'password';
    private $dbname = 'people';
    private $conn;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->conn = new mysqli($this->localhost, $this->root, $this->1111, $this->people);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}


?>