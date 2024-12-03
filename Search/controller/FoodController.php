<?php
/**
 * @file FoodController.php
 * @brief Handles food-related business logic and communication between models and views.
 */

require_once 'models/FoodModel.php';

class FoodController {
    private $foodModel;

    public function __construct() {
        $this->foodModel = new FoodModel();
    }

    /**
     * Render the search view based on the search keyword.
     */
    public function searchFoods($search) {
        $result = $this->foodModel->searchFoods($search);
        include 'views/food_search_view.php';
    }

    /**
     * Render the food menu view with all active foods.
     */
    public function showFoodMenu() {
        $result = $this->foodModel->getAllActiveFoods();
        include 'views/food_menu_view.php';
    }
}

// Route based on request type
$controller = new FoodController();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $controller->searchFoods($_POST['search']);
} else {
    $controller->showFoodMenu();
}
?>
