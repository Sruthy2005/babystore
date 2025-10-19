<?php
require_once "Database.php";
require_once "config.php";

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM products";
        return $this->db->conn->query($sql);
    }

    public function getProductById($id) {
        $sql = "SELECT * FROM products WHERE id = $id";
        return $this->db->conn->query($sql)->fetch_assoc();
    }
}
?>
