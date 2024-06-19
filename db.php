<?php
class Database {
    private $host = "localhost";
    private $db_name = "customer_accounts";
    private $username = "root";
    private $password = "";
    public $conn;
    // Получение соединения с базой данных
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Установка кодировки
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
