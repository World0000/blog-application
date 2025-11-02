<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$userBlogs = getUserBlogPosts(getCurrentUserId());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Blog Application</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="container">
            <div class="logo">MyBlog</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="create-blog.php">Write Blog</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h1>My Dashboard</h1>
        <p>Welcome back, <?php echo $_SESSION['username']; ?>!</p>

        <div style="margin: 2rem 0;">
            <a href="create-blog.php" class="btn">Create New Blog</a>
        </div>

        <h2>My Blog Posts</h2>
        
        <?php if (empty($userBlogs)): ?>
            <p>You haven't written any blog posts yet.</p>
        <?php else: ?>
            <div class="blog-grid">
                <?php foreach ($userBlogs as $post): ?>
                    <div class="blog-card">
                        <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                        <div class="blog-meta">
                            Created: <?php echo date('F j, Y', strtotime($post['created_at'])); ?>
                            <?php if ($post['updated_at'] != $post['created_at']): ?>
                                <br>Updated: <?php echo date('F j, Y', strtotime($post['updated_at'])); ?>
                            <?php endif; ?>
                        </div>
                        <p><?php echo substr(htmlspecialchars($post['content']), 0, 150); ?>...</p>
                        <div class="blog-actions">
                            <a href="view-blog.php?id=<?php echo $post['id']; ?>" class="btn">View</a>
                            <a href="edit-blog.php?id=<?php echo $post['id']; ?>" class="btn">Edit</a>
                            <a href="delete-blog.php?id=<?php echo $post['id']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this blog?')">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
