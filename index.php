<?php
session_start();
require_once "classes/Product.php";
require_once "classes/Cart.php";
require_once "config.php";


$productObj = new Product();
$cartObj = new Cart();

if(isset($_GET['add'])){
    $cartObj->addProduct($_GET['add']);
    header("Location: cart.php");
    exit;
}

$products = $productObj->getAllProducts();
include "includes/header.php";
?>

<!-- Hero Banner -->
<div class="hero-banner text-center text-white mb-5" style="background-image: url('banner2.jpg'); background-size: cover; background-position: center; height: 400px; display:flex; align-items:center; justify-content:center;">
    <div>
        <h1 class="display-4 fw-bold">Welcome to 🍼 Baby Store</h1>
        <p class="lead">High-quality products for your little ones</p>
        <a href="#products" class="btn btn-primary btn-lg">Shop Now</a>
    </div>
</div>

<!-- Products Section -->
<div class="container" id="products">
    <h2 class="text-center my-4">🍼 Baby Products</h2>
    <div class="row">
    <?php while($row = $products->fetch_assoc()){ ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="assets/images/<?= $row['image'] ?? 'BabyLotion.jpg'; ?>" class="card-img-top" height="200">
          <div class="card-body d-flex flex-column">
            <h5><?= $row['name']; ?></h5>
            <p><?= $row['description'] ?? 'High-quality baby product'; ?></p>
            <p class="fw-bold">₹<?= $row['price']; ?></p>
            <a href="index.php?add=<?= $row['id']; ?>" class="btn btn-primary mt-auto w-100">Add to Cart 🛒</a>
          </div>
        </div>
      </div>
    <?php } ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>
