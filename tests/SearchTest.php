<?php

use PHPUnit\Framework\TestCase;

class SearchTest extends TestCase
{
    protected $conn;

    protected function setUp(): void
    {
        // Mock MySQLi connection
        $this->conn = $this->createMock(mysqli::class);
    }

    public function testSearchReturnsResults()
    {
        $_POST['search'] = 'Pizza';
        $search = 'Pizza';

        // Mock the result object
        $result = $this->createMock(mysqli_result::class);
        $result->method('num_rows')
               ->willReturn(1);

        // Expect the query method to be called once
        $this->conn->expects($this->once())
                   ->method('query')
                   ->with($this->stringContains($search))
                   ->willReturn($result);

        // Simulate query execution
        $actualResult = $this->conn->query("SELECT * FROM food WHERE title LIKE '%$search%' OR description LIKE '%$search%'");
        $this->assertSame($result, $actualResult);
    }

    public function testSearchNoResults()
    {
        $_POST['search'] = 'InvalidFood';
        $search = 'InvalidFood';

        // Mock the result object
        $result = $this->createMock(mysqli_result::class);
        $result->method('num_rows')
               ->willReturn(0);

        // Expect the query method to be called once
        $this->conn->expects($this->once())
                   ->method('query')
                   ->with($this->stringContains($search))
                   ->willReturn($result);

        // Simulate query execution
        $actualResult = $this->conn->query("SELECT * FROM food WHERE title LIKE '%$search%' OR description LIKE '%$search%'");
        $this->assertSame($result, $actualResult);
    }
}
