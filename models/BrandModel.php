<?php
require_once '../config/db.php';

class BrandModel
{
    private $conn;
    private $table = 'brand';

    // Constructor tự khởi tạo kết nối
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả các thương hiệu
    public function getAllBrands()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thương hiệu theo ID
    public function getBrandById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy thương hiệu theo tên
    public function getBrandByName($name)
    {
        $query = "SELECT id, name, description FROM " . $this->table . " WHERE name = :name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy ID thương hiệu từ tên (dành cho việc lọc)
    public function getBrandIdByName($name)
    {
        $query = "SELECT id FROM " . $this->table . " WHERE name = :name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;  // trả về ID hoặc null nếu không tìm thấy
    }

    // Lấy tên thương hiệu theo ID
    public function getBrandNameById($id)
    {
        $query = "SELECT name FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['name'] : null;  // trả về tên thương hiệu hoặc null nếu không tìm thấy
    }

    public function isBrandUsed($brandId)
    {
        $sql = "SELECT COUNT(*) as total FROM product WHERE brand_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$brandId]);
        $row = $stmt->fetch();
        return $row['total'] > 0;
    }

    // Thêm thương hiệu mới
    public function createBrand($data)
    {
        $query = "INSERT INTO " . $this->table . " (name, description, created_at) 
                  VALUES (:name, :description, :created_at)";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($data['name']));
        $description = htmlspecialchars(strip_tags($data['description']));
        $created_at = date('Y-m-d H:i:s');

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':created_at', $created_at);

        return $stmt->execute();
    }

    // Cập nhật thương hiệu
    public function updateBrand($id, $data)
    {
        $query = "UPDATE " . $this->table . " 
                  SET name = :name, description = :description 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($data['name']));
        $description = htmlspecialchars(strip_tags($data['description']));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Xóa thương hiệu
    public function deleteBrand($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
