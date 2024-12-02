<?php
defined('BASEPATH') OR exit('No direct script access allowed');  // Prevent direct script access

// Database configuration - Defines the database connection parameters
$db['default'] = array(
    'hostname' => 'localhost',  // Database host (typically localhost for local development)
    'username' => 'root',  // Database username (default 'root' for local development)
    'password' => '',  // Database password (empty for local development)
    'database' => 'foodiego',  // The database name to connect to
    'dbdriver' => 'mysqli'  // Database driver (mysqli is used for MySQL connections)
);

// Database class - Implements Singleton pattern to manage a single database connection instance
class Database {
    private static $instance = null;  // Holds the single instance of the Database class
    private $connection;  // Holds the database connection resource

    // Constructor - Initializes the database connection
    // Uses the $db configuration array to establish the connection
    private function __construct() {
        global $db;
        // Establishing the MySQL connection using mysqli
        $this->connection = mysqli_connect(
            $db['default']['hostname'],  // Database hostname
            $db['default']['username'],  // Database username
            $db['default']['password'],  // Database password
            $db['default']['database']   // Database name
        );

        // Check if the connection is successful, otherwise terminate the script
        if (mysqli_connect_errno()) {
            die("Database connection failed: " . mysqli_connect_error());  // Exit if connection fails
        }
    }

    // getInstance - Returns the single instance of the Database class
    // Implements the Singleton pattern to ensure only one connection instance exists
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();  // Creates the instance if it doesn't exist
        }
        return self::$instance;  // Returns the existing instance
    }

    // getConnection - Returns the active database connection
    // This can be used by other parts of the application to interact with the database
    public function getConnection() {
        return $this->connection;  // Returns the connection resource
    }
}
?>