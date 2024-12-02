<?php
/**
 * @file index.php
 * @brief This file is the entry point of the application, handling routing and controlling 
 *        various requests for the FoodieGo application.
 * 
 * The script defines the base path, starts the session, includes configuration files, 
 * and processes incoming requests to route to appropriate controllers and actions.
 * It supports various routes including the home page, menu, login, register, and more.
 */

// Define BASEPATH to allow direct script access
define('BASEPATH', true);

// Start the session to manage user sessions
session_start();

// Include configuration files for application and database
require_once 'application/config/application-config.php';  /**< Include application settings */
require_once 'application/config/database-config.php';  /**< Include database connection settings */

// Get the requested URL (e.g., /FoodieGo/menu)
$request = $_SERVER['REQUEST_URI'];

// Set base path for the application (e.g., '/FoodieGo/')
$base_path = '/FoodieGo/';
$request = str_replace($base_path, '', $request);  /**< Remove base path from the URL */

// Extract any query parameters (e.g., /food-details?id=123)
$request_parts = explode('?', $request);
$request = $request_parts[0];  /**< Remove query parameters from the request URL */

// Basic routing mechanism to handle various requests
switch ($request) {
    /**
     * @case '' | '/' 
     * @brief Route for the home or menu page.
     * 
     * If the URL is empty or the root ("/"), the menu method of the Food controller is called 
     * to display the list of food items.
     */
    case '':
    case '/':
        require 'application/controllers/food.php';  /**< Include the food controller */
        $controller = new Food();  /**< Create a new instance of the Food controller */
        $controller->menu();  /**< Call the menu method to display the food menu */
        break;
    
    /**
     * @case 'menu'
     * @brief Explicit route for the menu page.
     * 
     * If the "menu" route is requested, the menu method of the Food controller is called 
     * to display the list of food items.
     */
    case 'menu':
        require 'application/controllers/food.php';
        $controller = new Food();
        $controller->menu();  /**< Display the menu */
        break;

    /**
     * @case 'food-details'
     * @brief Route to display details of a specific food item.
     * 
     * The food item details page is displayed by calling the details method of the Food controller.
     * The food item ID is extracted from the query parameter `id`. If the ID is provided, the details 
     * page is shown; otherwise, the user is redirected to the menu page.
     */
    case 'food-details':
        require 'application/controllers/food.php';
        $controller = new Food();
        $id = $_GET['id'] ?? null;  /**< Get the food item ID from query parameters */
        if ($id) {
            $controller->details($id);  /**< Show details for the specified food item */
        } else {
            header("Location: " . SITEURL . "menu");  /**< Redirect to the menu if no ID is provided */
        }
        break;

    /**
     * @case 'search'
     * @brief Route for food search functionality.
     * 
     * The search method of the Food controller is called to handle searching for food items.
     */
    case 'search':
        require 'application/controllers/food.php';
        $controller = new Food();
        $controller->search();  /**< Perform a food search */
        break;

    /**
     * @case 'login'
     * @brief Route to show the login page.
     * 
     * The login form is displayed by calling the login method of the Auth controller.
     */
    case 'login':
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->login();  /**< Show the login form */
        break;

    /**
     * @case 'register'
     * @brief Route to show the registration page.
     * 
     * The registration form is displayed by calling the register method of the Auth controller.
     */
    case 'register':
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->register();  /**< Show the registration form */
        break;

    /**
     * @case 'logout'
     * @brief Route to handle user logout.
     * 
     * The logout method of the Auth controller is called to log out the user and destroy the session.
     */
    case 'logout':
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->logout();  /**< Logout the user */
        break;

    /**
     * @case 'check-auth'
     * @brief Route to check user authentication status.
     * 
     * The check_auth method of the Auth controller is called to verify if the user is authenticated.
     */
    case 'check-auth':
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->check_auth();  /**< Check if the user is authenticated */
        break;

    /**
     * @case 'order'
     * @brief Route to handle creating a new order.
     * 
     * The create method of the Order controller is called to process the creation of a new order.
     */
    case 'order':
        require 'application/controllers/order.php';
        $controller = new Order();
        $controller->create();  /**< Create a new order */
        break;

    /**
     * @case 'admin/dashboard'
     * @brief Route to display the admin dashboard.
     * 
     * The dashboard method of the Admin controller is called to display the admin dashboard page.
     */
    case 'admin/dashboard':
        require 'application/controllers/admin.php';
        $controller = new Admin();
        $controller->dashboard();  /**< Display the admin dashboard */
        break;

    /**
     * @default
     * @brief Default case to handle 404 errors.
     * 
     * If the requested route is not recognized, a 404 HTTP response is sent, and the 404 error page is displayed.
     */
    default:
        http_response_code(404);  /**< Set the HTTP response code to 404 (Not Found) */
        require 'application/views/404.php';  /**< Load the 404 error page */
        break;
}
?>