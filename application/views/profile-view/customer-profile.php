<?php
// Include header and database configuration
require_once 'application/views/templates/header.php';
require_once 'config/database.php';

// Start session and check if the user is logged in
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header('Location: login.php'); // Redirect if not logged in
    exit;
}

// Fetch user details for the logged-in customer
$user_id = $_SESSION['user_id'];

// Query to retrieve user information
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "<div class='error'>User not found.</div>";
    require_once 'application/views/templates/footer.php';
    exit;
}
?>

<section class="profile text-center">
    <div class="container">
        <h2>My Profile</h2>
        <!-- Profile Update Form -->
        <form action="update-profile.php" method="POST">
            <!-- Name Input -->
            <div class="profile-details">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" 
                       value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <!-- Email Input (Read-only) -->
            <div class="profile-details">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" 
                       value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
            </div>

            <!-- Phone Input -->
            <div class="profile-details">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" 
                       value="<?php echo htmlspecialchars($user['phone']); ?>">
            </div>

            <!-- Password Input -->
            <div class="profile-details">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" 
                       placeholder="Leave blank to keep current password">
            </div>

            <!-- Submit Button -->
            <div class="profile-action">
                <input type="submit" name="update_profile" 
                       value="Update Profile" class="btn btn-primary">
            </div>
        </form>
    </div>
</section>

<?php
// Include footer
require_once 'application/views/templates/footer.php';
?>