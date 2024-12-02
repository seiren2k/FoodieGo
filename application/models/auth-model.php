<?php
defined('BASEPATH') OR exit('No direct script access allowed');

namespace FoodieGo\Models;

use FoodieGo\Config\Database;

require_once __DIR__ . '/../config/database-config.php';  // Include database configuration

/**
 * @file auth-model.php
 * @brief This file contains the `Auth_Model` class which handles user authentication tasks including login, registration, and session management.
 */

/**
 * @class Auth_Model
 * @brief Class responsible for user authentication, including login, registration, and session checks.
 * 
 * This model interacts with the database to perform authentication tasks such as checking if a user is logged in,
 * logging a user in, and registering a new user. It handles both customer and admin logins and ensures proper data validation.
 */
class Auth_Model {
    /**
     * @var $db
     * @brief Holds the database connection instance.
     * 
     * This variable stores the connection resource obtained from the singleton `Database` class instance.
     */
    private $db;

    /**
     * @brief Constructor that initializes the database connection.
     * 
     * This constructor retrieves the single instance of the `Database` class using the Singleton pattern
     * and stores the connection in the `$db` variable for future database queries.
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();  /**< @brief Get the singleton database connection */
    }

    /**
     * @brief Check if the user is logged in.
     * 
     * This method checks the current session to determine if a user is logged in by verifying the presence
     * of a `user_id` in the session data.
     * 
     * @return bool True if the user is logged in, otherwise false.
     */
    public function is_logged_in() {
        error_log('Checking login status: ' . print_r($_SESSION, true));  /**< @brief Log the session details for debugging */
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);  /**< @brief Return true if user_id exists in session */
    }

    /**
     * @brief Get the current user's role.
     * 
     * This method retrieves the role of the currently logged-in user from the session data.
     * 
     * @return string|null The user's role (e.g., 'admin', 'customer') or null if not set.
     */
    public function get_user_role() {
        return $_SESSION['user_role'] ?? null;  /**< @brief Return the user's role from the session, or null if not set */
    }

    /**
     * @brief Handle user login.
     * 
     * This method validates the provided username and password, checks the user against both the `users` and `admin`
     * tables in the database, and returns a status indicating whether the login was successful.
     * 
     * @param string $username The username (email for users, username for admins).
     * @param string $password The password provided by the user.
     * 
     * @return array An associative array containing a `status` key (true/false) and additional user data if successful.
     */
    public function login($username, $password) {
        // Sanitize inputs to prevent SQL injection
        $username = mysqli_real_escape_string($this->db, $username);  /**< @brief Sanitize the username input to prevent SQL injection */

        // First check the users table for the email
        $query = "SELECT * FROM users WHERE email = '$username'";  /**< @brief SQL query to search for the username in the users table */
        error_log('Login query: ' . $query);  /**< @brief Log the query for debugging */
        $result = mysqli_query($this->db, $query);  /**< @brief Execute the query */

        if ($result && mysqli_num_rows($result) > 0) {  /**< @brief If user exists in users table */
            $user = mysqli_fetch_assoc($result);  /**< @brief Fetch user data */
            if (password_verify($password, $user['password'])) {  /**< @brief Verify the password hash */
                error_log('User found in users table: ' . print_r($user, true));  /**< @brief Log the user data for debugging */
                return [
                    'status' => true,  /**< @brief Return success status */
                    'user_data' => $user,  /**< @brief Return user data */
                    'role' => $user['role']  /**< @brief Return user role */
                ];
            }
        }

        // Then check the admin table for backward compatibility (legacy system)
        $query = "SELECT * FROM admin WHERE username = '$username'";  /**< @brief SQL query for admin table */
        error_log('Admin login query: ' . $query);  /**< @brief Log the query for debugging */
        $result = mysqli_query($this->db, $query);  /**< @brief Execute the query */

        if ($result && mysqli_num_rows($result) > 0) {  /**< @brief If user exists in the admin table */
            $admin = mysqli_fetch_assoc($result);  /**< @brief Fetch admin data */
            // For the admin table, we're still using plain password comparison
            if ($admin['password'] === $password) {  /**< @brief Check plain password for admin */
                error_log('User found in admin table: ' . print_r($admin, true));  /**< @brief Log the admin data for debugging */
                return [
                    'status' => true,  /**< @brief Return success status */
                    'user_data' => $admin,  /**< @brief Return admin data */
                    'role' => 'admin'  /**< @brief Return admin role */
                ];
            }
        }

        error_log('Login failed for username: ' . $username);  /**< @brief Log the failed login attempt */
        return ['status' => false];  /**< @brief Return failure status if login failed */
    }

    /**
     * @brief Handle user registration.
     * 
     * This method handles the registration of a new user. It checks if the provided email already exists, hashes the
     * password, and inserts the new user data into the database.
     * 
     * @param string $name The user's full name.
     * @param string $email The user's email address.
     * @param string $password The user's password.
     * @param string $phone The user's phone number (optional).
     * 
     * @return array An associative array containing a `status` key (true/false) and a message or user ID if successful.
     */
    public function register($name, $email, $password, $phone = '') {
        // Check if email already exists
        $email = mysqli_real_escape_string($this->db, $email);  /**< @brief Sanitize email input */
        $query = "SELECT id FROM users WHERE email = '$email'";  /**< @brief SQL query to check if email exists */
        $result = mysqli_query($this->db, $query);  /**< @brief Execute the query */

        if ($result && mysqli_num_rows($result) > 0) {  /**< @brief If email already exists */
            return [
                'status' => false,  /**< @brief Return failure status */
                'message' => 'Email already exists'  /**< @brief Provide a message indicating email exists */
            ];
        }

        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);  /**< @brief Hash the password using bcrypt */
        
        // Prepare other fields
        $name = mysqli_real_escape_string($this->db, $name);  /**< @brief Sanitize name input */
        $phone = mysqli_real_escape_string($this->db, $phone);  /**< @brief Sanitize phone input */
        
        // Insert new user into the database
        $query = "INSERT INTO users (name, email, password, phone, role) VALUES ('$name', '$email', '$hashed_password', '$phone', 'customer')";  /**< @brief SQL query to insert new user */
        if (mysqli_query($this->db, $query)) {  /**< @brief Execute the query */
            return [
                'status' => true,  /**< @brief Return success status */
                'user_id' => mysqli_insert_id($this->db)  /**< @brief Return the inserted user ID */
            ];
        }
        
        return [
            'status' => false,  /**< @brief Return failure status if insertion fails */
            'message' => 'Registration failed'  /**< @brief Provide a message indicating registration failed */
        ];
    }
}
?>