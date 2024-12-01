<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../config/DB_config.php';

class Auth_Model {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Check if user is logged in
    public function is_logged_in() {
        error_log('Checking login status: ' . print_r($_SESSION, true));
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    // Get current user's role
    public function get_user_role() {
        return $_SESSION['user_role'] ?? null;
    }

    // Handle user login
    public function login($username, $password) {
        // Sanitize inputs
        $username = mysqli_real_escape_string($this->db, $username);
        
        // First check users table
        $query = "SELECT * FROM users WHERE email = '$username'";
        error_log('Login query: ' . $query);
        $result = mysqli_query($this->db, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                error_log('User found in users table: ' . print_r($user, true));
                return [
                    'status' => true,
                    'user_data' => $user,
                    'role' => $user['role']
                ];
            }
        }

        // Then check admin table for backward compatibility
        $query = "SELECT * FROM admin WHERE username = '$username'";
        error_log('Admin login query: ' . $query);
        $result = mysqli_query($this->db, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $admin = mysqli_fetch_assoc($result);
            // For admin table, we're still using plain password comparison
            if ($admin['password'] === $password) {
                error_log('User found in admin table: ' . print_r($admin, true));
                return [
                    'status' => true,
                    'user_data' => $admin,
                    'role' => 'admin'
                ];
            }
        }

        error_log('Login failed for username: ' . $username);
        return ['status' => false];
    }

    // Handle user registration
    public function register($name, $email, $password, $phone = '') {
        // Check if email already exists
        $email = mysqli_real_escape_string($this->db, $email);
        $query = "SELECT id FROM users WHERE email = '$email'";
        $result = mysqli_query($this->db, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return [
                'status' => false,
                'message' => 'Email already exists'
            ];
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Prepare other fields
        $name = mysqli_real_escape_string($this->db, $name);
        $phone = mysqli_real_escape_string($this->db, $phone);
        
        // Insert new user
        $query = "INSERT INTO users (name, email, password, phone, role) VALUES ('$name', '$email', '$hashed_password', '$phone', 'customer')";
        
        if (mysqli_query($this->db, $query)) {
            return [
                'status' => true,
                'user_id' => mysqli_insert_id($this->db)
            ];
        }
        
        return [
            'status' => false,
            'message' => 'Registration failed'
        ];
    }}