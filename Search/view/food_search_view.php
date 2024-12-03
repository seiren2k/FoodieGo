<?php include('partials-front/menu.php'); ?>

<section class="food-search text-center">
    <div class="container">
        <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo htmlspecialchars($search); ?>"</a></h2>
    </div>
</section>

<?php include('views/food_menu_view.php'); ?>
