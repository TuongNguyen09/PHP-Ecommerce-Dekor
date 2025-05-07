<?php
class Database {
    private $host = "localhost"; // Máy chủ MySQL (mặc định trong XAMPP)
    private $db_name = "dekor"; // Tên database bạn tạo
    private $username = "root"; // Mặc định trong XAMPP
    private $password = ""; // Mặc định trong XAMPP là rỗng
    public $conn;

    // Phương thức kết nối
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>