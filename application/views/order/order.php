
<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/FoodieGo/system/database/DB_config.php';

$dbInstance = Database::getInstance();
$conn = $dbInstance->getConnection();

if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];

    $sql = "SELECT * FROM food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);

    if ($count == 1) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    } else {
        header('location:' . SITEURL);
        exit();
    }
} else {
    header('location:' . SITEURL);
    exit();
}
?>

<section class="food-search">
    <div class="container">
        <form id="orderForm" method="POST" action="process_order.php" class="order" onsubmit="return validateForm()">
            <h2 class="text-center text-white">Fill this form to confirm your order!</h2>
            <div class="main-container">
                <fieldset class = "f1">
                        <legend>Selected Food</legend>

                        <div class="food-menu-img">
                            <?php if ($image_name == ""): ?>
                                <div class='error'>Image not Available.</div>
                            <?php else: ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" 
                                    alt="<?php echo $title; ?>" class="img-responsive img-curve" style="width: 100%; height: auto;">
                            <?php endif; ?>
                        </div>

                        <div class="food-menu-desc">
                            <h3><?php echo $title; ?></h3>
                            <input type="hidden" name="food_id" value="<?php echo $food_id; ?>">
                            <input type="hidden" name="food" value="<?php echo $title; ?>">
                            <p class="food-price">Tk.<?php echo $price; ?></p>
                            <input type="hidden" name="price" value="<?php echo $price; ?>">
                            <div class="order-label">Quantity</div>
                            <input type="number" name="qty" id="qty" class="input-responsive" value="1" required>
                        </div>
                    </fieldset>

                    <fieldset class = "f2">
                        <legend>Delivery Details</legend>
                        <div class="order-label">Full Name</div>
                        <input type="text" name="full_name" id="full_name" placeholder="Enter your full name" class="input-responsive" required>

                        <div class="order-label">Phone Number</div>
                        <input type="tel" name="contact" id="contact" placeholder="Enter a valid phone number" class="input-responsive" required>

                        <div class="order-label">Email</div>
                        <input type="email" name="email" id="email" placeholder="Enter a valid email address" class="input-responsive" required>

                        <div class="order-label">Address</div>
                        <textarea name="address" id="address" rows="5" placeholder="Enter full address" class="input-responsive" required></textarea>

                        <button type="button" class="btn btn-primary" onclick="openModal()">Order Now</button>
                    </fieldset>

        </div>

        </form>
    </div>
</section>

<!-- Modal -->
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Confirm Your Order</h2>
        <p>Are you sure you want to place this order?</p>
        <button class="btn btn-success" onclick="submitOrder()">Yes, Place Order</button>
        <button class="btn btn-danger" onclick="cancelOrder()">Cancel</button>
    </div>
</div>

<style>
    /* General body styling */
    body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-image: url(./application/img/wall.jpg);
    background-size: cover;
    background-position: center;
    position: relative;
    }
    body::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7); 
    z-index: -1;
    opacity: 0.7; 
    }
    ::placeholder{
        color: gray;
    }
    
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    
    }
    .container h2{
        color: white;
        text-align: center;
        font-size: 30px;
    }
    fieldset legend{
        color: white;
        font-size: 20px;
        font-weight: bold;
    }
    .main-container{
        display: flex;

    }
    .f1, .f2{
        flex: 1;
    }
    .btn-primary{
        background-color: #FF4655;
        color: white;
        padding: 15px 30px;
        transition: all 0.3s ease;
        
    }
    .btn-primary:hover{
        background-color: white;
        color: black;
    }
    
    form.order {
        width: 100%;
        max-width: 900px; 
        background-color: rgba(155, 155, 155, 0.48);
        backdrop-filter: blur(2px) saturate(151%);
        -webkit-backdrop-filter: blur(1px) saturate(151%);
        border: 1px solid rgba(209, 213, 219, 0.3);
        border-radius: 10px;
        padding: 20px;
    }

    
    fieldset {
        border: 2px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        color: white;
        font-size: 20px;
    }

    legend {
        font-size: 18px;
        font-weight: bold;
        padding: 0 10px;
        color: #333;
    }

    
    .order-label {
        margin-top: 10px;
        font-size: 16px;
        font-weight: bold;
    }

    
    .input-responsive {
        width: 100%;
        padding: 15px 10px;
        margin-top: 5px;
        margin-bottom: 10px;
        border-radius: 10px;
        border: 1px solid #ddd;
        box-sizing: border-box;
        background-color: #353b48;
        outline: none;
        color: white;
        font-size: 18px;
    }

    
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 30%;
        border-radius: 10px;
        text-align: center;
    }

    .close {
        float: right;
        font-size: 28px;
        cursor: pointer;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        margin: 10px;
    }

    .btn-success {
        background-color: green;
        color: white;
    }

    .btn-danger {
        background-color: red;
        color: white;
    }

    .btn {
        width: 100%;
        display: block;
        text-align: center;
        font-size: 16px;
        margin-top: 20px;
    }
</style>

<script>
    function openModal() {
        if (validateForm()) {
            document.getElementById('confirmationModal').style.display = 'block';
        }
    }

    
    function closeModal() {
        document.getElementById('confirmationModal').style.display = 'none';
    }


    function submitOrder() {
        document.getElementById('orderForm').submit();
    }

    
    function cancelOrder() {
        closeModal();
        alert('Your order has been canceled.');
        window.location.href = '<?php echo SITEURL; ?>'; 
    }

    
    function validateForm() {
        const fullName = document.getElementById('full_name').value.trim();
        const contact = document.getElementById('contact').value.trim();
        const email = document.getElementById('email').value.trim();
        const address = document.getElementById('address').value.trim();
        const quantity = document.getElementById('qty').value.trim();

        if (!fullName || !contact || !email || !address || !quantity || quantity <= 0) {
            alert("Please fill out the required information!");
            return false;
        }

        return true;
    }
</script>

<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/FoodieGo/application/views/templates/footer.php'; ?>
