<?php

/**
 * Router Script
 * 
 * A lightweight routing script for handling HTTP requests and directing them to
 * the appropriate controllers. This script processes the incoming request URI,
 * matches it against predefined routes, and loads the corresponding controller.
 * If a route is not found, a 404 error page is displayed.
 * 
 * PHP Version: 7.4 or higher
 * 
 * @category Routing
 * @package  FoodieGo
 * @author   Pahela Chakma
 * @license  MIT License
 * @link     
 */

// Define BASEPATH to allow direct script access
define('BASEPATH', true);

// Start a session for user management
session_start();

/**
 * Include essential configuration files.
 */
require_once 'application/config/config.php';
require_once 'system/database/DB_config.php';

// Get the requested URL
$request = $_SERVER['REQUEST_URI'];
// Define the base path for the application
$base_path = '/FoodieGo/';

/**
 * Process and clean the request URI by removing the base path.
 */
$request = str_replace($base_path, '', $request);
$request = parse_url($request, PHP_URL_PATH);
/**
 * Basic Routing Logic
 * 
 * Matches the cleaned request URI against predefined routes and directs the 
 * request to the corresponding controller.
 */
switch ($request) {
    case '':
    case '/':
        // Load the Food controller and display the menu
        require 'application/controllers/food.php';
        $controller = new Food();
        $controller->menu();
        break;
    
    case 'login':
        // Load the Auth controller and handle login functionality
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->login();
        break;
        
    case 'logout':
        // Load the Auth controller and handle logout functionality
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->logout();
        break;

    case 'order':
        // Load the Order controller and display the order page
        require 'application/controllers/order.php';
        $controller = new Order();
        $controller->order();
        break;

    case 'process_order.php':
         // Load the ProcessOrder controller to handle order processing
        require 'application/controllers/process_order.php';
        $controller = new ProcessOrder();
        $controller->order();
        break;
        
    default:
        /**
         * Handle undefined routes by sending a 404 HTTP response code
         * and displaying the 404 error page.
         */
        http_response_code(404);
        require 'application/views/404.php';
        break;
}