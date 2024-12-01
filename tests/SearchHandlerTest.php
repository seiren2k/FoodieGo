<?php

use PHPUnit\Framework\TestCase;

class SearchHandlerTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        // Create a mock for the MySQLi connection
        $this->conn = $this->createMock(mysqli::class);
    }

    public function testSearchResultsFound()
    {
        // Simulate search query
        $_GET['q'] = 'Pizza';
        $search = 'Pizza';

        // Mock result set with one record
        $result = $this->createMock(mysqli_result::class);
        $result->method('num_rows')
               ->willReturn(1);

        $result->method('fetch_assoc')
               ->willReturn([
                   'id' => 1,
                   'title' => 'Pizza',
                   'price' => 200,
                   'description' => 'Delicious cheese pizza',
                   'image_name' => 'pizza.jpg'
               ]);

        // Mock the query method
        $this->conn->expects($this->once())
                   ->method('query')
                   ->with($this->stringContains($search))
                   ->willReturn($result);

        // Capture output for validation
        ob_start();
        include 'path/to/your/search/file.php'; // Replace with your file path
        $output = ob_get_clean();

        // Check if the output contains expected elements
        $this->assertStringContainsString('Pizza', $output);
        $this->assertStringContainsString('Tk. 200', $output);
        $this->assertStringContainsString('Delicious cheese pizza', $output);
    }

    public function testSearchNoResults()
    {
        // Simulate search query
        $_GET['q'] = 'NonExistentFood';

        // Mock result set with zero records
        $result = $this->createMock(mysqli_result::class);
        $result->method('num_rows')
               ->willReturn(0);

        // Mock the query method
        $this->conn->expects($this->once())
                   ->method('query')
                   ->willReturn($result);

        // Capture output for validation
        ob_start();
        include 'path/to/your/search/file.php'; // Replace with your file path
        $output = ob_get_clean();

        // Check if the output contains the 'Food not found' message
        $this->assertStringContainsString('Food not found', $output);
    }
}
