<?php
// Include database configuration
require_once 'config/database.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header('Location: login.php');
    exit;
}

// Check if the form was submitted
if (isset($_POST['update_profile'])) {
    // Sanitize and retrieve form inputs
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Build the SQL query for updating user data
    $query = "UPDATE users SET name = ?, phone = ?";
    $params = [$name, $phone];
    $types = "ss"; // Data types: string, string

    // Check if password is provided
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT); // Encrypt password
        $query .= ", password = ?";
        $params[] = $password_hash;
        $types .= "s"; // Add another string data type
    }

    $query .= " WHERE id = ?";
    $params[] = $user_id;
    $types .= "i"; // Add integer data type

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();

    // Set success or error message based on query execution
    if ($stmt->affected_rows > 0) {
        $_SESSION['success'] = "Profile updated successfully.";
    } else {
        $_SESSION['error'] = "No changes were made.";
    }
    header('Location: customer-profile.php');
    exit;
} else {
    header('Location: customer-profile.php');
    exit;
}
?>