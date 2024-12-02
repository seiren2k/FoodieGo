<?php
use PHPUnit\Framework\TestCase;

class ProfileTest extends TestCase
{
    private $dbMock;
    private $sessionMock;
    private $profile;

    protected function setUp(): void
    {
        // Mock the database connection (mysqli)
        $this->dbMock = $this->createMock(mysqli::class);

        // Mock the session management
        $this->sessionMock = $this->getMockBuilder(stdClass::class)
                                   ->setMethods(['start', 'get'])
                                   ->getMock();

        // Assume you have a Profile class where you inject the mocks
        $this->profile = new Profile($this->dbMock, $this->sessionMock);
    }

    public function testCheckLoginStatusNotLoggedIn()
    {
        // Simulate the case where the user is not logged in
        $this->sessionMock->method('get')->willReturn(null); // No user in session

        // Expect a redirection to the login page
        $this->expectOutputString('Location: login.php');
        $this->profile->checkLoginStatus();
    }

    // More tests go coming

    public function testFetchUserProfile()
{
    // Mock the database query result
    $userData = [
        'id' => 1,
        'name' => 'Jashim',
        'email' => 'jashim@yahoo.com',
        'phone' => '123456789',
        'role' => 'customer'
    ];

    // Simulate a successful database query
    $stmtMock = $this->createMock(mysqli_stmt::class);
    $this->dbMock->method('prepare')->willReturn($stmtMock);
    $stmtMock->method('bind_param');
    $stmtMock->method('execute');
    $stmtMock->method('get_result')->willReturn($this->createMockResult($userData));

    // Simulate getting the user profile
    $user = $this->profile->getCustomerProfile(1);
    
    $this->assertEquals($userData, $user);
}

private function createMockResult($result)
{
    $mockResult = $this->createMock(mysqli_result::class);
    $mockResult->method('fetch_assoc')->willReturn($result);
    return $mockResult;
}

}

