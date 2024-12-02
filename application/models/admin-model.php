<?php
/**
 * @file admin-model.php
 * @brief Model for admin-related database operations.
 * 
 * This model handles all database interactions for food items, 
 * such as adding and deleting food items.
 */

if (!defined('BASEPATH')) define('BASEPATH', true);

/**
 * @class Admin_model
 * @brief Handles database operations related to admin functionalities as add a food item and delete a food item.
 */
class Admin_model {
    private $db;  /**< @var object $db Database connection instance */

    /**
     * Constructor to initialize the database connection.
     */
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Add a new food item to the database.
     * 
     * @param string $title The title of the food item.
     * @param string $description The description of the food item.
     * @param string $price The price of the food item.
     * @param string $image_name The name of the image file associated with the food item.
     * @param int $category_id The ID of the category the food item belongs to.
     * @param string $featured Whether the food item is featured (Yes/No).
     * @param string $active Whether the food item is active (Yes/No).
     * @return bool True on success, false on failure.
     */
    public function add_food($title, $description, $price, $image_name, $category_id, $featured, $active) {
        
        $title = mysqli_real_escape_string($this->db, $title);
        $description = mysqli_real_escape_string($this->db, $description);
        $price = mysqli_real_escape_string($this->db, $price);
        $image_name = mysqli_real_escape_string($this->db, $image_name);
        $category_id = mysqli_real_escape_string($this->db, $category_id);
        $featured = mysqli_real_escape_string($this->db, $featured);
        $active = mysqli_real_escape_string($this->db, $active);

        // Query to insert the food item into the database
        $query = "INSERT INTO food (title, description, price, image_name, category_id, featured, active) 
                  VALUES ('$title', '$description', '$price', '$image_name', '$category_id', '$featured', '$active')";
        return mysqli_query($this->db, $query);
    }

    /**
     * Delete a food item from the database by ID.
     * 
     * @param int $id The ID of the food item to delete.
     * @return bool True on success, false on failure.
     */
    public function delete_food($id) {
        
        $id = mysqli_real_escape_string($this->db, $id);

        // Query to delete the food item from the database
        $query = "DELETE FROM food WHERE id = '$id'";
        return mysqli_query($this->db, $query);
    }
}
