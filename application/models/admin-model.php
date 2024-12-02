<?php
if (!defined('BASEPATH')) define('BASEPATH', true);


class Admin_model {
    private $db;

    // Initialize database connection
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Add a new food item to the database.
    public function add_food($title, $description, $price, $image_name, $category_id, $featured, $active) {
        // Sanitize input data
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

    // Delete a food item from the database by ID.
    public function delete_food($id) {
        // Sanitize the input ID
        $id = mysqli_real_escape_string($this->db, $id);

        // Query to delete the food item from the database
        $query = "DELETE FROM food WHERE id = '$id'";
        return mysqli_query($this->db, $query);
    }
}
