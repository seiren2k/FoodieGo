<?php
defined('BASEPATH') or exit('No direct script access allowed');
include(__DIR__ . '/../templates/header.php');
?>

<section class="auth-section">
    <div class="container">
        <h2 class="text-center">Login</h2>
        
        <?php if (isset($_GET['registered']) && $_GET['registered'] == '1') : ?>
            <div class="success-msg">Registration successful! Please login with your credentials.</div>
        <?php endif; ?>
        
        <?php if (!empty($error)) : ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="<?php echo SITEURL; ?>login" method="POST" class="form-container">
            <div class="form-group">
                <label for="username">Email*</label>
                <input type="email" name="username" id="username" required 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="password">Password*</label>
                <input type="password" name="password" id="password" required>
            </div>

            <div class="form-group">
                <input type="submit" name="submit" value="Login" class="btn btn-primary">
            </div>

            <div class="form-footer">
                Don't have an account? <a href="<?php echo SITEURL; ?>register">Register here</a>
            </div>
        </form>
    </div>
</section>

<?php include(__DIR__ . '/../templates/footer.php'); ?>