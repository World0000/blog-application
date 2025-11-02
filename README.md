# Blog Application

A complete blog application built with HTML, CSS, JavaScript, PHP, and MySQL for the backend module assignment.

## Features

- **User Authentication & Authorization**
  - User registration and login
  - Secure password hashing
  - Session management
  - Users can only manage their own blog posts

- **Blog Management**
  - Create new blog posts
  - Read all blogs on home page
  - Update own blog posts
  - Delete own blog posts
  - View single blog posts

- **Frontend Features**
  - Responsive design
  - Clean and modern UI
  - User-friendly navigation
  - Form validation

- **Database**
  - MySQL database with two main tables:
    - `user` (id, username, email, password, role, created_at)
    - `blogPost` (id, user_id, title, content, created_at, updated_at)

## Technology Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP
- **Database:** MySQL
- **Server:** Apache
- **Security:** Password hashing, SQL injection prevention with PDO

## Installation

### Local Development (XAMPP/MAMP)
1. Place project in `htdocs` folder
2. Start Apache and MySQL servers
3. Visit `setup_database.php` to create database and tables
4. Access application at `http://localhost/blog-application/`

### Hosting Deployment
1. Upload all files to web server
2. Create MySQL database
3. Update database credentials in `config/database.php`
4. Run `setup_hosting.php` to initialize database

## File Structure

ls -la README.md
cat > database_schema.sql << 'EOF'
-- Blog Application Database Schema
-- Created for Web Programming Module Assignment

CREATE DATABASE IF NOT EXISTS blog_db;
USE blog_db;

-- User table for authentication
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Blog posts table
CREATE TABLE blogPost (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
);

-- Sample data (optional)
INSERT INTO user (username, email, password) VALUES 
('admin', 'admin@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password
('testuser', 'test@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password

INSERT INTO blogPost (user_id, title, content) VALUES 
(1, 'Welcome to Our Blog', 'This is the first blog post. Welcome to our blogging platform!'),
(2, 'Getting Started with Blogging', 'Learn how to create and manage your blog posts effectively.');
