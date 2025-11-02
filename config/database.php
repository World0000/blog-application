<?php
class Database {
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        // Use Railway environment variables
        $host = getenv('MYSQLHOST') ?: 'localhost';
        $port = getenv('MYSQLPORT') ?: '3306';
        $dbname = getenv('MYSQLDATABASE') ?: 'blog_db';
        $username = getenv('MYSQLUSER') ?: 'root';
        $password = getenv('MYSQLPASSWORD') ?: '';
        
        try {
            $this->conn = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $username, $password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            error_log("Database connection error: " . $exception->getMessage());
            echo "Database connection failed. Please try again later.";
        }
        return $this->conn;
    }
}
?>
