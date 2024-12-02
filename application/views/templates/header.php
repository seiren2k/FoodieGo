<?php
// Ensure no direct access to the script
defined('BASEPATH') or exit('No direct script access allowed');

// Start a session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debugging: Log session data for troubleshooting purposes
error_log('Session data: ' . print_r($_SESSION, true));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Set character encoding to UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Set responsive viewport for mobile devices -->
    <title>FoodieGo - Restaurant Food Order</title> <!-- Page title -->
    <link rel="stylesheet" href="<?php echo SITEURL; ?>assets/css/style.css"> <!-- Link to the external CSS stylesheet -->
</head>
<body>
    <header class="navbar">  <!-- Start of the navigation bar -->
        <div class="container">  <!-- Container to center align content -->
            <div class="logo">
                <!-- Logo section with a link to the homepage -->
                <a href="<?php echo SITEURL; ?>" title="FoodieGo">FoodieGo</a>
            </div>

            <nav class="menu">  <!-- Navigation menu -->
                <ul>
                    <li><a href="<?php echo SITEURL; ?>">Home</a></li> <!-- Link to the homepage -->
                    <li><a href="<?php echo SITEURL; ?>menu">Menu</a></li> <!-- Link to the menu page -->
                    <li><a href="<?php echo SITEURL; ?>about">About</a></li> <!-- Link to the about page -->
                    <li><a href="<?php echo SITEURL; ?>contact">Contact</a></li> <!-- Link to the contact page -->
                    <li class="auth-buttons">
                        <?php
                        // Debugging: Log the session to check if the user is logged in
                        error_log('Checking session in header: ' . print_r($_SESSION, true));
                        
                        // Check if the user is logged in by verifying the session
                        if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) : ?>
                            <!-- Show Logout button if the user is logged in -->
                            <a href="<?php echo SITEURL; ?>logout" class="btn-auth">Logout</a>
                        <?php else : ?>
                            <!-- Show Login and Register buttons if the user is not logged in -->
                            <a href="<?php echo SITEURL; ?>login" class="btn-auth">Login</a>
                            <a href="<?php echo SITEURL; ?>register" class="btn-auth btn-auth-primary">Register</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>