<?php
defined('BASEPATH') OR exit('No direct script access allowed');  // Prevent direct script access

/**
 * @file auth.php
 * @brief This file contains the Auth class responsible for handling user authentication (login, registration, logout).
 * 
 * The Auth class manages the user authentication process by interacting with the database through the Auth_model.
 * It provides methods for user login, registration, logout, and checking user authentication status.
 */

/**
 * @class Auth
 * @brief Class responsible for handling user authentication, including login, registration, and logout functionalities.
 * 
 * This class works with the `Auth_model` to perform database operations for user authentication. It provides methods
 * for logging in, registering, logging out, and checking if the user is authenticated.
 */
class Auth {
    /**
     * @var $auth_model
     * @brief Holds the instance of the `Auth_model` for interacting with the database.
     * 
     * This variable is used to call methods from the `Auth_model` class, such as checking if the user is logged in,
     * getting the user role, and performing login and registration operations.
     */
    private $auth_model;

    /**
     * @brief Constructor that initializes the Auth class and starts the session if not already started.
     * 
     * The constructor starts a session (if not already active) and loads the `Auth_model` to interact with the database.
     */
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();  /**< @brief Start session if it is not already started */
        }
        require_once __DIR__ . '/../models/auth-model.php';  /**< @brief Include the Auth_model for database interactions */
        $this->auth_model = new Auth_model();  /**< @brief Instantiate the Auth_model */
    }

    /**
     * @brief Handles the user login process.
     * 
     * This method checks if the user is already logged in, and if so, redirects them based on their role.
     * If the user is not logged in, the method validates the login form data, attempts to log the user in, 
     * and redirects the user based on their role.
     * 
     * @return void
     */
    public function login() {
        // If already logged in, redirect to the appropriate page based on user role
        if ($this->auth_model->is_logged_in()) {
            $role = $this->auth_model->get_user_role();  /**< @brief Get the role of the logged-in user */
            header("Location: " . SITEURL . ($role === 'admin' ? 'admin/dashboard' : 'menu'));  /**< @brief Redirect based on user role */
            exit();
        }

        $error = '';  /**< @brief Initialize error variable */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  /**< @brief Check if form was submitted via POST */
            $username = $_POST['username'] ?? '';  /**< @brief Get the username from the form */
            $password = $_POST['password'] ?? '';  /**< @brief Get the password from the form */

            // Validate user input
            if (empty($username) || empty($password)) {
                $error = "Please fill in all fields";  /**< @brief Error if any field is empty */
            } else {
                // Attempt to log the user in using the provided credentials
                $result = $this->auth_model->login($username, $password);

                if ($result['status']) {
                    // If login is successful, set session variables and redirect based on role
                    $_SESSION['user_id'] = $result['user_data']['id'] ?? $result['user_data']['customer_email'];  /**< @brief Store user ID or email in session */
                    $_SESSION['username'] = $result['user_data']['username'] ?? $result['user_data']['customer_name'];  /**< @brief Store username or customer name */
                    $_SESSION['user_role'] = $result['role'];  /**< @brief Store user role */
                    header("Location: " . SITEURL . ($result['role'] === 'admin' ? 'admin/dashboard' : 'menu'));  /**< @brief Redirect to dashboard or menu based on role */
                    exit();
                } else {
                    $error = "Invalid username or password";  /**< @brief Error if login fails */
                }
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';  /**< @brief Load the login view */
    }

    /**
     * @brief Handles the user registration process.
     * 
     * This method checks if the user is already logged in, and if so, redirects them to the menu. 
     * If the user is not logged in, the method validates the registration form data, attempts to register the user, 
     * and redirects them to the login page upon successful registration.
     * 
     * @return void
     */
    public function register() {
        // If already logged in, redirect to menu
        if ($this->auth_model->is_logged_in()) {
            header("Location: " . SITEURL . "menu");
            exit();
        }

        $error = '';  /**< @brief Initialize error variable */
        $success = '';  /**< @brief Initialize success variable */

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {  /**< @brief Check if form was submitted via POST */
            $name = $_POST['name'] ?? '';  /**< @brief Get the name from the form */
            $email = $_POST['email'] ?? '';  /**< @brief Get the email from the form */
            $password = $_POST['password'] ?? '';  /**< @brief Get the password from the form */
            $confirm_password = $_POST['confirm_password'] ?? '';  /**< @brief Get the confirm password from the form */
            $phone = $_POST['phone'] ?? '';  /**< @brief Get the phone number from the form */

            // Validate user input
            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                $error = "Please fill in all required fields";  /**< @brief Error if required fields are empty */
            } elseif ($password !== $confirm_password) {
                $error = "Passwords do not match";  /**< @brief Error if passwords don't match */
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format";  /**< @brief Error if email format is invalid */
            } else {
                // Attempt to register the user with the provided data
                $result = $this->auth_model->register($name, $email, $password, $phone);

                if ($result['status']) {
                    $success = "Registration successful! Please login.";  /**< @brief Success message if registration is successful */
                    // Redirect to login page after successful registration
                    header("Location: " . SITEURL . "login?registered=1");
                    exit();
                } else {
                    $error = $result['message'];  /**< @brief Error message if registration fails */
                }
            }
        }

        require_once __DIR__ . '/../views/auth/register.php';  /**< @brief Load the registration view */
    }

    /**
     * @brief Handles the user logout process.
     * 
     * This method destroys the current session and redirects the user to the login page.
     * 
     * @return void
     */
    public function logout() {
        session_destroy();  /**< @brief Destroy the session to log the user out */
        header("Location: " . SITEURL . "login");  /**< @brief Redirect to login page */
        exit();
    }

    /**
     * @brief Checks if the user is logged in (for AJAX requests).
     * 
     * This method returns the login status and user role in JSON format. It is used for checking authentication status 
     * through AJAX requests.
     * 
     * @return void
     */
    public function check_auth() {
        header('Content-Type: application/json');  /**< @brief Set the response content type to JSON */
        echo json_encode([
            'logged_in' => $this->auth_model->is_logged_in(),  /**< @brief Check if user is logged in */
            'user_role' => $this->auth_model->get_user_role()  /**< @brief Get the user's role */
        ]);
    }
}
?>