<?php
defined('BASEPATH') OR exit('No direct script access allowed');  // Prevent direct script access

require_once __DIR__ . '/../config/database-config.php';  // Include database configuration

class Auth_Model {
    private $db;  // Holds the database connection instance

    // Constructor - Initializes the database connection
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();  // Get the singleton database connection
    }

    // Check if user is logged in
    public function is_logged_in() {
        error_log('Checking login status: ' . print_r($_SESSION, true));  // Log the session details for debugging
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);  // Return true if user_id exists in session
    }

    // Get current user's role
    public function get_user_role() {
        return $_SESSION['user_role'] ?? null;  // Return the user's role from the session, or null if not set
    }

    // Handle user login
    public function login($username, $password) {
        // Sanitize inputs to prevent SQL injection
        $username = mysqli_real_escape_string($this->db, $username);
        
        // First check the users table for the email
        $query = "SELECT * FROM users WHERE email = '$username'";  // SQL query to search for the username in the users table
        error_log('Login query: ' . $query);  // Log the query for debugging
        $result = mysqli_query($this->db, $query);  // Execute the query

        if ($result && mysqli_num_rows($result) > 0) {  // If user exists in users table
            $user = mysqli_fetch_assoc($result);  // Fetch user data
            if (password_verify($password, $user['password'])) {  // Verify the password hash
                error_log('User found in users table: ' . print_r($user, true));  // Log the user data for debugging
                return [
                    'status' => true,  // Return success status
                    'user_data' => $user,  // Return user data
                    'role' => $user['role']  // Return user role
                ];
            }
        }

        // Then check the admin table for backward compatibility (legacy system)
        $query = "SELECT * FROM admin WHERE username = '$username'";  // SQL query for admin table
        error_log('Admin login query: ' . $query);  // Log the query for debugging
        $result = mysqli_query($this->db, $query);  // Execute the query

        if ($result && mysqli_num_rows($result) > 0) {  // If user exists in the admin table
            $admin = mysqli_fetch_assoc($result);  // Fetch admin data
            // For the admin table, we're still using plain password comparison
            if ($admin['password'] === $password) {  // Check plain password for admin
                error_log('User found in admin table: ' . print_r($admin, true));  // Log the admin data for debugging
                return [
                    'status' => true,  // Return success status
                    'user_data' => $admin,  // Return admin data
                    'role' => 'admin'  // Return admin role
                ];
            }
        }

        error_log('Login failed for username: ' . $username);  // Log the failed login attempt
        return ['status' => false];  // Return failure status if login failed
    }

    // Handle user registration
    public function register($name, $email, $password, $phone = '') {
        // Check if email already exists
        $email = mysqli_real_escape_string($this->db, $email);  // Sanitize email input
        $query = "SELECT id FROM users WHERE email = '$email'";  // SQL query to check if email exists
        $result = mysqli_query($this->db, $query);  // Execute the query

        if ($result && mysqli_num_rows($result) > 0) {  // If email already exists
            return [
                'status' => false,  // Return failure status
                'message' => 'Email already exists'  // Provide a message indicating email exists
            ];
        }

        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Hash the password using bcrypt
        
        // Prepare other fields
        $name = mysqli_real_escape_string($this->db, $name);  // Sanitize name input
        $phone = mysqli_real_escape_string($this->db, $phone);  // Sanitize phone input
        
        // Insert new user into the database
        $query = "INSERT INTO users (name, email, password, phone, role) VALUES ('$name', '$email', '$hashed_password', '$phone', 'customer')";  // SQL query to insert new user
        if (mysqli_query($this->db, $query)) {  // Execute the query
            return [
                'status' => true,  // Return success status
                'user_id' => mysqli_insert_id($this->db)  // Return the inserted user ID
            ];
        }
        
        return [
            'status' => false,  // Return failure status if insertion fails
            'message' => 'Registration failed'  // Provide a message indicating registration failed
        ];
    }
}
?>