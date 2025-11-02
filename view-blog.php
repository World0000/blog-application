<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$blogPost = getBlogPostById($_GET['id']);

if (!$blogPost) {
    header('Location: index.php');
    exit();
}

$isOwner = isLoggedIn() && $blogPost['user_id'] == getCurrentUserId();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blogPost['title']); ?> - Blog Application</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">MyBlog</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <?php if (isLoggedIn()): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="create-blog.php">Write Blog</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main class="container">
        <div class="blog-content">
            <h1><?php echo htmlspecialchars($blogPost['title']); ?></h1>
            
            <div class="blog-meta">
                Written by <?php echo htmlspecialchars($blogPost['username']); ?> 
                on <?php echo date('F j, Y', strtotime($blogPost['created_at'])); ?>
            </div>

            <div style="margin-top: 2rem; line-height: 1.8; white-space: pre-line;">
                <?php echo htmlspecialchars($blogPost['content']); ?>
            </div>

            <?php if ($isOwner): ?>
                <div class="blog-actions">
                    <a href="edit-blog.php?id=<?php echo $blogPost['id']; ?>" class="btn">Edit</a>
                    <a href="delete-blog.php?id=<?php echo $blogPost['id']; ?>" 
                       class="btn btn-danger" 
                       onclick="return confirm('Are you sure you want to delete this blog?')">Delete</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
