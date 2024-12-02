<?php
/**
 * @file index.php
 * @brief Entry point for the FoodieGo application.
 *
 * This file handles routing and initializes the appropriate controllers and methods
 * based on the requested URL.
 */

// Define BASEPATH to allow direct script access
define('BASEPATH', true);

// Start the session
session_start();

// Load the application configuration and database settings
require_once 'application/config/config.php';
require_once 'system/database/DB_config.php';

// Get the requested URL
$request = $_SERVER['REQUEST_URI'];
$base_path = '/FoodieGo/'; 
$request = str_replace($base_path, '', $request); 

// Basic routing logic
switch ($request) {
    case '':
    case '/':
        // Route to display the menu
        require 'application/controllers/admin.php';
        $controller = new Admin();
        $controller->menu();
        break;
    
    case 'login':
        // Route to handle user login
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->login();
        break;
        
    case 'logout':
        // Route to handle user logout
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->logout();
        break;

    case 'add-food':
        // Route to add a new food item
        require 'application/controllers/admin.php';
        $controller = new Admin();
        $controller->add();
        break;
        
    case 'delete-food':
        // Route to delete a food item
        require 'application/controllers/admin.php';
        $controller = new Admin();
        $controller->delete();
        break;
        
    case 'food-details':
        // Route to display details of a specific food item
        require 'application/controllers/admin.php';
        $controller = new Admin();
        $id = $_GET['id'] ?? null; 
        $controller->details($id);
        break;
        
    default:
        // Handle 404 - Page Not Found
        http_response_code(404);
        require 'application/views/404.php';
        break;
}
