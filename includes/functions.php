<?php
require_once 'config/database.php';

function getAllBlogPosts() {
    $database = new Database();
    $db = $database->getConnection();
    
    if (!$db) {
        return [];
    }
    
    $query = "SELECT bp.*, u.username 
              FROM blogPost bp 
              JOIN user u ON bp.user_id = u.id 
              ORDER BY bp.created_at DESC";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getBlogPostById($id) {
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT bp.*, u.username 
              FROM blogPost bp 
              JOIN user u ON bp.user_id = u.id 
              WHERE bp.id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserBlogPosts($user_id) {
    $database = new Database();
    $db = $database->getConnection();
    
    $query = "SELECT * FROM blogPost WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $db->prepare($query);
    $stmt->execute([$user_id]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
