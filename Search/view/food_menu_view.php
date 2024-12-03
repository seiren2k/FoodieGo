<?php include('partials-front/menu.php'); ?>

<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php if ($row['image_name'] == ""): ?>
                            <div class='error'>Image not available.</div>
                        <?php else: ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $row['image_name']; ?>" class="img-responsive img-curve">
                        <?php endif; ?>
                    </div>
                    <div class="food-menu-desc">
                        <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                        <p class="food-price">Tk. <?php echo htmlspecialchars($row['price']); ?></p>
                        <p class="food-detail"><?php echo htmlspecialchars($row['description']); ?></p>
                        <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $row['id']; ?>" class="btn btn-primary">Order Now</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class='error'>Food not found.</div>
        <?php endif; ?>

        <div class="clearfix"></div>
    </div>
</section>

<?php include('partials-front/footer.php'); ?>
