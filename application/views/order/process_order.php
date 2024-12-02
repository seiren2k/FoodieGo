<?php
/**
 * Order Processing Script
 * 
 * This script handles the processing of a food order. It validates input data, calculates 
 * the total price, and inserts the order details into the database. If the request method 
 * is invalid or required data is missing, it redirects or outputs an error message.
 * 
 * PHP Version: 7.4 or higher
 * 
 * @category Order_Processing
 * @package  FoodieGo
 * @author   Pahela Chakma
 * @license  MIT License
 * @link     
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/FoodieGo/system/database/DB_config.php';

// Get a database connection instance
$dbInstance = Database::getInstance();
$conn = $dbInstance->getConnection();
/**
 * Handle POST request to process the order.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and retrieve form input values
    $food_id = isset($_POST['food_id']) ? mysqli_real_escape_string($conn, $_POST['food_id']) : '';
    $food_name = isset($_POST['food']) ? mysqli_real_escape_string($conn, $_POST['food']) : '';
    $price = isset($_POST['price']) ? mysqli_real_escape_string($conn, $_POST['price']) : '';
    $quantity = isset($_POST['qty']) ? mysqli_real_escape_string($conn, $_POST['qty']) : '';
    $total_price = $price * $quantity; // Calculate total price
    $customer_name = isset($_POST['full_name']) ? mysqli_real_escape_string($conn, $_POST['full_name']) : '';
    $contact = isset($_POST['contact']) ? mysqli_real_escape_string($conn, $_POST['contact']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '';
    $address = isset($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : '';
    /**
     * Validate input fields to ensure all required fields are filled.
     */
    if (empty($food_id) || empty($food_name) || empty($price) || empty($quantity) || empty($customer_name) || empty($contact) || empty($email) || empty($address)) {
        echo "All fields are required!";
        exit();
    }
    /**
     * SQL query to insert order details into the `orders` table.
     * 
     * @var string $sql The SQL query for inserting the order.
     */

    $sql = "INSERT INTO orders (food_id, food_name, price, quantity, total_price, customer_name, contact, email, address, order_date, status) 
            VALUES ('$food_id', '$food_name', '$price', '$quantity', '$total_price', '$customer_name', '$contact', '$email', '$address', NOW(), 'Pending')";

    /**
     * Execute the query and handle the result.
     */
    if (mysqli_query($conn, $sql)) {
        echo "Order placed successfully!";
        // Redirect
        header('Location: ' . SITEURL . 'menu.php');
        exit();
    } else {
        // Log error if query execution fails
        echo "Error: " . mysqli_error($conn);
    }
} else {
    /**
     * Redirect to the homepage if the request method is not POST.
     */
    header('Location: ' . SITEURL);
    exit();
}
?>