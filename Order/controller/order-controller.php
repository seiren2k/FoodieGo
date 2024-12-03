<?php
/**
 * Order Controller
 * Handles order form submissions and Stripe payment processing.
 */

// Include necessary files
require_once('../models/order-model.php');
require_once('../vendor/autoload.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $full_name = mysqli_real_escape_string($conn, $_POST['full-name']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $food_name = mysqli_real_escape_string($conn, $_POST['food']);
    $price = (float)$_POST['price'];
    $quantity = (int)$_POST['qty'];

    // Process Stripe payment
    \Stripe\Stripe::setApiKey('sk_test_your_api_key');
    try {
        $charge = \Stripe\Charge::create([
            'amount' => $price * 100,
            'currency' => 'usd',
            'source' => $_POST['stripeToken'],
            'description' => 'Payment for Food Order',
        ]);

        if ($charge->status === 'succeeded') {
            // Insert order into the database
            if (insert_order($full_name, $contact, $email, $address, $food_name, $price, $quantity)) {
                echo "Payment successful. Your order has been placed!";
            } else {
                echo "Payment successful, but there was an issue storing the order.";
            }
        }
    } catch (\Stripe\Exception\CardException $e) {
        echo "Payment failed: " . $e->getError()->message;
    }
}
?>
