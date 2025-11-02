<?php
class Database {
    // Development settings (MAMP)
    private $host = "localhost";
    private $db_name = "blog_db";
    private $username = "root";
    private $password = "root";
    private $port = "8889";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        // For hosting, these values will be provided by the hosting service
        $host = getenv('DB_HOST') ?: $this->host;
        $dbname = getenv('DB_NAME') ?: $this->db_name;
        $username = getenv('DB_USERNAME') ?: $this->username;
        $password = getenv('DB_PASSWORD') ?: $this->password;
        $port = getenv('DB_PORT') ?: $this->port;
        
        try {
            $this->conn = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $dbname, $username, $password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
