<?php
require_once "Database.php";
require_once "config.php";

class Order {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Save order in the database
    public function createOrder($userId, $cartItems, $totalAmount) {
        // Insert into orders table
        $sql = "INSERT INTO orders(user_id, total_amount, created_at) 
                VALUES($userId, $totalAmount, NOW())";
        if ($this->db->conn->query($sql)) {
            $orderId = $this->db->conn->insert_id;

            // Insert order items
            foreach($cartItems as $productId => $item) {
                $qty = $item['quantity'];
                $productSql = "SELECT price FROM products WHERE id=$productId";
                $productRes = $this->db->conn->query($productSql);
                $price = $productRes->fetch_assoc()['price'];

                $sqlItem = "INSERT INTO order_items(order_id, product_id, quantity, price)
                            VALUES($orderId, $productId, $qty, $price)";
                $this->db->conn->query($sqlItem);
            }

            return $orderId;
        } else {
            return false;
        }
    }
}
?>
