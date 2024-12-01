<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodieGo - Restaurant Food Order</title>
</head>
<body style="margin: 0; font-family: Arial, sans-serif;">

    <header class="navbar" style="background-color: #333; padding: 15px 0; color: #fff;">
        <div class="container" style="width: 90%; margin: 0 auto; display: flex; justify-content: space-between; align-items: center;">
            <!-- Logo -->
            <div class="logo" style="font-size: 35px; font-weight: bold;">
                <a href="<?php echo $siteurl; ?>" title="FoodieGo" style="color: #fff; text-decoration: none;">FoodieGo</a>
            </div>

            <!-- Navigation Menu -->
            <nav class="menu">
                <ul style="list-style: none; margin: 0; padding: 0; display: flex; gap: 15px;">
                    <li><a href="<?php echo $siteurl; ?>" style="color: #fff; text-decoration: none; padding: 10px 15px; transition: background-color 0.3s; font-weight: bold; font-size: 18px;">Home</a></li>
                    <li><a href="<?php echo $siteurl; ?>menu" style="color: #fff; text-decoration: none; padding: 10px 15px; transition: background-color 0.3s; font-weight: bold; font-size: 18px;">Menu</a></li>
                    <li><a href="<?php echo $siteurl; ?>about" style="color: #fff; text-decoration: none; padding: 10px 15px; transition: background-color 0.3s; font-weight: bold; font-size: 18px;">About</a></li>
                    <li><a href="<?php echo $siteurl; ?>contact" style="color: #fff; text-decoration: none; padding: 10px 15px; transition: background-color 0.3s; font-weight: bold; font-size: 18px;">Contact</a></li>

                </ul>
            </nav>
        </div>
    </header>

    <script>
        // Add hover effect for menu links
        document.querySelectorAll('.menu a').forEach(link => {
            link.addEventListener('mouseover', () => {
                link.style.backgroundColor = '#444';
                link.style.borderRadius = '5px';
            });
            link.addEventListener('mouseout', () => {
                link.style.backgroundColor = 'transparent';
            });
        });
    </script>
</body>
</html>
