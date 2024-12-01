<?php
// Define BASEPATH to allow direct script access
define('BASEPATH', true);

session_start();
require_once 'application/config/config.php';
require_once 'application/config/DB_config.php';

// Get the requested URL
$request = $_SERVER['REQUEST_URI'];
$base_path = '/FoodieGo/';
$request = str_replace($base_path, '', $request);

// Extract any query parameters
$request_parts = explode('?', $request);
$request = $request_parts[0];

// Basic routing
switch ($request) {
    case '':
    case '/':
        require 'application/controllers/food.php';
        $controller = new Food();
        $controller->menu();
        break;
    
    case 'menu':
        require 'application/controllers/food.php';
        $controller = new Food();
        $controller->menu();
        break;

    case 'food-details':
        require 'application/controllers/food.php';
        $controller = new Food();
        $id = $_GET['id'] ?? null;
        if ($id) {
            $controller->details($id);
        } else {
            header("Location: " . SITEURL . "menu");
        }
        break;

    case 'search':
        require 'application/controllers/food.php';
        $controller = new Food();
        $controller->search();
        break;

    case 'login':
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->login();
        break;

    case 'register':
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->register();
        break;
        
    case 'logout':
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->logout();
        break;

    case 'check-auth':
        require 'application/controllers/auth.php';
        $controller = new Auth();
        $controller->check_auth();
        break;

    case 'order':
        require 'application/controllers/order.php';
        $controller = new Order();
        $controller->create();
        break;

    case 'admin/dashboard':
        require 'application/controllers/admin.php';
        $controller = new Admin();
        $controller->dashboard();
        break;

    default:
        http_response_code(404);
        require 'application/views/404.php';
        break;
}