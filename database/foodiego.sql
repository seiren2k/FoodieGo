-- Setting SQL mode and transaction configuration
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";  -- Disables automatic handling of zero values for auto-incremented fields.
SET AUTOCOMMIT = 0;  -- Disables autocommit mode, ensuring that transactions are explicitly committed.
START TRANSACTION;  -- Begins a new transaction.
SET time_zone = "+00:00";  -- Sets the timezone for the current session to UTC (Coordinated Universal Time).

-- --------------------------------------------------------

-- Table structure for the 'users' table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,  -- Unique user ID, auto-incremented.
    name VARCHAR(100) NOT NULL,  -- User's name, cannot be NULL.
    email VARCHAR(100) NOT NULL UNIQUE,  -- User's email, must be unique.
    password VARCHAR(255) NOT NULL,  -- User's password, cannot be NULL.
    phone VARCHAR(20),  -- User's phone number (optional).
    role ENUM('admin', 'customer') DEFAULT 'customer',  -- User's role (default is 'customer').
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Timestamp when the user was created.
    UNIQUE KEY unique_email (email)  -- Unique constraint on the email field.
);

-- --------------------------------------------------------

-- Table structure for the 'admin' table
CREATE TABLE `admin` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,  -- Admin ID, auto-incremented.
  `username` VARCHAR(100) NOT NULL,  -- Admin username, cannot be NULL.
  `password` VARCHAR(255) NOT NULL,  -- Admin password, cannot be NULL.
  PRIMARY KEY (`id`)  -- Primary key on the 'id' field.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping sample data for the 'admin' table
INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(9, 'foodiego', '12345678');

-- --------------------------------------------------------

-- Table structure for the 'category' table
CREATE TABLE `category` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,  -- Category ID, auto-incremented.
  `title` VARCHAR(100) NOT NULL,  -- Name of the category (e.g., Burger, Pizza).
  `image_name` VARCHAR(255) NOT NULL,  -- Image associated with the category.
  `featured` ENUM('Yes', 'No') NOT NULL DEFAULT 'No',  -- Indicates if the category is featured.
  `active` ENUM('Yes', 'No') NOT NULL DEFAULT 'Yes',  -- Indicates if the category is active.
  PRIMARY KEY (`id`)  -- Primary key on the 'id' field.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping sample data for the 'category' table
INSERT INTO `category` (`id`, `title`, `image_name`, `featured`, `active`) VALUES
(4, 'Burger', 'Food_Category_482.jpeg', 'Yes', 'Yes'),
(5, 'Pizza', 'Food_Category_584.jpg', 'Yes', 'Yes'),
(6, 'Stir Fry', 'Food_Category_211.jpg', 'Yes', 'Yes'),
(7, 'Steak', 'Food_Category_5.jpg', 'Yes', 'Yes'),
(8, 'Pasta', 'Food_Category_952.jpg', 'Yes', 'Yes'),
(9, 'Sandwich', 'Food_Category_634.jpg', 'Yes', 'Yes');

-- --------------------------------------------------------

-- Table structure for the 'food' table
CREATE TABLE `food` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,  -- Food item ID, auto-incremented.
  `title` VARCHAR(100) NOT NULL,  -- Name of the food item (e.g., BBQ Burger).
  `description` TEXT NOT NULL,  -- Detailed description of the food item.
  `price` DECIMAL(10, 0) NOT NULL,  -- Price of the food item.
  `image_name` VARCHAR(255) NOT NULL,  -- Image associated with the food item.
  `category_id` INT(10) UNSIGNED NOT NULL,  -- Foreign key referencing the 'category' table.
  `featured` ENUM('Yes', 'No') NOT NULL DEFAULT 'No',  -- Indicates if the food item is featured.
  `active` ENUM('Yes', 'No') NOT NULL DEFAULT 'Yes',  -- Indicates if the food item is active.
  PRIMARY KEY (`id`),  -- Primary key on the 'id' field.
  FOREIGN KEY (`category_id`) REFERENCES `category`(`id`) ON DELETE CASCADE  -- Foreign key constraint on `category_id`.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping sample data for the 'food' table
INSERT INTO `food` (`id`, `title`, `description`, `price`, `image_name`, `category_id`, `featured`, `active`) VALUES
(5, 'BBQ Burger', 'BBQ Chicken, vegetable', 300, 'Food-Name-3231.jpg', 4, 'Yes', 'Yes'),
(6, 'Double Layer Vegetable Burger', 'Lettuce, Tomato, Potato patty', 150, 'Food-Name-6989.jpg', 4, 'Yes', 'Yes'),
(7, 'Jumbo Burger', 'Two chicken patties with vegetables', 400, 'Food-Name-5444.jpg', 4, 'Yes', 'Yes'),
(8, 'Lamb Burger', 'Lamb meat burger', 350, 'Food-Name-3324.jpg', 4, 'Yes', 'Yes'),
(9, 'Crispy Burger', 'Crispy chicken patty burger', 200, 'Food-Name-6173.jpg', 4, 'Yes', 'Yes'),
(10, 'Beef Burger', 'Beef meat burger', 300, 'Food-Name-9807.jpg', 4, 'Yes', 'Yes'),
(11, 'White Pasta', 'Made with White sauce', 250, 'Food-Name-3654.jpg', 8, 'Yes', 'Yes'),
(12, 'Spicy Pasta', 'Hot chili tomato sauce pasta', 200, 'Food-Name-2720.jpg', 8, 'Yes', 'Yes'),
(13, 'Sea Food Pasta', 'Seafood pasta', 400, 'Food-Name-2361.jpg', 8, 'Yes', 'Yes'),
(14, 'Beans Pasta', 'Pasta mixed with beans', 250, 'Food-Name-7868.jpg', 8, 'Yes', 'Yes'),
(15, 'Totalini Pasta', 'Chicken-filled pasta', 300, 'Food-Name-4776.jpg', 8, 'Yes', 'Yes'),
(16, 'Cheese Pasta', 'Cheese pasta', 220, 'Food-Name-7863.jpg', 8, 'Yes', 'Yes'),
(17, 'Vegetable Pasta', 'Made with various vegetables', 250, 'Food-Name-2327.jpg', 8, 'Yes', 'Yes'),
(18, 'Vegetable Stir Fry', 'Stir-fry with vegetables', 200, 'Food-Name-9821.jpg', 6, 'Yes', 'Yes'),
(19, 'Mushroom Stir Fry', 'Stir-fry with mushrooms', 250, 'Food-Name-2757.jpg', 6, 'Yes', 'Yes'),
(20, 'Chicken Stir Fry', 'Chicken and vegetable stir-fry', 250, 'Food-Name-9089.jpg', 6, 'Yes', 'Yes'),
(21, 'Beef Stir Fry', 'Beef stir-fry with a bit of vegetable', 350, 'Food-Name-4832.jpg', 6, 'Yes', 'Yes'),
(22, 'Korean Stir Fry', 'Korean-style stir-fry', 200, 'Food-Name-6934.jpg', 6, 'Yes', 'Yes'),
(23, 'Cheese Pizza', 'Cheese pizza', 400, 'Food-Name-1748.jpg', 5, 'Yes', 'Yes'),
(24, 'Pepperoni Pizza', 'Pizza topped with pepperoni', 500, 'Food-Name-8281.jpg', 5, 'Yes', 'Yes'),
(26, 'Sea Food Pizza', 'Seafood pizza', 600, 'Food-Name-6074.jpg', 5, 'Yes', 'Yes'),
(27, 'Italian Cheese Pizza', 'Pizza with Italian white cheese', 550, 'Food-Name-2957.jpg', 5, 'Yes', 'Yes'),
(28, 'Rib Eye Steak', 'Steak made with Rib Eye cut', 400, 'Food-Name-3263.jpg', 7, 'Yes', 'Yes'),
(29, 'Council Oak Steak', 'Fatty steak', 550, 'Food-Name-9028.jpg', 7, 'Yes', 'Yes'),
(30, 'Steak With Mushroom', 'Steak with mushrooms', 450, 'Food-Name-2538.jpg', 7, 'Yes', 'Yes');

-- --------------------------------------------------------

-- Table structure for the 'order' table
CREATE TABLE `order` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,  -- Order ID, auto-incremented.
  `food` VARCHAR(150) NOT NULL,  -- List of food items in the order.
  `price` DECIMAL(10, 0) NOT NULL,  -- Price of the food items.
  `qty` INT(11) NOT NULL,  -- Quantity of food items ordered.
  `total` DECIMAL(10, 0) NOT NULL,  -- Total price of the order.
  `order_date` DATETIME NOT NULL,  -- Date and time the order was placed.
  `status` VARCHAR(50) NOT NULL,  -- Current status of the order (e.g., 'Pending', 'Completed').
  `customer_name` VARCHAR(150) NOT NULL,  -- Name of the customer.
  `customer_contact` VARCHAR(20) NOT NULL,  -- Customer's contact number.
  `customer_email` VARCHAR(150) NOT NULL,  -- Customer's email address.
  `customer_address` VARCHAR(255) NOT NULL,  -- Customer's delivery address.
  PRIMARY KEY (`id`)  -- Primary key on the 'id' field.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping sample data for the 'order' table
INSERT INTO `order` (`id`, `food`, `price`, `qty`, `total`, `order_date`, `status`, `customer_name`, `customer_contact`, `customer_email`, `customer_address`) VALUES
(1, 'BBQ Burger', 300, 2, 600, '2023-10-30 14:30:00', 'Pending', 'John Doe', '1234567890', 'john.doe@example.com', '123 Elm Street, NY'),
(2, 'Cheese Pizza', 400, 1, 400, '2023-10-30 14:45:00', 'Completed', 'Jane Smith', '0987654321', 'jane.smith@example.com', '456 Oak Avenue, NY');

-- --------------------------------------------------------

-- Indexes for dumped tables
-- Indexes for table `admin` are already set by the PRIMARY KEY.
-- Indexes for table `category` are already set by the PRIMARY KEY.
-- Indexes for table `food` are already set by the PRIMARY KEY.
-- Indexes for table `order` are already set by the PRIMARY KEY.

-- --------------------------------------------------------

-- AUTO_INCREMENT settings for dumped tables
-- Setting AUTO_INCREMENT value for table 'admin'
ALTER TABLE `admin` MODIFY `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

-- Setting AUTO_INCREMENT value for table 'category'
ALTER TABLE `category` MODIFY `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

-- Setting AUTO_INCREMENT value for table 'food'
ALTER TABLE `food` MODIFY `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

-- Setting AUTO_INCREMENT value for table 'order'
ALTER TABLE `order` MODIFY `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

-- Committing the transaction
COMMIT; -- Commits the transaction, saving all changes to the database.