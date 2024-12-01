<?php
include('config/constants.php');

// Check if the search query is set in the URL
if (isset($_GET['q'])) {
    $search = mysqli_real_escape_string($conn, $_GET['q']); // Sanitize the search input
    echo "Search Query: " . $search; // Debug output for search query

    // SQL query to search food items by title or description
    $sql = "SELECT * FROM food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

    // Execute the query
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if ($count > 0) {
        // Output the search results
        while ($row = mysqli_fetch_assoc($res)) {
            $id = $row['id'];
            $title = $row['title'];
            $price = $row['price'];
            $description = $row['description'];
            $image_name = $row['image_name'];

            // HTML structure for displaying the search results
            echo '<div class="food-menu-box">';
            echo '<div class="food-menu-img">';
            
            // Check if image is available
            if ($image_name == "") {
                echo "<div class='error'>Image not Available.</div>";
            } else {
                echo '<img src="' . SITEURL . 'images/food/' . $image_name . '" class="img-responsive img-curve">';
            }

            echo '</div>';
            echo '<div class="food-menu-desc">';
            echo '<h4>' . $title . '</h4>';
            echo '<p class="food-price">Tk. ' . $price . '</p>';
            echo '<p class="food-detail">' . $description . '</p>';
            echo '<br>';
            echo '<a href="#" class="btn btn-primary">Order Now</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        // No results found
        echo "<div class='error'>Food not found.</div>";
    }
}
?>
