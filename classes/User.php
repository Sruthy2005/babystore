<?php
require_once "Database.php";

class User {
    private $db;
    public function __construct() {
        $this->db = new Database();
    }

    // Register new user
    public function register($name, $email, $password){
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name,email,password) VALUES ('$name','$email','$passwordHash')";
        return $this->db->conn->query($sql);
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
