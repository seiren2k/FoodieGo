<?php
/**
 * Order View
 * Displays the food order form.
 */

include('partials-front/menu.php');
?>

<section class="food-search">
    <div class="container">
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>
        <form action="../controllers/order-controller.php" method="POST" class="order">
            <!-- Food Details -->
            <fieldset>
                <legend>Selected Food</legend>
                <div class="food-menu-img">
                    <?php if ($image_name == ""): ?>
                        <div class='error'>Image not available.</div>
                    <?php else: ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                    <?php endif; ?>
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

            <!-- Customer Details -->
            <fieldset>
                <legend>Delivery Details</legend>
                <input type="text" name="full-name" placeholder="E.g. Dhrubo, Homaira" class="input-responsive" required>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>
                <input type="email" name="email" placeholder="E.g. email@domain.com" class="input-responsive" required>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>
                
                <!-- Stripe Payment Button -->
                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                    data-key="pk_test_your_public_key"
                    data-amount="<?php echo $price * 100; ?>"
                    data-name="Food Order"
                    data-description="Payment for Food Order"
                    data-image="https://example.com/logo.png"
                    data-locale="auto"
                    data-currency="usd">
                </script>
            </fieldset>
        </form>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>
