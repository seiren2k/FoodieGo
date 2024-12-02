<?php
defined('BASEPATH') OR exit('No direct script access allowed');  // Prevent direct script access

class Auth {
    private $auth_model;  // Holds the instance of the Auth_model for interacting with the database

    // Constructor - Initializes the Auth class and starts the session if necessary
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();  // Start session if not already started
        }
        require_once __DIR__ . '/../models/auth-model.php';  // Include the Auth_model for database interactions
        $this->auth_model = new Auth_model();  // Instantiate the Auth_model
    }

    // Handle user login
    public function login() {
        // If already logged in, redirect to the appropriate page based on user role
        if ($this->auth_model->is_logged_in()) {
            $role = $this->auth_model->get_user_role();  // Get the role of the logged-in user
            header("Location: " . SITEURL . ($role === 'admin' ? 'admin/dashboard' : 'menu'));  // Redirect based on user role
            exit();
        }

        $error = '';  // Initialize error variable

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Check if form was submitted via POST
            $username = $_POST['username'] ?? '';  // Get the username from the form
            $password = $_POST['password'] ?? '';  // Get the password from the form

            // Validate user input
            if (empty($username) || empty($password)) {
                $error = "Please fill in all fields";  // Error if any field is empty
            } else {
                // Attempt to log the user in using the provided credentials
                $result = $this->auth_model->login($username, $password);

                if ($result['status']) {
                    // If login is successful, set session variables and redirect based on role
                    $_SESSION['user_id'] = $result['user_data']['id'] ?? $result['user_data']['customer_email'];  // Store user ID or email in session
                    $_SESSION['username'] = $result['user_data']['username'] ?? $result['user_data']['customer_name'];  // Store username or customer name
                    $_SESSION['user_role'] = $result['role'];  // Store user role
                    header("Location: " . SITEURL . ($result['role'] === 'admin' ? 'admin/dashboard' : 'menu'));  // Redirect to dashboard or menu based on role
                    exit();
                } else {
                    $error = "Invalid username or password";  // Error if login fails
                }
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';  // Load the login view
    }

    // Handle user registration
    public function register() {
        // If already logged in, redirect to menu
        if ($this->auth_model->is_logged_in()) {
            header("Location: " . SITEURL . "menu");
            exit();
        }

        $error = '';  // Initialize error variable
        $success = '';  // Initialize success variable

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Check if form was submitted via POST
            $name = $_POST['name'] ?? '';  // Get the name from the form
            $email = $_POST['email'] ?? '';  // Get the email from the form
            $password = $_POST['password'] ?? '';  // Get the password from the form
            $confirm_password = $_POST['confirm_password'] ?? '';  // Get the confirm password from the form
            $phone = $_POST['phone'] ?? '';  // Get the phone number from the form

            // Validate user input
            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                $error = "Please fill in all required fields";  // Error if required fields are empty
            } elseif ($password !== $confirm_password) {
                $error = "Passwords do not match";  // Error if passwords don't match
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format";  // Error if email format is invalid
            } else {
                // Attempt to register the user with the provided data
                $result = $this->auth_model->register($name, $email, $password, $phone);

                if ($result['status']) {
                    $success = "Registration successful! Please login.";  // Success message if registration is successful
                    // Redirect to login page after successful registration
                    header("Location: " . SITEURL . "login?registered=1");
                    exit();
                } else {
                    $error = $result['message'];  // Error message if registration fails
                }
            }
        }

        require_once __DIR__ . '/../views/auth/register.php';  // Load the registration view
    }

    // Handle user logout
    public function logout() {
        session_destroy();  // Destroy the session to log the user out
        header("Location: " . SITEURL . "login");  // Redirect to login page
        exit();
    }

    // Check if user is logged in (for AJAX requests)
    public function check_auth() {
        header('Content-Type: application/json');  // Set the response content type to JSON
        echo json_encode([
            'logged_in' => $this->auth_model->is_logged_in(),  // Check if user is logged in
            'user_role' => $this->auth_model->get_user_role()  // Get the user's role
        ]);
    }
}
?>