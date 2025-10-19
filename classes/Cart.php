<?php
class Cart {
    public function __construct() {
        // Initialize cart session if not already set
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Add a product to the cart
    public function addProduct($id) {
        // If product already in cart, increase quantity
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            // Add new product with quantity 1
            $_SESSION['cart'][$id] = ['quantity' => 1];
        }
    }

    // Remove a product from the cart
    public function removeProduct($id) {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
    }

    // Get all cart items
    public function getItems() {
        return $_SESSION['cart'];
    }

    // Clear the entire cart
    public function clearCart() {
        $_SESSION['cart'] = [];
    }

    // Update product quantity
    public function updateQuantity($id, $qty) {
        if (isset($_SESSION['cart'][$id]) && $qty > 0) {
            $_SESSION['cart'][$id]['quantity'] = $qty;
        } elseif ($qty <= 0) {
            $this->removeProduct($id);
        }
    }

    // Get total items count
    public function getTotalItems() {
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['quantity'];
        }
        return $total;
    }
}
?>
