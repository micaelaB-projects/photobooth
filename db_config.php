<?php
/**
 * Database Configuration
 * MySQL connection settings
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'photobooth');
define('DB_PORT', 3306);

/**
 * Create database connection
 * @return mysqli|false
 */
function getDBConnection() {
    static $connection = null;
    
    if ($connection === null) {
        $connection = new mysqli(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME,
            DB_PORT
        );
        
        if ($connection->connect_error) {
            die(json_encode([
                'success' => false,
                'error' => 'Database connection failed: ' . $connection->connect_error
            ]));
        }
        
        $connection->set_charset("utf8mb4");
    }
    
    return $connection;
}

/**
 * Close database connection
 */
function closeDBConnection() {
    global $connection;
    if ($connection !== null) {
        $connection->close();
    }
}

// Register shutdown function
register_shutdown_function('closeDBConnection');

?>
