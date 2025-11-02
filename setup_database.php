<?php
// setup_database.php - MAMP Version
error_reporting(E_ALL);
ini_set('display_errors', 1);

// MAMP Default Settings
$host = 'localhost';
$user = 'root';
$password = 'root'; // MAMP default password
$port = 8889;       // MAMP MySQL port

echo "<h2>Setting up Blog Database with MAMP...</h2>";

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✓ Connected to MySQL server successfully<br>";
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS blog_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✓ Database 'blog_db' created or already exists<br>";
    
    // Select the database
    $pdo->exec("USE blog_db");
    echo "✓ Using database 'blog_db'<br>";
    
    // Create user table
    $pdo->exec("CREATE TABLE IF NOT EXISTS user (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('user', 'admin') DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✓ User table created successfully<br>";
    
    // Create blogPost table
    $pdo->exec("CREATE TABLE IF NOT EXISTS blogPost (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
    )");
    echo "✓ BlogPost table created successfully<br>";
    
    echo "<h3 style='color: green;'>🎉 Database setup completed successfully!</h3>";
    echo "<p>You can now access your blog at: <a href='http://localhost:8888/blog-application/'>http://localhost:8888/blog-application/</a></p>";
    
} catch(PDOException $e) {
    echo "<h3 style='color: red;'>Error: " . $e->getMessage() . "</h3>";
    
    // MAMP-specific troubleshooting
    if (strpos($e->getMessage(), 'Access denied') !== false) {
        echo "<p><strong>MAMP Tip:</strong> Make sure MySQL is running in MAMP and using password 'root'</p>";
    } elseif (strpos($e->getMessage(), 'Connection refused') !== false) {
        echo "<p><strong>MAMP Tip:</strong> Check that MAMP MySQL is running on port 8889</p>";
    }
}
?>
