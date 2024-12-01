<?php require_once __DIR__ . '/../templates/header.php'; ?>

<div class="container" style="width: 50%; margin: 0 auto; padding: 30px; border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); background-color: #d4edda;">
    <h2 class="form-title" style="text-align: center; color: #155724; font-family: Arial, sans-serif; margin-bottom: 20px; font-size: 35px; font-weight: bold; padding: 10px; border-radius: 5px;">Add Food Item</h2>

    <form action="add-food" method="POST" enctype="multipart/form-data" class="styled-form" style="font-family: Arial, sans-serif;">
        <!-- Food Title -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="title" style="display: block; margin-bottom: 5px; font-weight: bold; color: #155724;">Food Title</label>
            <input type="text" name="title" id="title" placeholder="Enter food title" required style="width: 100%; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; background-color: #f9f9f9;">
        </div>

        <!-- Food Description -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="description" style="display: block; margin-bottom: 5px; font-weight: bold; color: #155724;">Description</label>
            <textarea name="description" id="description" rows="4" placeholder="Enter food description" required style="width: 100%; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; background-color: #f9f9f9;"></textarea>
        </div>

        <!-- Food Price -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="price" style="display: block; margin-bottom: 5px; font-weight: bold; color: #155724;">Price</label>
            <input type="number" name="price" id="price" placeholder="Enter food price" required style="width: 100%; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; background-color: #f9f9f9;">
        </div>

        <!-- Food Image -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="image_name" style="display: block; margin-bottom: 5px; font-weight: bold; color: #155724;">Upload Image</label>
            <input type="file" name="image_name" id="image_name" required style="width: 100%; padding: 10px;">
        </div>

        <!-- Category ID -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="category_id" style="display: block; margin-bottom: 5px; font-weight: bold; color: #155724;">Category ID</label>
            <input type="number" name="category_id" id="category_id" placeholder="Enter category ID" required style="width: 100%; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; background-color: #f9f9f9;">
        </div>

        <!-- Featured -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="featured" style="display: block; margin-bottom: 5px; font-weight: bold; color: #155724;">Featured</label>
            <select name="featured" id="featured" style="width: 100%; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; background-color: #f9f9f9;">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <!-- Active -->
        <div class="form-group" style="margin-bottom: 15px;">
            <label for="active" style="display: block; margin-bottom: 5px; font-weight: bold; color: #155724;">Active</label>
            <select name="active" id="active" style="width: 100%; padding: 10px; border: 1px solid #c3e6cb; border-radius: 5px; background-color: #f9f9f9;">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="form-group" style="text-align: center;">
            <button type="submit" class="btn-submit" style="background-color: #28a745; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 20px;">Add Food</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
