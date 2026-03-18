<?php
/**
 * Database Setup Script
 * Creates database and tables for photobooth
 * 
 * Run this once: http://localhost/photobooth/db_setup.php
 */

// Database credentials for initial connection
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_PORT', 3306);
define('DB_NAME', 'photobooth');

$errorMsg = '';
$successMsg = '';

// Create connection to MySQL server (without database)
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, '', DB_PORT);

if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
} else {
    // Create database if not exists
    $createDB = "CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    
    if (!$conn->query($createDB)) {
        $errorMsg = "Error creating database: " . $conn->error;
    } else {
        $successMsg = "✓ Database created successfully<br>";
        
        // Select the database
        $conn->select_db(DB_NAME);
        
        // Create photos table
        $createTable = "CREATE TABLE IF NOT EXISTS `photos` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `filename` VARCHAR(255) NOT NULL UNIQUE,
            `original_name` VARCHAR(255),
            `file_size` INT,
            `width` INT,
            `height` INT,
            `mime_type` VARCHAR(50),
            `upload_path` VARCHAR(255) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `deleted_at` TIMESTAMP NULL,
            `is_deleted` BOOLEAN DEFAULT FALSE,
            `user_ip` VARCHAR(45),
            `thumbnail_path` VARCHAR(255),
            INDEX `idx_created_at` (`created_at`),
            INDEX `idx_is_deleted` (`is_deleted`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if (!$conn->query($createTable)) {
            $errorMsg .= "Error creating photos table: " . $conn->error . "<br>";
        } else {
            $successMsg .= "✓ Photos table created successfully<br>";
        }
        
        // Create settings table
        $createSettingsTable = "CREATE TABLE IF NOT EXISTS `settings` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `setting_key` VARCHAR(100) NOT NULL UNIQUE,
            `setting_value` LONGTEXT,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        if (!$conn->query($createSettingsTable)) {
            $errorMsg .= "Error creating settings table: " . $conn->error . "<br>";
        } else {
            $successMsg .= "✓ Settings table created successfully<br>";
        }
        
        // Insert default settings
        $insertSettings = "INSERT IGNORE INTO `settings` (`setting_key`, `setting_value`) VALUES
            ('app_title', 'Online Photobooth'),
            ('app_description', 'Capture and share your memories'),
            ('max_file_size', '5242880'),
            ('max_photos', '1000'),
            ('retention_days', '90')";
        
        if (!$conn->query($insertSettings)) {
            $errorMsg .= "Error inserting settings: " . $conn->error . "<br>";
        } else {
            $successMsg .= "✓ Default settings inserted<br>";
        }
        
        $conn->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photobooth Database Setup</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 10px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }
        
        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 1.05em;
            line-height: 1.6;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .steps {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-top: 30px;
        }
        
        .steps h3 {
            color: #333;
            margin-bottom: 15px;
        }
        
        .steps ol {
            margin-left: 20px;
            line-height: 1.8;
        }
        
        .steps li {
            margin-bottom: 10px;
            color: #555;
        }
        
        .steps code {
            background: #e9ecef;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: monospace;
        }
        
        .button-container {
            text-align: center;
            margin-top: 30px;
        }
        
        .button-container a {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .button-container a:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .database-info {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.95em;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 Database Setup</h1>
        
        <div class="database-info">
            <strong>Database Connection:</strong><br>
            Host: <code><?php echo DB_HOST; ?></code><br>
            Database: <code><?php echo DB_NAME; ?></code><br>
            User: <code><?php echo DB_USER; ?></code>
        </div>
        
        <?php if (!empty($successMsg)): ?>
            <div class="message success">
                <strong>✓ Setup Successful!</strong><br>
                <?php echo $successMsg; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($errorMsg)): ?>
            <div class="message error">
                <strong>✗ Setup Error:</strong><br>
                <?php echo $errorMsg; ?>
            </div>
            
            <div class="steps">
                <h3>Troubleshooting:</h3>
                <ol>
                    <li>Ensure MySQL is running</li>
                    <li>Verify database credentials in <code>db_config.php</code></li>
                    <li>Check if user <code><?php echo DB_USER; ?></code> has permissions</li>
                    <li>Try creating database manually if auto-creation fails</li>
                </ol>
            </div>
        <?php else: ?>
            <div class="steps">
                <h3>📋 Setup Complete!</h3>
                <p>Your photobooth database has been configured with:</p>
                <ol>
                    <li>✓ <strong>photobooth</strong> database</li>
                    <li>✓ <strong>photos</strong> table - stores photo metadata</li>
                    <li>✓ <strong>settings</strong> table - stores configuration</li>
                </ol>
                
                <h3 style="margin-top: 25px;">📝 Database Configuration</h3>
                <p>Edit <code>db_config.php</code> if you need to change:</p>
                <ul style="margin-left: 20px; margin-top: 10px;">
                    <li><code>DB_HOST</code></li>
                    <li><code>DB_USER</code></li>
                    <li><code>DB_PASS</code></li>
                    <li><code>DB_NAME</code></li>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="button-container">
            <a href="index.php">← Back to Photobooth</a>
        </div>
    </div>
</body>
</html>
