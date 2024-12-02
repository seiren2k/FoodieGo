<?php
// Include the header section template for the page
require_once 'application/views/templates/header.php';  
?>

<!--
  @file food_menu.php
  @brief This file contains the HTML structure for displaying a food search form and a food menu list with individual food items.
  It handles user interaction with the food menu and provides a search functionality.
-->

<section class="food-search text-center">
    <div class="container">
        <!-- Food search form allowing users to search for food items -->
        <form action="<?php echo $siteurl; ?>food-search" method="POST">
            <!-- Search input field for food -->
            <input type="search" name="search" placeholder="Search for Food.." required>  <!-- 'required' ensures this field must be filled out -->
            <!-- Submit button for the search -->
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>

<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>  <!-- Heading for the food menu section -->

        <!-- Check if there are food items to display -->
        <?php if (!empty($food_items)): ?>
            <!-- Loop through each food item -->
            <?php foreach ($food_items as $food): ?>
                <div class="food-menu-box">  <!-- Food menu item box -->
                    <div class="food-menu-img">
                        <!-- Check if there is no image for the food item -->
                        <?php if (empty($food['image_name'])): ?>
                            <div class='error'>Image not available.</div>  <!-- Show a placeholder message if no image -->
                        <?php else: ?>
                            <!-- Display the food image if available, with lazy loading for better performance -->
                            <img src="<?php echo $siteurl; ?>images/food/<?php echo $food['image_name']; ?>" 
                                 class="img-responsive img-curve" 
                                 loading="lazy"
                                 alt="<?php echo htmlspecialchars($food['title']); ?>">  <!-- Alt text for accessibility -->
                        <?php endif; ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo htmlspecialchars($food['title']); ?></h4>  <!-- Display food title -->
                        <p class="food-price">Tk.<?php echo htmlspecialchars($food['price']); ?></p>  <!-- Display food price -->
                        <p class="food-detail">
                            <?php echo htmlspecialchars($food['description']); ?>  <!-- Display food description -->
                        </p>
                        <br>
                        <!-- Link to the order page for this specific food item -->
                        <a href="<?php echo $siteurl; ?>order?food_id=<?php echo $food['id']; ?>" 
                           class="btn btn-primary">Order Now</a>  <!-- Button to order the food item -->
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>  <!-- If no food items are found -->
            <div class='error'>Food not found.</div>  <!-- Display a message if no food items are available -->
        <?php endif; ?>

        <div class="clearfix"></div>  <!-- Clears any floats in the layout -->
    </div>
</section>

<?php
// Include the footer section template for the page
require_once 'application/views/templates/footer.php';  
?>