<?php
require_once 'includes/auth.php';
require_once 'config/database.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if (empty($title) || empty($content)) {
        $error = 'Both title and content are required.';
    } else {
        $database = new Database();
        $db = $database->getConnection();

        $query = "INSERT INTO blogPost (user_id, title, content) VALUES (?, ?, ?)";
        $stmt = $db->prepare($query);
        
        if ($stmt->execute([getCurrentUserId(), $title, $content])) {
            $success = 'Blog post created successfully!';
            // Clear form
            $title = $content = '';
        } else {
            $error = 'Failed to create blog post. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Blog - Blog Application</title>
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
            <h2>Create New Blog Post</h2>
            
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
                           value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" required><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
                </div>

                <button type="submit" class="btn">Create Blog Post</button>
                <a href="dashboard.php" class="btn" style="background: #7f8c8d;">Cancel</a>
            </form>
        </div>
    </main>
</body>
</html>
