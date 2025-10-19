<?php
session_start();

// Admin session check
if(!isset($_SESSION['admin_logged_in'])){
    header("Location: ../login.php");
    exit;
}

require_once "../classes/Database.php";
$db = new Database();
$conn = $db->conn;

// Fetch products
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - Baby Store</title>
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #f8f9fa; }
.table img { border-radius: 5px; }
.header { display:flex; justify-content: space-between; align-items:center; margin-bottom:20px; }
</style>
</head>
<body>
<div class="container mt-4">
    <div class="header">
        <h2>Admin Dashboard</h2>
        <div>
            <span class="me-3">Welcome, <?= $_SESSION['username'] ?? 'Admin'; ?></span>
            <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>

    <a href="add_product.php" class="btn btn-success mb-3">+ Add New Product</a>

    <table class="table table-striped table-bordered shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price (₹)</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()){ ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['price']; ?></td>
                <td><img src="../assets/images/<?= $row['image']; ?>" width="80" alt="<?= $row['name']; ?>"></td>
                <td>
                    <a href="edit_product.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="delete_product.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
