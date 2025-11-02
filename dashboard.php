<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$userBlogs = getUserBlogPosts(getCurrentUserId());
$blogCount = count($userBlogs);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MyBlog</title>
    <link rel="stylesheet" href="css/modern-simple.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="container">
            <a href="index.php" class="logo">MyBlog</a>
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
        
        <!-- Welcome Section -->
        <div class="blog-card" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; margin-bottom: 2rem;">
            <h2 style="color: white; margin-bottom: 0.5rem;">Welcome back, <?php echo $_SESSION['username']; ?>! 👋</h2>
            <p style="color: rgba(255,255,255,0.9); margin: 0;">Manage your blog posts and create new content.</p>
        </div>

        <!-- Quick Stats -->
        <div class="dashboard-stats">
            <div class="stat-card">
                <span class="stat-number"><?php echo $blogCount; ?></span>
                <span class="stat-label">Total Posts</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?php echo $blogCount > 0 ? array_sum(array_map('str_word_count', array_column($userBlogs, 'content'))) : 0; ?></span>
                <span class="stat-label">Words Written</span>
            </div>
            <div class="stat-card">
                <span class="stat-number"><?php echo $blogCount > 0 ? round(array_sum(array_map('str_word_count', array_column($userBlogs, 'content'))) / $blogCount) : 0; ?></span>
                <span class="stat-label">Avg. Words/Post</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;">
            <a href="create-blog.php" class="btn">+ Create New Post</a>
            <a href="index.php" class="btn btn-secondary">View All Posts</a>
        </div>

        <!-- Blog Posts Section -->
        <h2 style="margin-bottom: 1.5rem;">My Blog Posts</h2>
        
        <?php if (empty($userBlogs)): ?>
            <div class="blog-card text-center">
                <h3 style="color: var(--gray-600); margin-bottom: 1rem;">No blog posts yet</h3>
                <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Start sharing your thoughts with the community!</p>
                <a href="create-blog.php" class="btn">Create Your First Post</a>
            </div>
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
                        <p><?php echo substr(htmlspecialchars($post['content']), 0, 120); ?>...</p>
                        <div class="blog-actions">
                            <a href="view-blog.php?id=<?php echo $post['id']; ?>" class="btn">View</a>
                            <a href="edit-blog.php?id=<?php echo $post['id']; ?>" class="btn btn-secondary">Edit</a>
                            <a href="delete-blog.php?id=<?php echo $post['id']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this blog post?')">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>
