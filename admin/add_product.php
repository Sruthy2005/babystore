<?php
session_start();
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../login.php");
    exit;
}

require_once "../classes/Database.php";
$db = new Database();
$conn = $db->conn;

$message = "";

if(isset($_POST['add_product'])){
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Image upload
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $upload_dir = "../assets/images/";
    move_uploaded_file($tmp_name, $upload_dir.$image);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $price, $image);
    if($stmt->execute()){
        $message = "Product added successfully!";
    } else {
        $message = "Failed to add product!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Product - Admin</title>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.header { display:flex; justify-content: space-between; align-items:center; margin-bottom:20px; }
</style>
</head>
<body>
<div class="container mt-4">
    <div class="header">
        <h2>Add Product</h2>
        <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <?php if($message) echo "<div class='alert alert-info'>$message</div>"; ?>

    <form method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width:500px;">
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Price (₹)</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" name="add_product" class="btn btn-success w-100">Add Product</button>
    </form>
</div>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
