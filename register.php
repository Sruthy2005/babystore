<?php
session_start();
require_once "classes/User.php";
$userObj = new User();
$message = "";

if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if($userObj->register($name,$email,$password)){
        $message = "Registration successful! <a href='login.php'>Login here</a>";
    } else {
        $message = "Email already exists or error occurred.";
    }
}
include "includes/header.php";
?>
<div class="container mt-5">
  <h2 class="text-center mb-4">Register</h2>
  <form method="post" class="mx-auto" style="max-width:400px;">
    <?php if($message) echo "<div class='alert alert-info'>$message</div>"; ?>
    <div class="mb-3">
      <input type="text" name="name" class="form-control" placeholder="Full Name" required>
    </div>
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>
    <button type="submit" name="register" class="btn btn-success w-100">Register</button>
    <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
  </form>
</div>
<?php include "includes/footer.php"; ?>
