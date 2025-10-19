<?php
session_start();
require_once "config.php";
require_once "classes/Cart.php";
require_once "classes/Order.php";

$cartObj = new Cart();
$orderObj = new Order();
$items = $cartObj->getItems();

// Assume user ID = 1 for testing
$userId = $_SESSION['user_id'] ?? 1;
$total = $_POST['cart_total'] ?? 0;

// Save order
$orderId = $orderObj->createOrder($userId, $items, $total);

// Clear cart
$cartObj->clearCart();

include "includes/header.php";
?>

<div class="text-center mt-5">
    <h2>✅ Payment Successful!</h2>
    <p>Thank you for your purchase. Your Order ID is <strong>#<?= $orderId; ?></strong></p>
    <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
</div>

<?php include "includes/footer.php"; ?>
