<?php
// setup_hosting.php - For hosting environments
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Blog Application - Hosting Setup</h2>";

// Check PHP version
if (version_compare(PHP_VERSION, '7.4.0') < 0) {
    echo "<p style='color: orange;'>Warning: PHP version " . PHP_VERSION . " - Recommended: 7.4 or higher</p>";
} else {
    echo "<p style='color: green;'>✓ PHP version " . PHP_VERSION . " is good</p>";
}

// Check if PDO MySQL is available
if (!extension_loaded('pdo_mysql')) {
    echo "<p style='color: red;'>✗ PDO MySQL extension is not loaded</p>";
} else {
    echo "<p style='color: green;'>✓ PDO MySQL extension is available</p>";
}

// Check if we can create the database
try {
    // Try to get database connection from environment variables or use defaults
    $host = getenv('DB_HOST') ?: 'localhost';
    $dbname = getenv('DB_NAME') ?: 'blog_db';
    $username = getenv('DB_USERNAME') ?: 'root';
    $password = getenv('DB_PASSWORD') ?: 'root';
    $port = getenv('DB_PORT') ?: '3306';
    
    $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Create database if it doesn't exist
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p style='color: green;'>✓ Database '$dbname' ready</p>";
    
    // Use the database
    $pdo->exec("USE $dbname");
    
    // Create tables
    $pdo->exec("CREATE TABLE IF NOT EXISTS user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('user', 'admin') DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "<p style='color: green;'>✓ User table created</p>";
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS blogPost (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
    )");
    echo "<p style='color: green;'>✓ BlogPost table created</p>";
    
    echo "<h3 style='color: green;'>🎉 Hosting setup completed successfully!</h3>";
    echo "<p>Your blog application is ready for use.</p>";
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Database Error: " . $e->getMessage() . "</p>";
    echo "<p><strong>Note for hosting:</strong> You may need to:</p>";
    echo "<ul>";
    echo "<li>Create the database manually in your hosting control panel</li>";
    echo "<li>Update the database credentials in config/database.php</li>";
    echo "<li>Import the SQL file provided in the documentation</li>";
    echo "</ul>";
}

// Check file permissions
$writable_dirs = ['config', 'includes', 'css', 'js', 'images'];
foreach ($writable_dirs as $dir) {
    if (!is_writable($dir)) {
        echo "<p style='color: orange;'>Note: Directory '$dir' might need write permissions for file uploads</p>";
    }
}

echo "<hr>";
echo "<p><a href='index.php'>Go to Blog Homepage</a></p>";
?>
