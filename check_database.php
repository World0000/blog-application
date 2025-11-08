<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo "<h2>Database Check</h2>";
    
    // Check users
    $query = "SELECT * FROM user";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Users (" . count($users) . "):</h3>";
    foreach ($users as $user) {
        echo "ID: " . $user['id'] . " | Username: " . $user['username'] . " | Email: " . $user['email'] . "<br>";
    }
    
    // Check blog posts
    $query = "SELECT bp.*, u.username FROM blogPost bp JOIN user u ON bp.user_id = u.id";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Blog Posts (" . count($posts) . "):</h3>";
    foreach ($posts as $post) {
        echo "ID: " . $post['id'] . " | Title: " . $post['title'] . " | Author: " . $post['username'] . " | Created: " . $post['created_at'] . "<br>";
    }
} else {
    echo "Database connection failed!";
}
?>
<a href="index.php">Back to Home</a>
