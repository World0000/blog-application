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
    <title><?php echo htmlspecialchars($blogPost['title']); ?> - MyBlog</title>
    <link rel="stylesheet" href="css/modern-simple.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="container">
            <a href="index.php" class="logo">MyBlog</a>
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
            
            <div class="blog-meta" style="margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid var(--gray-200);">
                <strong>By <?php echo htmlspecialchars($blogPost['username']); ?></strong> 
                • <?php echo date('F j, Y \a\t g:i A', strtotime($blogPost['created_at'])); ?>
                <?php if ($blogPost['updated_at'] != $blogPost['created_at']): ?>
                    <br><em>Updated: <?php echo date('F j, Y \a\t g:i A', strtotime($blogPost['updated_at'])); ?></em>
                <?php endif; ?>
            </div>

            <div style="line-height: 1.8; font-size: 1.1rem; white-space: pre-line;">
                <?php echo htmlspecialchars($blogPost['content']); ?>
            </div>

            <?php if ($isOwner): ?>
                <div class="blog-actions" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--gray-200);">
                    <a href="edit-blog.php?id=<?php echo $blogPost['id']; ?>" class="btn">Edit Post</a>
                    <a href="delete-blog.php?id=<?php echo $blogPost['id']; ?>" 
                       class="btn btn-danger" 
                       onclick="return confirm('Are you sure you want to delete this blog post?')">Delete Post</a>
                    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            <?php else: ?>
                <div class="blog-actions" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--gray-200);">
                    <a href="index.php" class="btn">Back to All Posts</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
