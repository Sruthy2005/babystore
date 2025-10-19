<?php
session_start();
require_once "classes/User.php";
$userObj = new User();
$message = "";

// Hardcoded admin credentials
$admin_email = "admin@gmail.com";   // You can change this
$admin_password = "admin123";           // You can change this

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check admin first
    if($email === $admin_email && $password === $admin_password){
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = "Admin";
        header("Location: admin/index.php");  // Redirect to admin dashboard
        exit;
    }

    // Regular user login
    if($userObj->login($email, $password)){
        header("Location: index.php"); // Redirect to homepage
        exit;
    } else {
        $message = "Invalid email or password!";
    }
}

include "includes/header.php";
?>

<div class="container mt-5">
  <h2 class="text-center mb-4">Login</h2>
  <form method="post" class="mx-auto" style="max-width:400px;">
    <?php if($message) echo "<div class='alert alert-danger'>$message</div>"; ?>
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>
    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
    <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register</a></p>
  </form>
</div>

<?php include "includes/footer.php"; ?>
