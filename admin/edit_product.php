<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../login.php");
    exit;
}

require_once "../classes/Database.php";
$db = new Database();
$conn = $db->conn;

$id = $_GET['id'];
$message = "";

// Fetch product
$stmt = $conn->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if(isset($_POST['update_product'])){
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Image upload
    if(!empty($_FILES['image']['name'])){
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp_name, "../assets/images/".$image);
    } else {
        $image = $product['image'];
    }

    // Update database
    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, image=? WHERE id=?");
    $stmt->bind_param("sdsi", $name, $price, $image, $id);
    if($stmt->execute()){
        $message = "Product updated successfully!";
        // Refresh product data
        $product['name'] = $name;
        $product['price'] = $price;
        $product['image'] = $image;
    } else {
        $message = "Failed to update product!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Product - Admin</title>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.header { display:flex; justify-content: space-between; align-items:center; margin-bottom:20px; }
</style>
</head>
<body>
<div class="container mt-4">
    <div class="header">
        <h2>Edit Product</h2>
        <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <?php if($message) echo "<div class='alert alert-info'>$message</div>"; ?>

    <form method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width:500px;">
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" value="<?= $product['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Price (₹)</label>
            <input type="number" name="price" class="form-control" step="0.01" value="<?= $product['price']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            <small>Current: <?= $product['image']; ?></small>
        </div>
        <button type="submit" name="update_product" class="btn btn-primary w-100">Update Product</button>
    </form>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
