<?php
/**
 * @file delete-food.php
 * @brief View for deleting a food item.
 * 
 * This file displays the form for deleting a food item by its ID. 
 * 
 */

require_once __DIR__ . '/../templates/header.php'; 
?>

<div class="container" style="width: 40%; margin: 0 auto; padding: 30px; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); background-color: #f8d7da;">
    <h2 class="form-title" style="text-align: center; color: #721c24; font-family: Arial, sans-serif; margin-bottom: 20px;">Delete Food Item</h2>

    <form action="delete-food" method="POST" class="styled-form" style="font-family: Arial, sans-serif;">
        <!-- Food ID Input -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="id" style="display: block; margin-bottom: 5px; font-weight: bold; color: #721c24;">Food ID</label>
            <input type="text" name="id" id="id" placeholder="Enter the food ID to delete" required style="width: 100%; padding: 10px; border: 1px solid #f5c6cb; border-radius: 5px; background-color: #f9ecef;">
        </div>

        <!-- Submit Button -->
        <div class="form-group" style="text-align: center;">
            <button type="submit" class="btn-submit btn-danger" style="background-color: #dc3545; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Delete Food</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
