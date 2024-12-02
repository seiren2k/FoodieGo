<?php require_once __DIR__ . '/../templates/header.php'; ?>

<div class="container">
    <h2 class="form-title">Delete Food Item</h2>

    <form action="delete-food" method="POST" class="styled-form">
        <!-- Food ID Input -->
        <div class="form-group">
            <label for="id">Food ID</label>
            <input type="text" name="id" id="id" placeholder="Enter the food ID to delete" required>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
            <button type="submit" class="btn-submit btn-danger">Delete Food</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../templates/footer.php'; ?>
