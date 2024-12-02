<?php include('templates/header.php'); // Include the header template ?>

<div class="container">
    <div class="error-404">
        <h1>404 - Page Not Found</h1> <!-- Display the main error message -->
        <p>The page you are looking for does not exist.</p> <!-- Provide a brief explanation of the error -->
        <a href="<?php echo $config['base_url']; ?>" class="btn-primary">Go to Home</a> <!-- Link to the homepage for user navigation -->
    </div>
</div>

<?php include('templates/footer.php'); // Include the footer template ?>