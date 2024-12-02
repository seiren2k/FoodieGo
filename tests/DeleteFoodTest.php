<?php
/**
 * @file DeleteFoodTest.php
 * @brief Unit tests for the Delete Food functionality.
 *
 * This file contains test cases for the `delete_food` method in the `Admin_model` class,
 * validating both success and failure scenarios.
 */

// Mock Database Class
/**
 * @class Database
 * @brief Singleton class to manage the database connection.
 */
class Database
{
    private static $instance = null; /**< Singleton instance */
    private $connection; /**< Database connection */

    /**
     * @brief Constructor to establish a database connection.
     */
    public function __construct()
    {
        // Establish connection to the database
        $this->connection = new mysqli('localhost', 'root', '', 'foodiego');

        // Check for any connection errors
        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }

    /**
     * @brief Get the singleton instance of the Database.
     * @return Database Singleton instance.
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * @brief Get the active database connection.
     * @return mysqli Database connection.
     */
    public function getConnection()
    {
        return $this->connection;
    }
}

require_once __DIR__ . '/../application/models/admin-model.php';

/**
 * @class DeleteFoodTest
 * @brief Test class for the Delete Food functionality in `Admin_model`.
 */
class DeleteFoodTest
{
    private $admin_model; /**< Instance of Admin_model */

    /**
     * @brief Constructor to initialize the `Admin_model`.
     */
    public function __construct()
    {
        $this->admin_model = new Admin_model();
    }

    /**
     * @brief Test case for successfully deleting a food item.
     */
    public function testDeleteFoodSuccess()
    {
        $food_id = 10; // Use a valid food ID

        $result = $this->admin_model->delete_food($food_id);

        // Output the test result
        if ($result) {
            echo "testDeleteFoodSuccess PASSED\n";
        } else {
            echo "testDeleteFoodSuccess FAILED\n";
        }
    }

    /**
     * @brief Test case for failure when deleting a non-existent food item.
     */
    public function testDeleteFoodFailure()
    {
        $food_id = 9999; // Use an invalid food ID

        $result = $this->admin_model->delete_food($food_id);

        // Output the test result
        if (!$result) {
            echo "testDeleteFoodFailure PASSED\n";
        } else {
            echo "testDeleteFoodFailure FAILED\n";
        }
    }

    /**
     * @brief Run all test cases for the Delete Food functionality.
     */
    public function runTests()
    {
        $this->testDeleteFoodSuccess();
        $this->testDeleteFoodFailure();
    }
}

// Run the tests
/**
 * @brief Entry point for running the test cases.
 */
$test = new DeleteFoodTest();
$test->runTests();
