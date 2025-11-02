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
    echo "Blog post not found or you don't have permission to edit it.";
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $error = 'Both title and content are required.';
    } else {
        $query = "UPDATE blogPost SET title = ?, content = ? WHERE id = ?";
        $stmt = $db->prepare($query);
        
        if ($stmt->execute([$title, $content, $blogPost['id']])) {
            $success = 'Blog post updated successfully!';
            // Update the current blog post data
            $blogPost['title'] = $title;
            $blogPost['content'] = $content;
        } else {
            $error = 'Failed to update blog post. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog - Blog Application</title>
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
        <div class="form-container">
            <h2>Edit Blog Post</h2>
            
            <?php if ($error): ?>
                <div style="color: red; margin-bottom: 1rem; padding: 10px; background: #ffe6e6; border: 1px solid red; border-radius: 4px;"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div style="color: green; margin-bottom: 1rem; padding: 10px; background: #e6ffe6; border: 1px solid green; border-radius: 4px;"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required
                           value="<?php echo htmlspecialchars($blogPost['title']); ?>">
                </div>

                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" required><?php echo htmlspecialchars($blogPost['content']); ?></textarea>
                </div>

                <button type="submit" class="btn">Update Blog Post</button>
                <a href="view-blog.php?id=<?php echo $blogPost['id']; ?>" class="btn" style="background: #7f8c8d;">Cancel</a>
            </form>
        </div>
    </main>
</body>
</html>
