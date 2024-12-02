<?php
defined('BASEPATH') or exit('No direct script access allowed');  // Prevent direct access to the script
include(__DIR__ . '/../templates/header.php');  // Include the header template
?>

<section class="auth-section">  <!-- Authentication section for login form -->
    <div class="container">
        <h2 class="text-center">Login</h2>  <!-- Heading for the login page -->
        
        <!-- Display success message if registration was successful -->
        <?php if (isset($_GET['registered']) && $_GET['registered'] == '1') : ?>
            <div class="success-msg">Registration successful! Please login with your credentials.</div>  <!-- Success message -->
        <?php endif; ?>
        
        <!-- Display error message if there's any error (e.g., invalid login) -->
        <?php if (!empty($error)) : ?>
            <div class="error-msg"><?php echo $error; ?></div>  <!-- Error message -->
        <?php endif; ?>

        <!-- Login form -->
        <form action="<?php echo SITEURL; ?>login" method="POST" class="form-container">  <!-- Form submission to login route -->
            <div class="form-group">  <!-- Form group for email input -->
                <label for="username">Email*</label>  <!-- Label for the email input -->
                <input type="email" name="username" id="username" required 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">  <!-- Input for email, with pre-filled value if available -->
            </div>

            <div class="form-group">  <!-- Form group for password input -->
                <label for="password">Password*</label>  <!-- Label for the password input -->
                <input type="password" name="password" id="password" required>  <!-- Input for password -->
            </div>

            <div class="form-group">  <!-- Form group for submit button -->
                <input type="submit" name="submit" value="Login" class="btn btn-primary">  <!-- Submit button for login -->
            </div>

            <!-- Footer with a link to the registration page if the user doesn't have an account -->
            <div class="form-footer">
                Don't have an account? <a href="<?php echo SITEURL; ?>register">Register here</a>  <!-- Registration link -->
            </div>
        </form>
    </div>
</section>

<?php include(__DIR__ . '/../templates/footer.php'); ?>  <!-- Include the footer template -->