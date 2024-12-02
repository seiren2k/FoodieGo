<?php
defined('BASEPATH') or exit('No direct script access allowed');  // Ensures the file is not accessed directly
?>
<footer class="footer">
    <div class="footer-content">
        <!-- Footer section containing the main content of the footer -->

        <div class="footer-section">
            <h3>FoodieGo</h3>  <!-- Section title for FoodieGo -->
            <p>Delicious food delivered to your doorstep. Experience the best local cuisines with just a few clicks.</p>  <!-- Description of the service -->
        </div>
        
        <div class="footer-section">
            <h3>Quick Links</h3>  <!-- Section title for quick links -->
            <ul>
                <li><a href="<?php echo $siteurl; ?>">Home</a></li>  <!-- Link to the homepage -->
                <li><a href="<?php echo $siteurl; ?>menu">Menu</a></li>  <!-- Link to the menu page -->
                <li><a href="<?php echo $siteurl; ?>about">About</a></li>  <!-- Link to the about page -->
                <li><a href="<?php echo $siteurl; ?>contact">Contact</a></li>  <!-- Link to the contact page -->
            </ul>
        </div>
        
        <div class="footer-section">
            <h3>Contact Us</h3>  <!-- Section title for contact information -->
            <p>
                <i class="fa fa-phone"></i> +1 234 567 8900<br>  <!-- Contact phone number with icon -->
                <i class="fa fa-envelope"></i> info@foodiego.com<br>  <!-- Contact email with icon -->
                <i class="fa fa-map-marker"></i> 123 Food Street, Cuisine City  <!-- Address with icon -->
            </p>
        </div>
        
        <div class="footer-section">
            <h3>Follow Us</h3>  <!-- Section title for social media links -->
            <div class="social-links">
                <!-- Social media icons with links to respective pages -->
                <a href="#" class="social-link"><i class="fa fa-facebook"></i></a>  <!-- Facebook link -->
                <a href="#" class="social-link"><i class="fa fa-instagram"></i></a>  <!-- Instagram link -->
                <a href="#" class="social-link"><i class="fa fa-twitter"></i></a>  <!-- Twitter link -->
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <!-- Footer bottom section displaying copyright information -->
        <p>&copy; <?php echo date('Y'); ?> FoodieGo. All rights reserved.</p>  <!-- Dynamic year for copyright -->
    </div>
</footer>

<!-- Font Awesome for social media icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    .footer {
        background-color: #000000;  /* Dark background color for the footer */
        color: #FFFFFF;  /* White text color */
        padding: 40px 0 20px;  /* Padding for spacing */
        margin-top: 50px;  /* Space above the footer */
    }
    
    .footer-content {
        max-width: 1200px;  /* Max width for content */
        margin: 0 auto;  /* Center align the content */
        display: flex;  /* Flexbox layout */
        justify-content: space-between;  /* Distribute items evenly */
        flex-wrap: wrap;  /* Wrap items on smaller screens */
        padding: 0 20px;  /* Padding on sides */
    }
    
    .footer-section {
        flex: 1;  /* Distribute sections evenly */
        min-width: 250px;  /* Minimum width for each section */
        margin: 20px;  /* Space between sections */
    }
    
    .footer-section h3 {
        color: #FF0000;  /* Red color for section titles */
        margin-bottom: 20px;  /* Space below the section title */
        font-size: 1.2em;  /* Slightly larger font size */
    }
    
    .footer-section ul {
        list-style: none;  /* Remove default list styles */
        padding: 0;  /* Remove padding */
    }
    
    .footer-section ul li {
        margin-bottom: 10px;  /* Space between list items */
    }
    
    .footer-section a {
        color: #FFFFFF;  /* White color for links */
        text-decoration: none;  /* Remove underline */
        transition: color 0.3s ease;  /* Smooth transition effect on hover */
    }
    
    .footer-section a:hover {
        color: #FF0000;  /* Red color on hover */
    }
    
    .social-links {
        display: flex;  /* Flexbox for social media icons */
        gap: 15px;  /* Space between icons */
    }
    
    .social-link {
        display: inline-flex;  /* Align items in a row */
        align-items: center;  /* Vertically center icons */
        justify-content: center;  /* Horizontally center icons */
        width: 35px;  /* Set icon size */
        height: 35px;  /* Set icon size */
        border-radius: 50%;  /* Make icons circular */
        background-color: #FFFFFF;  /* White background for icons */
        color: #000000 !important;  /* Black color for icons */
        transition: all 0.3s ease;  /* Smooth transition on hover */
    }
    
    .social-link:hover {
        background-color: #FF0000;  /* Red background on hover */
        color: #FFFFFF !important;  /* White color for icons on hover */
        transform: translateY(-3px);  /* Lift the icon slightly on hover */
    }
    
    .footer-bottom {
        text-align: center;  /* Center align the footer bottom content */
        margin-top: 40px;  /* Space above the footer bottom */
        padding-top: 20px;  /* Padding on top */
        border-top: 1px solid rgba(255, 255, 255, 0.1);  /* Light top border */
    }
    
    @media (max-width: 768px) {
        .footer-section {
            min-width: 100%;  /* Make sections take full width on smaller screens */
            margin: 20px 0;  /* Vertical space between sections */
            text-align: center;  /* Center align the section content */
        }
        
        .social-links {
            justify-content: center;  /* Center align social icons */
        }
    }
</style>
</body>
</html>