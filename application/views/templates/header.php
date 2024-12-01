<?php
defined('BASEPATH') or exit('No direct script access allowed');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Debug session
error_log('Session data: ' . print_r($_SESSION, true));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieGo - Restaurant Food Order</title>
    <link rel="stylesheet" href="<?php echo SITEURL; ?>assets/css/style.css">
</head>
<body>
    <header class="navbar">
        <div class="container">
            <div class="logo">
                <a href="<?php echo SITEURL; ?>" title="FoodieGo">FoodieGo</a>
            </div>

            <nav class="menu">
                <ul>
                    <li><a href="<?php echo SITEURL; ?>">Home</a></li>
                    <li><a href="<?php echo SITEURL; ?>menu">Menu</a></li>
                    <li><a href="<?php echo SITEURL; ?>about">About</a></li>
                    <li><a href="<?php echo SITEURL; ?>contact">Contact</a></li>
                    <li class="auth-buttons">
                    <?php
                    error_log('Checking session in header: ' . print_r($_SESSION, true));
                    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) : ?>
                        <a href="<?php echo SITEURL; ?>logout" class="btn-auth">Logout</a>
                    <?php else : ?>
                        <a href="<?php echo SITEURL; ?>login" class="btn-auth">Login</a>
                        <a href="<?php echo SITEURL; ?>register" class="btn-auth btn-auth-primary">Register</a>
                    <?php endif; ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>