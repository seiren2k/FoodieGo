<?php
/**
 * Order Model
 * Handles database operations for orders.
 */

// Database connection
require_once('config/database-config.php');

/**
 * Insert a new order into the database.
 *
 * @param string $full_name Customer's full name.
 * @param string $contact Customer's contact number.
 * @param string $email Customer's email address.
 * @param string $address Customer's delivery address.
 * @param string $food_name Ordered food name.
 * @param float $price Price of the food item.
 * @param int $quantity Quantity ordered.
 * @return bool True if the insertion is successful, false otherwise.
 */
function insert_order($full_name, $contact, $email, $address, $food_name, $price, $quantity) {
    global $conn;

    $sql = "INSERT INTO orders (customer_name, customer_contact, customer_email, customer_address, food, price, qty) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssd', $full_name, $contact, $email, $address, $food_name, $price, $quantity);
    
    return mysqli_stmt_execute($stmt);
}
?>

