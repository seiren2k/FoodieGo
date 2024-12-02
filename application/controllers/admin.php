<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin {
    private $db;
    private $food_model;
    
    // Load admin model
    public function __construct() {
        require_once __DIR__ . '/../models/admin-model.php';
        $this->food_model = new Admin_model();
    
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Existing functionality: Display menu
    public function menu() {
        // Fetch food items
        $sql = "SELECT f.*, c.title as category_name 
                FROM food f 
                LEFT JOIN category c ON f.category_id = c.id 
                WHERE f.active='Yes'";
        $result = mysqli_query($this->db, $sql);
    
        // Prepare data for the view
        $food_items = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $food_items[] = $row;
            }
        }
    
        // Check for session messages
        $message = $_SESSION['message'] ?? '';
        unset($_SESSION['message']); // Clear the message after displaying it
    
        // Load the view with data
        $data['food_items'] = $food_items;
        $data['siteurl'] = SITEURL;
        $data['message'] = $message;
        extract($data); // Makes variables available to the view
        require_once 'application/views/food/menu.php';
    }
    

    // Existing functionality: Display food details
    public function details($id) {
        $id = mysqli_real_escape_string($this->db, $id);
        $sql = "SELECT f.*, c.title as category_name 
                FROM food f 
                LEFT JOIN category c ON f.category_id = c.id 
                WHERE f.id='$id' AND f.active='Yes'";
        $result = mysqli_query($this->db, $sql);
        $food_item = mysqli_fetch_assoc($result);

        if (!$food_item) {
            header("Location: " . SITEURL . "404");
            exit;
        }

        $data['food_item'] = $food_item;
        $data['siteurl'] = SITEURL;
        extract($data); // This makes variables available to the view
        require_once 'application/views/food/details.php';
    }

    // New functionality: Add food item
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $image_name = $_FILES['image_name']['name'] ?? '';
            $category_id = $_POST['category_id'] ?? '';
            $featured = $_POST['featured'] ?? 'No';
            $active = $_POST['active'] ?? 'Yes';
    
            // Upload the image
            $upload_dir = __DIR__ . '/../../assets/images/food/';
            $upload_path = $upload_dir . basename($image_name);
            move_uploaded_file($_FILES['image_name']['tmp_name'], $upload_path);
    
            $result = $this->food_model->add_food($title, $description, $price, $image_name, $category_id, $featured, $active);
    
            if ($result) {
                header("Location: menu");
                exit();
            } else {
                $error = "Failed to add food item.";
            }
        }
    
        // Updated view location
        require_once __DIR__ . '/../views/admin/add-food.php';
    }
    

    // New functionality: Delete food item
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
    
            // Call the model to delete the food item
            $result = $this->food_model->delete_food($id);
    
            if ($result) {
                // Set a session variable for the success message
                $_SESSION['message'] = "Food item with ID $id deleted successfully!";
            } else {
                // Set a session variable for the error message
                $_SESSION['message'] = "Failed to delete food item with ID $id.";
            }
    
            // Redirect to the menu page
            header("Location: menu");
            exit();
        }
    
        // If accessed directly, redirect to the delete-food page
        require_once __DIR__ . '/../views/admin/delete-food.php';
    }
    
    
}
