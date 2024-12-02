<?php
defined('BASEPATH') or exit('No direct script access allowed');  // Prevent direct access to the script
include(__DIR__ . '/../templates/header.php');  // Include the header template for the page
?>

<section class="auth-section">  <!-- Authentication section for the user registration form -->
    <div class="container">
        <h2 class="text-center">Register</h2>  <!-- Heading for the registration page -->
        
        <!-- Display error message if there's any error (e.g., invalid form submission or registration issue) -->
        <?php if (!empty($error)) : ?>
            <div class="error-msg"><?php echo $error; ?></div>  <!-- Show error message -->
        <?php endif; ?>
        
        <!-- Display success message if registration is successful -->
        <?php if (!empty($success)) : ?>
            <div class="success-msg"><?php echo $success; ?></div>  <!-- Show success message -->
        <?php endif; ?>
        
        <!-- Registration form -->
        <form action="<?php echo SITEURL; ?>register" method="POST" class="form-container">  <!-- Form submission to the register route -->
            <div class="form-group">  <!-- Form group for the full name input -->
                <label for="name">Full Name*</label>  <!-- Label for the full name input -->
                <input type="text" name="name" id="name" required>  <!-- Input for the user's full name -->
            </div>

            <div class="form-group">  <!-- Form group for the email input -->
                <label for="email">Email*</label>  <!-- Label for the email input -->
                <input type="email" name="email" id="email" required>  <!-- Input for the user's email -->
            </div>

            <div class="form-group">  <!-- Form group for the phone number input -->
                <label for="phone">Phone Number</label>  <!-- Label for the phone input -->
                <input type="tel" name="phone" id="phone">  <!-- Input for the user's phone number (optional) -->
            </div>

            <div class="form-group">  <!-- Form group for the password input -->
                <label for="password">Password*</label>  <!-- Label for the password input -->
                <input type="password" name="password" id="password" required>  <!-- Input for the password -->
            </div>

            <div class="form-group">  <!-- Form group for confirming the password -->
                <label for="confirm_password">Confirm Password*</label>  <!-- Label for the confirm password input -->
                <input type="password" name="confirm_password" id="confirm_password" required>  <!-- Input for confirming the password -->
            </div>

            <div class="form-group">  <!-- Form group for the submit button -->
                <input type="submit" name="submit" value="Register" class="btn btn-primary">  <!-- Submit button to register -->
            </div>

            <!-- Footer with a link to the login page if the user already has an account -->
            <div class="form-footer">
                Already have an account? <a href="<?php echo SITEURL; ?>login">Login here</a>  <!-- Link to the login page -->
            </div>
        </form>
    </div>
</section>

<?php include(__DIR__ . '/../templates/footer.php'); ?>  <!-- Include the footer template for the page -->