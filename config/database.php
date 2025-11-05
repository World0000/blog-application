<?php
class Database {
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        // Local MAMP settings
        $host = 'localhost';
        $port = '8889';
        $dbname = 'blog_db';
        $username = 'root';
        $password = 'root';
        
        try {
            $this->conn = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $username, $password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch(PDOException $exception) {
            error_log("Database connection error: " . $exception->getMessage());
            return null;
        }
    }
}
?>
