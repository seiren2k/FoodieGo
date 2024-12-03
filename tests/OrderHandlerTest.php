vendor/bin/phpunit/ tests/OrderHandlerTest.php
<?php

use PHPUnit\Framework\TestCase;

class OrderHandlerTest extends TestCase
{
    protected $conn;
    
    protected function setUp(): void
    {
        // Mock the MySQLi connection
        $this->conn = $this->createMock(mysqli::class);
    }

    public function testSuccessfulOrderProcessing()
    {
        // Simulate form data and Stripe token
        $_POST = [
            'full-name' => 'Test User',
            'contact' => '1234567890',
            'email' => 'test@example.com',
            'address' => '123 Test Street',
            'food' => 'Pizza',
            'price' => '200',
            'qty' => '2',
            'stripeToken' => 'tok_visa'
        ];

        // Mock Stripe response
        $charge = $this->createMock(\Stripe\Charge::class);
        $charge->status = 'succeeded';

        // Mock Stripe::setApiKey method
        \Stripe\Stripe::setApiKey('sk_test_1234567890abcdef');

        // Mock Stripe::Charge::create
        $stripeChargeMock = $this->getMockBuilder(\Stripe\Charge::class)
                                 ->disableOriginalConstructor()
                                 ->getMock();
        $stripeChargeMock->expects($this->once())
                         ->method('create')
                         ->willReturn($charge);

        // Capture output for validation
        ob_start();
        include 'path/to/your/order/file.php'; // Replace with your file path
        $output = ob_get_clean();

        // Verify success message in output
        $this->assertStringContainsString('Payment successful. Your order has been placed!', $output);
    }

    public function testPaymentFailureHandling()
    {
        // Simulate form data and Stripe token
        $_POST['stripeToken'] = 'tok_invalid';

        // Mock Stripe to throw a CardException
        $this->expectException(\Stripe\Exception\CardException::class);

        // Capture output for validation
        ob_start();
        include 'path/to/your/order/file.php'; // Replace with your file path
        $output = ob_get_clean();

        // Verify error message
        $this->assertStringContainsString('Payment failed:', $output);
    }
}
