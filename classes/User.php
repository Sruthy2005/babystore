<?php
require_once "Database.php";

class User {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    // Register new user
    public function register($name, $email, $password){
        // Check if email already exists
        $check = $this->db->conn->query("SELECT * FROM users WHERE email='$email'");
        if($check->num_rows > 0){
            return "Email already registered!";
        }

        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $sql = "INSERT INTO users (name,email,password) VALUES ('$name','$email','$passwordHash')";
        if($this->db->conn->query($sql)){
            return true;
        } else {
            return "Error registering user: " . $this->db->conn->error;
        }
    }

    // Login user
    public function login($email, $password){
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $this->db->conn->query($sql);
        if($result->num_rows == 1){
            $user = $result->fetch_assoc();
            if(password_verify($password, $user['password'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email']; // useful for checkout prefill
                return true;
            }
        }
        return false;
    }

    // Check if user is logged in
    public function isLoggedIn(){
        return isset($_SESSION['user_id']);
    }
}
?>
