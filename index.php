<?php
// Define BASEPATH to allow direct script access
define('BASEPATH', true);

// Start the session to manage user sessions
session_start();

// Include configuration files for application and database
require_once 'application/config/application-config.php';  // Application settings
require_once 'application/config/database-config.php';  // Database connection settings

// Get the requested URL (e.g., /FoodieGo/menu)
$request = $_SERVER['REQUEST_URI'];

// Set base path for the application (e.g., '/FoodieGo/')
$base_path = '/FoodieGo/';
$request = str_replace($base_path, '', $request);  // Remove base path from the URL

// Extract any query parameters (e.g., /food-details?id=123)
$request_parts = explode('?', $request);
$request = $request_parts[0];  // Remove query parameters from the request URL

// Basic routing mechanism to handle various requests
switch ($request) {
    // Handle the home or menu route
    case '':
    case '/':
        require 'application/controllers/food.php';  // Include the food controller
        $controller = new Food();  // Create a new instance of the Food controller
        $controller->menu();  // Call the menu method to display the food menu
        break;
    
    // Handle the menu route explicitly
    case 'menu':
        require 'application/controllers/food.php';
        $controller = new Food();
        $controller->menu();  // Display the menu
        break;

    // Handle food details route
    case 'food-details':
        require 'application/controllers/food.php';
        $controller = new Food();
        // Get the food item ID from query parameters (e.g., ?id=123)
        $id = $_GET['id'] ?? null;
        if ($id) {
            $controller->details($id);  // Show details for the specified food item
        } else {
            // If no ID is provided, redirect to the menu
            header("Location: " . SITEURL . "menu");
        }
        break;

    // Handle the search route
    case 'search':
        require 'application/controllers/food.php';
        $controller = new Food();
        $controller->search();  // Perform a food search
        break;

    // Handle the login route
    case 'login':
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->login();  // Show the login form
        break;

    // Handle the registration route
    case 'register':
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->register();  // Show the registration form
        break;
        
    // Handle the logout route
    case 'logout':
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->logout();  // Logout the user
        break;

    // Handle the check authentication route
    case 'check-auth':
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->check_auth();  // Check if the user is authenticated
        break;

    // Handle the order route
    case 'order':
        require 'application/controllers/order.php';
        $controller = new Order();
        $controller->create();  // Create a new order
        break;

    // Handle the admin dashboard route
    case 'admin/dashboard':
        require 'application/controllers/admin.php';
        $controller = new Admin();
        $controller->dashboard();  // Display the admin dashboard
        break;

    // Default case to handle 404 errors if the route is not recognized
    default:
        http_response_code(404);  // Set the HTTP response code to 404 (Not Found)
        require 'application/views/404.php';  // Load the 404 error page
        break;
}