<?php
require_once '../config/db.php';

class AddressModel
{
    private $conn;
    private $table = 'address';

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả địa chỉ
    public function getAllAddresses()
    {
        $query = "SELECT a.*, u.name AS user_name 
                  FROM " . $this->table . " a
                  JOIN user u ON a.user_id = u.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy địa chỉ theo ID
    public function getAddressById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllAddressesByUser($userId)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id ORDER BY is_default DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createAddress($data)
    {
        // Nếu là địa chỉ mặc định thì xóa default cũ
        if ($data['is_default']) {
            $resetQuery = "UPDATE " . $this->table . " SET is_default = 0 WHERE user_id = :user_id";
            $stmtReset = $this->conn->prepare($resetQuery);
            $stmtReset->bindParam(':user_id', $data['user_id']);
            $stmtReset->execute();
        }

        $query = "INSERT INTO " . $this->table . " (street, ward, district, city, user_id, is_default) 
                  VALUES (:street, :ward, :district, :city, :user_id, :is_default)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':street', $data['street']);
        $stmt->bindParam(':ward', $data['ward']);
        $stmt->bindParam(':district', $data['district']);
        $stmt->bindParam(':city', $data['city']);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':is_default', $data['is_default']);

        return $stmt->execute();
    }


    // Cập nhật địa chỉ
    public function updateAddress($id, $data)
    {
        // Nếu là địa chỉ mặc định thì reset các địa chỉ khác
        if ($data['is_default']) {
            $resetQuery = "UPDATE " . $this->table . " SET is_default = 0 WHERE user_id = :user_id";
            $stmtReset = $this->conn->prepare($resetQuery);
            $stmtReset->bindParam(':user_id', $data['user_id']);
            $stmtReset->execute();
        }

        $query = "UPDATE " . $this->table . " 
                  SET street = :street, ward = :ward, district = :district, city = :city, 
                      user_id = :user_id, is_default = :is_default
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':street', $data['street']);
        $stmt->bindParam(':ward', $data['ward']);
        $stmt->bindParam(':district', $data['district']);
        $stmt->bindParam(':city', $data['city']);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':is_default', $data['is_default']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }


    // Xoá địa chỉ
    public function deleteAddress($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
