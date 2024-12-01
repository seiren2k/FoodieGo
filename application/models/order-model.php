<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrderModel {
    private $conn;

    public function __construct() {
        // Include database configuration
        require_once __DIR__ . '/../../system/database/DB_config.php';
        $dbInstance = Database::getInstance();
        $this->conn = $dbInstance->getConnection();
    }

    /**
     * Insert a new order into the database.
     *
     * @param array $data Order data to be inserted.
     * @return bool True if the order was inserted successfully, false otherwise.
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
