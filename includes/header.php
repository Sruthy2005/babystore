
<!DOCTYPE html>
<html>
<head>
    <title>🍼 Baby Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🍼 Baby Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item">
            <a href="cart.php" class="btn btn-success me-2">Cart 🛒
                <?php
                if(isset($_SESSION['cart'])){
                    $count = 0;
                    foreach($_SESSION['cart'] as $item){
                        $count += $item['quantity'];
                    }
                    echo " ($count)";
                }
                ?>
            </a>
        </li>
        <?php if(isset($_SESSION['user_name'])) { ?>
            <li class="nav-item">
                <span class="nav-link">Hello, <?= $_SESSION['user_name']; ?></span>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="btn btn-danger ms-2">Logout</a>
            </li>
        <?php } else { ?>
            <li class="nav-item">
                <a href="login.php" class="btn btn-primary ms-2">Login</a>
            </li>
            <li class="nav-item">
                <a href="register.php" class="btn btn-secondary ms-2">Register</a>
            </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
