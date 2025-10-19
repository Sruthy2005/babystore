<?php
session_start();
require_once "classes/Order.php";
require_once "classes/Product.php";

// Redirect to login if user not logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php?redirect=orders.php");
    exit;
}

$orderObj = new Order();
$productObj = new Product();

// Get order ID from query string
if(!isset($_GET['order_id'])){
    header("Location: orders.php");
    exit;
}

$orderId = (int)$_GET['order_id'];

// Fetch order details
$order = $orderObj->getOrderById($orderId);

// Check if order belongs to logged-in user
if(!$order || $order['user_id'] != $_SESSION['user_id']){
    echo "<p class='text-center mt-5'>Order not found or access denied.</p>";
    exit;
}

include "includes/header.php";
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Order #<?= $order['id']; ?> Details</h2>
    <p><strong>Placed on:</strong> <?= date('d M Y, H:i', strtotime($order['created_at'])); ?></p>

    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php 
        $total = 0;
        foreach($order['items'] as $item):
            $subtotal = $item['quantity'] * $item['price'];
            $total += $subtotal;
        ?>
            <tr>
                <td><?= $item['name']; ?></td>
                <td><img src="assets/images/<?= $item['image']; ?>" alt="<?= $item['name']; ?>" width="80"></td>
                <td><?= $item['quantity']; ?></td>
                <td>₹<?= $item['price']; ?></td>
                <td>₹<?= $subtotal; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h4 class="text-end">Total: ₹<?= $total; ?></h4>
    <div class="text-center mt-3">
        <a href="orders.php" class="btn btn-secondary">Back to Orders</a>
    </div>
</div>

<?php include "includes/footer.php"; ?>
