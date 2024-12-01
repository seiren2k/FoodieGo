<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(__DIR__ . '/../templates/header.php');
?>
<section class="auth-section">
    <div class="container">
        <h2 class="text-center">Register</h2>
        
        <?php if (!empty($error)) : ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)) : ?>
            <div class="success-msg"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form action="<?php echo SITEURL; ?>register" method="POST" class="form-container">
            <div class="form-group">
                <label for="name">Full Name*</label>
                <input type="text" name="name" id="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email*</label>
                <input type="email" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" id="phone">
            </div>

            <div class="form-group">
                <label for="password">Password*</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password*</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>

            <div class="form-group">
                <input type="submit" name="submit" value="Register" class="btn btn-primary">
            </div>

            <div class="form-footer">
                Already have an account? <a href="<?php echo SITEURL; ?>login">Login here</a>
            </div>
        </form>
    </div>
</section>

<?php include(__DIR__ . '/../templates/footer.php'); ?>