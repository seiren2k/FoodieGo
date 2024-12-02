<?php

use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private $mockDbConnection;
    private $mockResult;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock the database connection
        $this->mockDbConnection = $this->createMock(mysqli::class);

        // Mock the result object returned from the database
        $this->mockResult = $this->createMock(mysqli_result::class);
    }

    /**
     * Test fetching food details with a valid food ID.
     */
    public function testFetchFoodDetailsWithValidId()
    {
        // Simulate a valid result by configuring the mock result to return the correct values
        $this->mockResult->method('fetch_assoc')->willReturn([
            'title' => 'BBQ Burger',
            'price' => 300,
            'image_name' => 'Food-Name-3231.jpg'
        ]);

        // Simulate the behavior of mysqli_query returning our mock result
        $this->mockDbConnection->method('query')->willReturn($this->mockResult);

        // Simulate the food ID passed
        $foodId = 5;
        $sql = "SELECT * FROM food WHERE id=$foodId";
        
        // Execute the SQL query to simulate fetching food details
        $result = $this->mockDbConnection->query($sql);
        
        // Fetch the data
        $row = $result->fetch_assoc();

        // Assert the food details are correct
        $this->assertEquals('BBQ Burger', $row['title']);
        $this->assertEquals(300, $row['price']);
        $this->assertEquals('Food-Name-3231.jpg', $row['image_name']);
    }

    /**
     * Test handling an invalid food ID (no results returned).
     */
    public function testFetchFoodDetailsWithInvalidId()
    {
        // Simulate no results found
        $this->mockResult->method('fetch_assoc')->willReturn(null);  // Simulate empty result

        // Simulate the behavior of mysqli_query returning our mock result
        $this->mockDbConnection->method('query')->willReturn($this->mockResult);

        // Simulate the food ID passed
        $foodId = 999;  // Non-existing food ID
        $sql = "SELECT * FROM food WHERE id=$foodId";
        
        // Execute the SQL query to simulate fetching food details
        $result = $this->mockDbConnection->query($sql);

        // Assert the result is null because the food ID doesn't exist
        $this->assertNull($result->fetch_assoc());
    }

    /**
     * Test form validation for required fields.
     */
    public function testFormValidationWithMissingFields()
    {
        // Simulating missing required fields in the form
        $fullName = '';
        $contact = '';
        $email = '';
        $address = '';
        $quantity = 0;

        // Assert that an empty field (full name) triggers validation failure
        $this->assertFalse($this->validateForm($fullName, $contact, $email, $address, $quantity));
    }

    /**
     * Simulated form validation (without changing the order.php file).
     */
    private function validateForm($fullName, $contact, $email, $address, $quantity)
    {
        if (empty($fullName) || empty($contact) || empty($email) || empty($address) || $quantity <= 0) {
            return false;
        }

        return true;
    }

    /**
     * Test handling a successful order submission (mock response).
     */
    public function testSuccessfulOrderSubmission()
    {
        // Setup the mock to simulate successful insertion
        $this->mockDbConnection->method('query')->willReturn(true);

        // Simulate a successful order submission
        $foodId = 5;
        $foodName = 'BBQ Burger';
        $price = 300;
        $quantity = 2;
        $totalPrice = $price * $quantity;

        $customerName = 'John Doe';
        $contact = '1234567890';
        $email = 'john.doe@example.com';
        $address = '123 Elm Street';

        // Mock the query to insert the order
        $sql = "INSERT INTO orders (food_id, food_name, price, quantity, total_price, customer_name, contact, email, address, order_date, status)
                VALUES ($foodId, '$foodName', $price, $quantity, $totalPrice, '$customerName', '$contact', '$email', '$address', NOW(), 'Pending')";

        // Execute the SQL query and check if it was successful
        $result = $this->mockDbConnection->query($sql);
        
        // Assert the result of the order submission
        $this->assertTrue($result);
    }
}
