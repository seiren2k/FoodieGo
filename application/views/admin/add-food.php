<?php require_once __DIR__ . '/../templates/header.php'; ?>

<div class="container">
    <h2 class="form-title">Add Food Item</h2>

    <form action="add-food" method="POST" enctype="multipart/form-data" class="styled-form">
        <!-- Food Title -->
        <div class="form-group">
            <label for="title">Food Title</label>
            <input type="text" name="title" id="title" placeholder="Enter food title" required>
        </div>

        <!-- Food Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4" placeholder="Enter food description" required></textarea>
        </div>

        <!-- Food Price -->
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" placeholder="Enter food price" required>
        </div>

        <!-- Food Image -->
        <div class="form-group">
            <label for="image_name">Upload Image</label>
            <input type="file" name="image_name" id="image_name" required>
        </div>

        <!-- Category ID -->
        <div class="form-group">
            <label for="category_id">Category ID</label>
            <input type="number" name="category_id" id="category_id" placeholder="Enter category ID" required>
        </div>

        <!-- Featured -->
        <div class="form-group">
            <label for="featured">Featured</label>
            <select name="featured" id="featured">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <!-- Active -->
        <div class="form-group">
            <label for="active">Active</label>
            <select name="active" id="active">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn-submit">Add Food</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
