<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

$blogPosts = getAllBlogPosts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBlog - Modern Blog Platform</title>
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
        <h1>Latest Blog Posts</h1>
        
        <?php if (empty($blogPosts)): ?>
            <div class="text-center">
                <p style="color: var(--gray-600); margin-bottom: 2rem;">No blog posts yet. Be the first to share your story!</p>
                <a href="register.php" class="btn">Get Started</a>
            </div>
        <?php else: ?>
            <div class="blog-grid">
                <?php foreach ($blogPosts as $post): ?>
                    <div class="blog-card">
                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        <div class="blog-meta">
                            By <?php echo htmlspecialchars($post['username']); ?> 
                            • <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
                        </div>
                        <p><?php echo substr(htmlspecialchars($post['content']), 0, 150); ?>...</p>
                        <a href="view-blog.php?id=<?php echo $post['id']; ?>" class="btn">Read More</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
