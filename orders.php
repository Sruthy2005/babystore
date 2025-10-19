<?php
session_start();
require_once "classes/Order.php";

// Redirect to login if not logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php?redirect=orders.php");
    exit;
}

$orderObj = new Order();
$userId = $_SESSION['user_id'];

// Fetch all orders for this user
$orders = $orderObj->getOrdersByUser($userId);

include "includes/header.php";
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">🧾 My Orders</h2>

    <?php if(empty($orders)) { ?>
        <p class="text-center">You have not placed any orders yet. <a href="index.php">Shop Now</a></p>
    <?php } else { ?>
        <div class="row">
            <?php foreach($orders as $order) { ?>
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Order #<?= $order['id']; ?></h5>
                            <p class="card-text">
                                Placed on: <?= date('d M Y, H:i', strtotime($order['created_at'])); ?><br>
                                Total: ₹<?= $order['total_amount']; ?><br>
                            </p>
                            <a href="order_details.php?order_id=<?= $order['id']; ?>" class="btn btn-info btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<?php include "includes/footer.php"; ?>
