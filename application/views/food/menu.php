<?php
// Header section
require_once 'application/views/templates/header.php';
?>

<section class="food-search text-center">
    <div class="container">
        <!-- Food search form -->
        <form action="<?php echo $site_url; ?>food-search" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>

<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php if (!empty($food_items)): ?>
            <?php foreach ($food_items as $food_item): ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php if (empty($food_item['image_name'])): ?>
                            <div class="error">Image not available.</div>
                        <?php else: ?>
                            <img src="<?php echo $site_url; ?>images/food/<?php echo $food_item['image_name']; ?>" 
                                 class="img-responsive img-curve" 
                                 loading="lazy"
                                 alt="<?php echo htmlspecialchars($food_item['title']); ?>">
                        <?php endif; ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo htmlspecialchars($food_item['title']); ?></h4>
                        <p class="food-price">Tk. <?php echo htmlspecialchars($food_item['price']); ?></p>
                        <p class="food-detail">
                            <?php echo htmlspecialchars($food_item['description']); ?>
                        </p>
                        <br>
                        <a href="<?php echo $site_url; ?>order?food_id=<?php echo $food_item['id']; ?>" 
                           class="btn btn-primary">Order Now</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="error">Food not found.</div>
        <?php endif; ?>

        <div class="clearfix"></div>
    </div>
</section>

<?php
// Footer section
require_once 'application/views/templates/footer.php';
?>
