<?php
defined('BASEPATH') OR exit('No direct script access allowed');  // Prevent direct script access

/**
 * @file database.php
 * @brief This file contains the database connection configuration and the Database class.
 * 
 * The file defines the connection parameters for the database and implements a Singleton pattern for managing a single database connection instance.
 */

/**
 * @var $db['default']
 * @brief Defines the default database connection parameters.
 * 
 * This array contains the configuration details required to connect to the database.
 * The parameters include the hostname, username, password, database name, and the driver to use.
 * 
 * @note Modify the parameters according to your database settings.
 */
$db['default'] = array(
    'hostname' => 'localhost',  /**< @brief Database hostname (typically localhost for local development) */
    'username' => 'root',       /**< @brief Database username (default 'root' for local development) */
    'password' => '',           /**< @brief Database password (empty for local development) */
    'database' => 'foodiego',   /**< @brief The database name to connect to */
    'dbdriver' => 'mysqli'      /**< @brief Database driver (mysqli is used for MySQL connections) */
);

/**
 * @class Database
 * @brief A singleton class to manage a database connection instance.
 * 
 * This class follows the Singleton design pattern to ensure that only one instance of the database connection exists
 * throughout the application's lifecycle. It provides methods to retrieve and use the database connection.
 */
class Database {
    /**
     * @var $instance
     * @brief Holds the single instance of the Database class.
     *
     * This is the only instance of the Database class that will exist, ensuring a single connection to the database.
     */
    private static $instance = null;

    /**
     * @var $connection
     * @brief Holds the active database connection resource.
     *
     * This is the resource that represents the established connection to the database.
     */
    private $connection;

    /**
     * @brief Private constructor to initialize the database connection.
     * 
     * This constructor uses the configuration parameters defined in the `$db['default']` array to connect to the database.
     * If the connection fails, the script will terminate with an error message.
     */
    private function __construct() {
        global $db;

        // Establishing the MySQL connection using mysqli
        $this->connection = mysqli_connect(
            $db['default']['hostname'],  /**< @brief Database hostname */
            $db['default']['username'],  /**< @brief Database username */
            $db['default']['password'],  /**< @brief Database password */
            $db['default']['database']   /**< @brief Database name */
        );

        // Check if the connection is successful, otherwise terminate the script
        if (mysqli_connect_errno()) {
            die("Database connection failed: " . mysqli_connect_error());  /**< @brief Terminate if connection fails */
        }
    }

    /**
     * @brief Returns the single instance of the Database class.
     * 
     * This method implements the Singleton pattern. If the instance does not already exist, it is created.
     * Once created, the same instance is returned for subsequent calls.
     * 
     * @return Database The single instance of the Database class.
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();  /**< @brief Creates the instance if it doesn't exist */
        }
        return self::$instance;  /**< @brief Returns the existing instance */
    }

    /**
     * @brief Returns the active database connection.
     * 
     * This method allows other parts of the application to interact with the database by returning
     * the active connection resource.
     * 
     * @return resource The active database connection.
     */
    public function getConnection() {
        return $this->connection;  /**< @brief Returns the connection resource */
    }
}
?>