<?php
session_start();
require_once "classes/Product.php";
require_once "classes/Cart.php";
require_once "config.php";

// Create objects
$productObj = new Product();
$cartObj = new Cart();

// Remove product from cart
if (isset($_GET['remove'])) {
    $cartObj->removeProduct($_GET['remove']);
    header("Location: cart.php");
    exit;
}

// Get cart items
$items = $cartObj->getItems();

include "includes/header.php";
?>


<?php if (empty($items)) { ?>
    <p class="text-center">Your cart is empty. <a href="index.php">Shop Now</a></p>
<?php } else { ?>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;
            foreach ($items as $id => $item) {
                $product = $productObj->getProductById($id);
                $subtotal = $product['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= $product['name']; ?></td>
                <td><?= $item['quantity']; ?></td>
                <td>₹<?= $product['price']; ?></td>
                <td>₹<?= $subtotal; ?></td>
                <td>
                    <a href="cart.php?remove=<?= $id; ?>" class="btn btn-danger btn-sm">Remove</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-end">
        <h4 class="me-3">Total: ₹<?= $total; ?></h4>
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    </div>
<?php } ?>

<?php include "includes/footer.php"; ?>
