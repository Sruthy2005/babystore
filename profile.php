<?php
session_start();
require_once "classes/Database.php";

$userId = $_SESSION['user_id'] ?? 0;
if(!$userId){
    header("Location: login.php");
    exit;
}

$db = new Database();
$conn = $db->conn;
$message = "";

// Fetch user data
$userResult = $conn->query("SELECT * FROM users WHERE id=$userId");
$user = $userResult->fetch_assoc();

// Update profile
if(isset($_POST['update'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    
    $stmt = $conn->prepare("UPDATE users SET name=?, email=?, password=?, address=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $email, $password, $address, $userId);
    
    if($stmt->execute()){
        $message = "Profile updated successfully!";
        // Refresh user data
        $user['name'] = $name;
        $user['email'] = $email;
        $user['address'] = $address;
    } else {
        $message = "Error updating profile!";
    }
}

include "includes/header.php";
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">👤 My Profile</h2>
    <?php if($message) echo "<div class='alert alert-info'>$message</div>"; ?>
    <form method="POST" class="mx-auto" style="max-width:500px;">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required value="<?= $user['name']; ?>">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required value="<?= $user['email']; ?>">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="address" class="form-control" rows="3"><?= $user['address']; ?></textarea>
        </div>
        <button type="submit" name="update" class="btn btn-primary w-100">Update Profile</button>
    </form>
</div>

<?php include "includes/footer.php"; ?>
