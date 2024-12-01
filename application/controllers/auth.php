<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {
    private $auth_model;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        require_once __DIR__ . '/../models/auth-model.php';
        $this->auth_model = new Auth_model();
    }

    // Handle user login
    public function login() {
        // If already logged in, redirect to appropriate page
        if ($this->auth_model->is_logged_in()) {
            $role = $this->auth_model->get_user_role();
            header("Location: " . SITEURL . ($role === 'admin' ? 'admin/dashboard' : 'menu'));
            exit();
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $error = "Please fill in all fields";
            } else {
                $result = $this->auth_model->login($username, $password);

                if ($result['status']) {
                    $_SESSION['user_id'] = $result['user_data']['id'] ?? $result['user_data']['customer_email'];
                    $_SESSION['username'] = $result['user_data']['username'] ?? $result['user_data']['customer_name'];
                    $_SESSION['user_role'] = $result['role'];
                    header("Location: " . SITEURL . ($result['role'] === 'admin' ? 'admin/dashboard' : 'menu'));
                    exit();
                } else {
                    $error = "Invalid username or password";
                }
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    // Handle user registration
    public function register() {
        // If already logged in, redirect
        if ($this->auth_model->is_logged_in()) {
            header("Location: " . SITEURL . "menu");
            exit();
        }

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $phone = $_POST['phone'] ?? '';

            // Validate input
            if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
                $error = "Please fill in all required fields";
            } elseif ($password !== $confirm_password) {
                $error = "Passwords do not match";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Invalid email format";
            } else {
                // Try to register the user
                $result = $this->auth_model->register($name, $email, $password, $phone);
                
                if ($result['status']) {
                    $success = "Registration successful! Please login.";
                    // Redirect to login page instead of auto-login
                    header("Location: " . SITEURL . "login?registered=1");
                    exit();
                } else {
                    $error = $result['message'];
                }
            }
        }

        require_once __DIR__ . '/../views/auth/register.php';
    }

    // Handle user logout
    public function logout() {
        session_destroy();
        header("Location: " . SITEURL . "login");
        exit();
    }

    // Check if user is logged in (for AJAX requests)
    public function check_auth() {
        header('Content-Type: application/json');
        echo json_encode([
            'logged_in' => $this->auth_model->is_logged_in(),
            'user_role' => $this->auth_model->get_user_role()
        ]);
    }
}