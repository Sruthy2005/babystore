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

// Delete product
$stmt = $conn->prepare("DELETE FROM products WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
