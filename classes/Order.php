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

    // Get all orders of a specific user
    public function getOrdersByUser($userId){
        $sql = "SELECT * FROM orders WHERE user_id=$userId ORDER BY created_at DESC";
        $result = $this->db->conn->query($sql);
        $orders = [];
        while($row = $result->fetch_assoc()){
            $orders[] = $row;
        }
        return $orders;
    }

    // Get details of a specific order (items)
    public function getOrderById($orderId){
        $sql = "SELECT * FROM orders WHERE id=$orderId";
        $result = $this->db->conn->query($sql);
        if($result->num_rows > 0){
            $order = $result->fetch_assoc();

            // Fetch items
            $sqlItems = "SELECT oi.*, p.name, p.image 
                         FROM order_items oi 
                         JOIN products p ON oi.product_id=p.id 
                         WHERE oi.order_id=$orderId";
            $itemsRes = $this->db->conn->query($sqlItems);
            $items = [];
            while($item = $itemsRes->fetch_assoc()){
                $items[] = $item;
            }

            $order['items'] = $items;
            return $order;
        }
        return false;
    }
}
?>
