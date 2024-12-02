<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use FoodieGo\Controllers\Auth;
use FoodieGo\Models\Auth_Model;
use ReflectionClass;

// Add error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure required files are included
require_once __DIR__ . '/../../vendor/autoload.php';

// Define constants for testing if not already defined
if (!defined('SITEURL')) {
    define('SITEURL', 'http://localhost/FoodieGo/');
}

// Mock session handling
if (!function_exists('session_start')) {
    /**
     * Starts a session if it hasn't already been started.
     * 
     * This is a mock implementation to ensure session functionality is available during tests.
     */
    function session_start() {
        if (session_status() === PHP_SESSION_NONE) {
            $_SESSION = [];
        }
    }
}

if (!function_exists('session_destroy')) {
    /**
     * Destroys the current session and clears session data.
     * 
     * This is a mock implementation to ensure session functionality is available during tests.
     */
    function session_destroy() {
        $_SESSION = [];
    }
}

/**
 * Unit tests for the Auth class in the FoodieGo application.
 * 
 * This class contains tests for authentication functionality, including login 
 * with valid and invalid credentials, and handling of session data.
 * 
 * @covers \FoodieGo\Controllers\Auth
 */
class AuthTest extends TestCase
{
    /**
     * @var Auth The instance of the Auth controller being tested.
     */
    private $auth;

    /**
     * @var Auth_Model The mocked instance of the Auth_Model used for testing.
     */
    private $auth_model;

    /**
     * Sets up the test environment before each test method is run.
     * 
     * Initializes a fresh session and prepares the Auth controller with a mocked 
     * Auth_Model.
     * 
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Reset session before each test
        $_SESSION = [];
        
        // Create mock for Auth_Model
        $this->auth_model = $this->createMock(Auth_Model::class);
        
        // Create Auth instance with mocked dependencies
        $this->auth = new Auth();
        
        // Use Reflection to set private property
        try {
            $reflection = new ReflectionClass(Auth::class);
            $property = $reflection->getProperty('auth_model');
            $property->setAccessible(true);
            $property->setValue($this->auth, $this->auth_model);
        } catch (\ReflectionException $e) {
            // Log or print reflection error
            echo "Reflection Error: " . $e->getMessage() . "\n";
        }
    }

    /**
     * Test if the required classes exist.
     * 
     * This test checks if the Auth and Auth_Model classes are properly loaded.
     * 
     * @return void
     */
    public function testClassesExist(): void
    {
        // Print out class details for debugging
        echo "Auth class exists: " . (class_exists(Auth::class) ? 'Yes' : 'No') . "\n";
        echo "Auth_Model class exists: " . (class_exists(Auth_Model::class) ? 'Yes' : 'No') . "\n";

        $this->assertTrue(class_exists(Auth::class), 'Auth class should exist');
        $this->assertTrue(class_exists(Auth_Model::class), 'Auth_Model class should exist');
    }

    /**
     * Test login functionality with valid user credentials.
     * 
     * This test simulates a login attempt with valid user credentials and 
     * checks if the session is properly set with user data.
     * 
     * @return void
     */
    public function testLoginWithValidUserCredentials(): void
    {
        // Arrange
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'test@example.com';
        $_POST['password'] = 'password123';

        $expectedUserData = [
            'id' => 1,
            'email' => 'test@example.com',
            'username' => 'testuser',
            'role' => 'user'
        ];

        // Configure mock to return successful login
        $this->auth_model->method('login')
            ->willReturn([
                'status' => true,
                'user_data' => $expectedUserData,
                'role' => 'user'
            ]);

        // Act
        ob_start(); // Capture output
        $this->auth->login();
        $output = ob_get_clean();

        // Assert
        $this->assertEquals(1, $_SESSION['user_id']);
        $this->assertEquals('testuser', $_SESSION['username']);
        $this->assertEquals('user', $_SESSION['user_role']);
    }

    /**
     * Test login functionality with valid admin credentials.
     * 
     * This test simulates a login attempt with valid admin credentials and 
     * checks if the session is properly set with admin data.
     * 
     * @return void
     */
    public function testLoginWithValidAdminCredentials(): void
    {
        // Arrange
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'admin';
        $_POST['password'] = 'admin123';

        $expectedAdminData = [
            'id' => 1,
            'username' => 'admin',
            'role' => 'admin'
        ];

        // Configure mock to return successful admin login
        $this->auth_model->method('login')
            ->willReturn([
                'status' => true,
                'user_data' => $expectedAdminData,
                'role' => 'admin'
            ]);

        // Act
        ob_start();
        $this->auth->login();
        $output = ob_get_clean();

        // Assert
        $this->assertEquals(1, $_SESSION['user_id']);
        $this->assertEquals('admin', $_SESSION['username']);
        $this->assertEquals('admin', $_SESSION['user_role']);
    }

    /**
     * Test login functionality with invalid credentials.
     * 
     * This test simulates a login attempt with invalid credentials and 
     * ensures that no session data is set and an appropriate error message is returned.
     * 
     * @return void
     */
    public function testLoginWithInvalidCredentials(): void
    {
        // Arrange
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = 'invalid@example.com';
        $_POST['password'] = 'wrongpassword';

        // Configure mock to return failed login
        $this->auth_model->method('login')
            ->willReturn(['status' => false]);

        // Act
        ob_start();
        $this->auth->login();
        $output = ob_get_clean();

        // Assert
        $this->assertArrayNotHasKey('user_id', $_SESSION);
        $this->assertArrayNotHasKey('username', $_SESSION);
        $this->assertArrayNotHasKey('user_role', $_SESSION);
        $this->assertStringContainsString('Invalid username or password', $output);
    }

    /**
     * Test login functionality with empty fields.
     * 
     * This test simulates a login attempt where the username and password fields 
     * are empty, and checks if an appropriate error message is returned.
     * 
     * @return void
     */
    public function testLoginWithEmptyFields(): void
    {
        // Arrange
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['username'] = '';
        $_POST['password'] = '';

        // Act
        ob_start();
        $this->auth->login();
        $output = ob_get_clean();

        // Assert
        $this->assertArrayNotHasKey('user_id', $_SESSION);
        $this->assertStringContainsString('Please fill in all fields', $output);
    }

    /**
     * Cleans up after each test method is run.
     * 
     * This method resets the POST data and session data after each test.
     * 
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        
        // Clean up
        $_POST = [];
        $_SESSION = [];
    }
}