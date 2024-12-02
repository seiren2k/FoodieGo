<?php
defined('BASEPATH') or exit('No direct script access allowed');  // Prevent direct script access

class Food {
    private $db;  // Holds the database connection instance
    
    // Constructor - Initializes the Food class and gets the database connection
    public function __construct() {
        // Get database connection using singleton pattern
        $database = Database::getInstance();  // Get the single instance of the Database class
        $this->db = $database->getConnection();  // Store the database connection in $db
    }
    
    // Displays the menu with active food items
    public function menu() {
        // Database query for active food items
        $sql = "SELECT f.*, c.title as category_name 
                FROM food f 
                LEFT JOIN category c ON f.category_id = c.id 
                WHERE f.active = 'Yes'";  // Get food items that are marked as active
        $result = mysqli_query($this->db, $sql);  // Execute the SQL query
        
        // Prepare data for the view
        $food_items = [];  // Initialize an array to hold the food items
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {  // Fetch each row of the result
                $food_items[] = $row;  // Add the food item to the array
            }
        }
        
        // Load the view with data
        $data['food_items'] = $food_items;  // Pass food items to the view
        $data['siteurl'] = SITEURL;  // Pass the site URL to the view
        extract($data);  // Make variables available to the view
        require_once 'application/views/food/menu.php';  // Include the menu view
    }
    
    // Displays the details of a specific food item
    public function details($id) {
        $id = mysqli_real_escape_string($this->db, $id);  // Sanitize the input to prevent SQL injection
        $sql = "SELECT f.*, c.title as category_name 
                FROM food f 
                LEFT JOIN category c ON f.category_id = c.id 
                WHERE f.id = '$id' AND f.active = 'Yes'";  // Query to fetch a specific food item
        $result = mysqli_query($this->db, $sql);  // Execute the SQL query
        $food_item = mysqli_fetch_assoc($result);  // Fetch the food item details
        
        // Redirect if no food item is found
        if (!$food_item) {
            header("Location: " . SITEURL . "404");  // Redirect to 404 page if food item doesn't exist
            exit;
        }
        
        // Load the view with food item data
        $data['food_item'] = $food_item;  // Pass food item details to the view
        $data['siteurl'] = SITEURL;  // Pass the site URL to the view
        extract($data);  // Make variables available to the view
        require_once 'application/views/food/details.php';  // Include the details view
    }
}
?>