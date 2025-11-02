<?php
require_once 'includes/auth.php';
require_once 'config/database.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    redirect('dashboard.php');
}

$database = new Database();
$db = $database->getConnection();

// Check if blog exists and user owns it
$query = "SELECT * FROM blogPost WHERE id = ? AND user_id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$_GET['id'], getCurrentUserId()]);
$blogPost = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blogPost) {
    redirect('dashboard.php');
}

// Delete the blog post
$query = "DELETE FROM blogPost WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$_GET['id']]);

redirect('dashboard.php');
?>
