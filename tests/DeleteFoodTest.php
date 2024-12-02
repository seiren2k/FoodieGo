<?php

// Mock Database Class
class Database
{
    private static $instance = null;
    private $connection;

    public function __construct()
    {
        // Establish connection to the database
        $this->connection = new mysqli('localhost', 'root', '', 'foodiego');

        // Check for connection errors
        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }

    // Singleton pattern to get a single instance of the database connection
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Get the database connection
    public function getConnection()
    {
        return $this->connection;
    }
}

require_once __DIR__ . '/../application/models/admin-model.php';

// Test class for Delete Food functionality
class DeleteFoodTest
{
    private $admin_model;

    // Initialize the Admin_model
    public function __construct()
    {
        $this->admin_model = new Admin_model();
    }

    // Test case: Successful deletion of a food item
    public function testDeleteFoodSuccess()
    {
        $food_id = 10;  // Use a valid food ID

        $result = $this->admin_model->delete_food($food_id);

        // Output the test result
        if ($result) {
            echo "testDeleteFoodSuccess PASSED\n";
        } else {
            echo "testDeleteFoodSuccess FAILED\n";
        }
    }

    // Test case: Failure when trying to delete a non-existent food item
    public function testDeleteFoodFailure()
    {
        $food_id = 9999;  // Use an invalid food ID

        $result = $this->admin_model->delete_food($food_id);

        // Output the test result
        if (!$result) {
            echo "testDeleteFoodFailure PASSED\n";
        } else {
            echo "testDeleteFoodFailure FAILED\n";
        }
    }

    // Run all test cases
    public function runTests()
    {
        $this->testDeleteFoodSuccess();
        $this->testDeleteFoodFailure();
    }
}

// Run the tests
$test = new DeleteFoodTest();
$test->runTests();
