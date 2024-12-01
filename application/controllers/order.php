<?php include('partials-front/menu.php'); ?>

<?php
// Check if food_id is set in the URL
if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];

    // SQL query to fetch food details
    $sql = "SELECT * FROM food WHERE id = $food_id";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    } else {
        // Redirect if no food is found
        header('location:' . SITEURL);
    }
} else {
    // Redirect if food_id is not set
    header('location:' . SITEURL);
}
?>

<section class="food-search">
    <div class="container">
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php
                    // Check if image is available
                    if ($image_name == "") {
                        echo "<div class='error'>Image not Available.</div>";
                    } else {
                    ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $image_name; ?>"
                            class="img-responsive img-curve">
                    <?php
                    }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">
                    <p class="food-price">Tk.<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">
                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Dhrubo, Homaira, Asif" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. ahmed.dhrubo@northsouth.edu" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <!-- Stripe payment form -->
                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_51NzgKAFTSKcvcvKsqaW00CM2ldnnjFH0MfMnT0smbYy65eGEz9rlvzDWRgWn2qYGgfoUDS5a1imEvEYjfYxu2rJP00D4Tmb4IB"
                    data-amount="<?php echo $price * 100; ?>"
                    data-name="Food Order"
                    data-description="Payment for Food Order"
                    data-image="https://example.com/logo.png"
                    data-locale="auto"
                    data-currency="usd">
                </script>
            </fieldset>
        </form>

        <?php
        // Check if Stripe token is received
        if (isset($_POST['stripeToken'])) {
            // Include Stripe PHP library
            require 'vendor/autoload.php';

            // Set your Stripe API key
            \Stripe\Stripe::setApiKey('sk_test_51NzgKAFTSKcvcvKsxAHPRWNG3Gtv0SVGXk3vyOftXRDMiS95uI6YwFNEgQJyuwa5wSzU8CvVRremEKMm3yZzYape001XT4xgDq');

            // Get the payment token submitted by the form
            $token = $_POST['stripeToken'];

            // Create a charge using the token
            try {
                $charge = \Stripe\Charge::create([
                    'amount' => $price * 100,  // Amount in cents (e.g., $10.00)
                    'currency' => 'usd',
                    'source' => $token,
                    'description' => 'Payment for Food Order',
                ]);

                // Payment successful, update database or perform other actions
                if ($charge->status === 'succeeded') {
                    // Insert order details into the database
                    $fullName = mysqli_real_escape_string($conn, $_POST['full-name']);
                    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
                    $email = mysqli_real_escape_string($conn, $_POST['email']);
                    $address = mysqli_real_escape_string($conn, $_POST['address']);
                    $foodName = mysqli_real_escape_string($conn, $_POST['food']);
                    $price = mysqli_real_escape_string($conn, $_POST['price']);
                    $quantity = mysqli_real_escape_string($conn, $_POST['qty']);

                    // SQL query to insert the order into the database
                    $insertOrderSQL = "INSERT INTO orders (customer_name, customer_contact, customer_email, customer_address, food, price, qty) 
                                        VALUES ('$fullName', '$contact', '$email', '$address', '$foodName', '$price', '$quantity')";

                    // Execute the SQL query
                    if (mysqli_query($conn, $insertOrderSQL)) {
                        // Order inserted successfully
                        echo "Payment successful. Your order has been placed!";
                    } else {
                        // Error inserting order
                        echo "Payment successful, but there was an issue storing the order in the database.";
                    }
                }
            } catch (\Stripe\Exception\CardException $e) {
                // Handle declined card
                echo "Payment failed: " . $e->getError()->message;
            }
        }
        ?>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>
