<?php
/**
 * @file FoodModel.php
 * @brief Contains functions for food-related database operations.
 */

require_once 'config/database-config.php';

class FoodModel {
    /**
     * Fetch all active foods.
     * @return array Result set containing food records.
     */
    public function getAllActiveFoods() {
        global $conn;
        $sql = "SELECT * FROM food WHERE active = 'Yes'";
        return mysqli_query($conn, $sql);
    }

    /**
     * Search for foods based on a keyword.
     * @param string $search Keyword to search.
     * @return array Result set of matching foods.
     */
    public function searchFoods($search) {
        global $conn;
        $search = mysqli_real_escape_string($conn, $search);
        $sql = "SELECT * FROM food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
        return mysqli_query($conn, $sql);
    }
}
?>
