<?php
require_once __DIR__ . '/../config.php'; // <-- Fix the path
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "baby_store_oop";
    public $conn;

    public function __construct() {
        $this->connectDB();
    }

    public function connectDB() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
    }
}
?>
