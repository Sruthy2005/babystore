<?php
session_start();
require_once "config.php";
require_once "classes/Cart.php";
require_once "classes/Product.php";

$cartObj = new Cart();
$productObj = new Product();
$items = $cartObj->getItems();

if (empty($items)) {
    header("Location: index.php");
    exit;
}

// Calculate total amount in INR
$total = 0;
foreach ($items as $id => $item) {
    $product = $productObj->getProductById($id);
    $total += $product['price'] * $item['quantity'];
}

// Convert to paise for Razorpay
$amount = $total * 100;

include "includes/header.php";
?>


<h2 class="text-center my-4">🛒 Checkout</h2>

<table class="table table-bordered">
<thead>
<tr>
    <th>Product</th>
    <th>Quantity</th>
    <th>Price</th>
    <th>Subtotal</th>
</tr>
</thead>
<tbody>
<?php foreach ($items as $id => $item):
    $product = $productObj->getProductById($id);
    $subtotal = $product['price'] * $item['quantity'];
?>
<tr>
    <td><?= $product['name']; ?></td>
    <td><?= $item['quantity']; ?></td>
    <td>₹<?= $product['price']; ?></td>
    <td>₹<?= $subtotal; ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<h4 class="text-end">Total: ₹<?= $total; ?></h4>

<!-- Razorpay Payment Button -->
<form action="payment_success.php" method="POST">
    <script
        src="https://checkout.razorpay.com/v1/checkout.js"
        data-key="<?= RAZORPAY_KEY_ID; ?>"
        data-amount="<?= $amount; ?>"
        data-currency="INR"
        data-buttontext="Pay Now"
        data-name="Baby Store"
        data-description="Baby Products Payment"
        data-image="assets/images/logo.png"
        data-prefill.name="Guest"
        data-prefill.email="guest@example.com"
        data-theme.color="#0d6efd">
    </script>
    <input type="hidden" name="cart_total" value="<?= $total; ?>">
</form>

<?php include "includes/footer.php"; ?>
