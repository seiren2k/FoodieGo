<?php require_once __DIR__ . '/../templates/header.php'; ?>

<div class="container" style="width: 50%; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); background-color: #f9f9f9;">
    <h2 class="form-title" style="text-align: center; color: #333; font-family: Arial, sans-serif; margin-bottom: 20px;">Add Food Item</h2>

    <form action="add-food" method="POST" enctype="multipart/form-data" class="styled-form" style="font-family: Arial, sans-serif;">
        <!-- Food Title -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="title" style="display: block; margin-bottom: 5px; font-weight: bold;">Food Title</label>
            <input type="text" name="title" id="title" placeholder="Enter food title" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <!-- Food Description -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="description" style="display: block; margin-bottom: 5px; font-weight: bold;">Description</label>
            <textarea name="description" id="description" rows="4" placeholder="Enter food description" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"></textarea>
        </div>

        <!-- Food Price -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="price" style="display: block; margin-bottom: 5px; font-weight: bold;">Price</label>
            <input type="number" name="price" id="price" placeholder="Enter food price" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <!-- Food Image -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="image_name" style="display: block; margin-bottom: 5px; font-weight: bold;">Upload Image</label>
            <input type="file" name="image_name" id="image_name" required style="width: 100%; padding: 10px;">
        </div>

        <!-- Category ID -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="category_id" style="display: block; margin-bottom: 5px; font-weight: bold;">Category ID</label>
            <input type="number" name="category_id" id="category_id" placeholder="Enter category ID" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <!-- Featured -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="featured" style="display: block; margin-bottom: 5px; font-weight: bold;">Featured</label>
            <select name="featured" id="featured" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <!-- Active -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="active" style="display: block; margin-bottom: 5px; font-weight: bold;">Active</label>
            <select name="active" id="active" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="form-group" style="text-align: center;">
            <button type="submit" class="btn-submit" style="background-color: #007BFF; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">Add Food</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
