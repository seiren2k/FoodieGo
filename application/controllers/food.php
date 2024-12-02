<?php
defined('BASEPATH') or exit('No direct script access allowed');  // Prevent direct script access

/**
 * @file food.php
 * @brief This file contains the `Food` class which manages the display of food menu and food item details.
 * 
 * The `Food` class retrieves food items from the database and displays them on the menu page. It also handles
 * the display of individual food item details. The class interacts with the database to fetch active food items
 * and their categories.
 */

/**
 * @class Food
 * @brief Class responsible for handling food items, including displaying the food menu and food item details.
 * 
 * The `Food` class interacts with the database to retrieve food items that are marked as active. It provides methods
 * for displaying a list of active food items on the menu page and showing detailed information about a specific food item.
 */
class Food {
    /**
     * @var $db
     * @brief Holds the database connection instance.
     * 
     * This variable stores the connection resource obtained from the singleton `Database` class instance.
     */
    private $db;

    /**
     * @brief Constructor that initializes the `Food` class and gets the database connection.
     * 
     * The constructor retrieves the single instance of the `Database` class using the Singleton pattern,
     * and stores the connection in the `$db` variable for future database queries.
     */
    public function __construct() {
        // Get database connection using singleton pattern
        $database = Database::getInstance();  /**< @brief Get the single instance of the Database class */
        $this->db = $database->getConnection();  /**< @brief Store the database connection in $db */
    }

    /**
     * @brief Displays the menu with active food items.
     * 
     * This method queries the database to fetch food items that are marked as active, and organizes them
     * along with their associated category information. The retrieved data is then passed to the view for display.
     * 
     * @return void
     */
    public function menu() {
        // Database query for active food items
        $sql = "SELECT f.*, c.title as category_name 
                FROM food f 
                LEFT JOIN category c ON f.category_id = c.id 
                WHERE f.active = 'Yes'";  /**< @brief SQL query to fetch active food items */
        $result = mysqli_query($this->db, $sql);  /**< @brief Execute the SQL query */

        // Prepare data for the view
        $food_items = [];  /**< @brief Initialize an array to hold the food items */
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {  /**< @brief Fetch each row of the result */
                $food_items[] = $row;  /**< @brief Add the food item to the array */
            }
        }

        // Load the view with data
        $data['food_items'] = $food_items;  /**< @brief Pass food items to the view */
        $data['siteurl'] = SITEURL;  /**< @brief Pass the site URL to the view */
        extract($data);  /**< @brief Make variables available to the view */
        require_once 'application/views/food/menu.php';  /**< @brief Include the menu view */
    }

    /**
     * @brief Displays the details of a specific food item.
     * 
     * This method queries the database to fetch details of a specific food item based on the provided ID.
     * If the food item is found and marked as active, its details are passed to the view. If the item is not found,
     * the user is redirected to a 404 page.
     * 
     * @param int $id The ID of the food item to fetch.
     * 
     * @return void
     */
    public function details($id) {
        $id = mysqli_real_escape_string($this->db, $id);  /**< @brief Sanitize the input to prevent SQL injection */
        $sql = "SELECT f.*, c.title as category_name 
                FROM food f 
                LEFT JOIN category c ON f.category_id = c.id 
                WHERE f.id = '$id' AND f.active = 'Yes'";  /**< @brief SQL query to fetch a specific food item */
        $result = mysqli_query($this->db, $sql);  /**< @brief Execute the SQL query */
        $food_item = mysqli_fetch_assoc($result);  /**< @brief Fetch the food item details */

        // Redirect if no food item is found
        if (!$food_item) {
            header("Location: " . SITEURL . "404");  /**< @brief Redirect to 404 page if food item doesn't exist */
            exit;
        }

        // Load the view with food item data
        $data['food_item'] = $food_item;  /**< @brief Pass food item details to the view */
        $data['siteurl'] = SITEURL;  /**< @brief Pass the site URL to the view */
        extract($data);  /**< @brief Make variables available to the view */
        require_once 'application/views/food/details.php';  /**< @brief Include the details view */
    }
}
?>