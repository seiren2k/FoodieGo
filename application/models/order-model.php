<?php
/**
 * OrderModel Class
 * 
 * Handles the database operations related to orders in the FoodieGo application.
 * 
 * PHP Version: 7.4 or higher
 * 
 * @category Models
 * @package  FoodieGo
 * @author   Pahela Chakma
 * @license  MIT License
 * @link     
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * OrderModel Class
 * 
 * This class provides functionality to manage orders, including inserting orders into
 * the database.
 */
class OrderModel {
    /**
     * @var mysqli $conn Database connection instance.
     */
    private $conn;
     /**
     * Constructor
     * 
     * Initializes the database connection.
     */
    public function __construct() {
        // Include database configuration
        require_once __DIR__ . '/../../system/database/DB_config.php';
        $dbInstance = Database::getInstance();
        $this->conn = $dbInstance->getConnection();
    }

   /**
     * Insert a new order into the database.
     *
     * @param array $data Associative array containing the order data:
     *                    - `food_name` (string): Name of the food item.
     *                    - `price` (float): Price per unit of the food item.
     *                    - `quantity` (int): Quantity of the food item ordered.
     *                    - `total_price` (float): Total price of the order.
     *                    - `customer_name` (string): Name of the customer.
     *                    - `contact` (string): Customer's contact number.
     *                    - `email` (string): Customer's email address.
     *                    - `address` (string): Delivery address.
     *                    - `status` (string): Current status of the order.
     * @return bool Returns true if the order was inserted successfully, false otherwise.
     */
    public function insertOrder($data) {
        
        $sql = "INSERT INTO `order` 
                (food, price, qty, total, customer_name, customer_contact, customer_email, customer_address, order_date, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Error preparing SQL statement: " . $this->conn->error);
            return false;
        }
        /**
         * Bind parameters to the SQL query:
         * - `food_name` (string): Name of the food item.
         * - `price` (float): Price per unit of the food item.
         * - `quantity` (int): Quantity of the food item ordered.
         * - `total_price` (float): Total price of the order.
         * - `customer_name` (string): Customer's name.
         * - `contact` (string): Customer's contact number.
         * - `email` (string): Customer's email address.
         * - `address` (string): Delivery address.
         * - `status` (string): Current status of the order.
         */
        
        $stmt->bind_param(
            "isidsssss",
            $data['food_name'],      
            $data['price'],          
            $data['quantity'],       
            $data['total_price'],    
            $data['customer_name'],  
            $data['contact'],        
            $data['email'],          
            $data['address'],        
            $data['status']          
        );

        $result = $stmt->execute();
        if (!$result) {
            error_log("Error executing SQL query: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }
}
