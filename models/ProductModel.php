<?php
require_once '../config/db.php';

class ProductModel
{
    private $conn;
    private $table = 'product';

    // Constructor tự khởi tạo kết nối
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả sản phẩm
    public function getAllProducts($filters = [])
    {
        $query = "SELECT * FROM " . $this->table . " WHERE 1";
        $params = [];

        // Lọc theo category nếu có
        if (isset($filters['category']) && !empty($filters['category'])) {
            $placeholders = implode(',', array_fill(0, count($filters['category']), '?'));
            $query .= " AND category_id IN ($placeholders)";
            $params = array_merge($params, $filters['category']);
        }

        // Lọc theo brand nếu có
        if (isset($filters['brand']) && !empty($filters['brand'])) {
            $placeholders = implode(',', array_fill(0, count($filters['brand']), '?'));
            $query .= " AND brand_id IN ($placeholders)";
            $params = array_merge($params, $filters['brand']);
        }

        // Lọc theo từ khóa (key)
        if (isset($filters['key']) && !empty($filters['key'])) {
            $query .= " AND name LIKE ?";
            $params[] = '%' . $filters['key'] . '%';
        }

        // Thực hiện truy vấn SQL an toàn
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLowStockProducts($limit = 10)
    {
        $query = "SELECT p.*, c.name AS category_name, b.name AS brand_name
              FROM " . $this->table . " p
              LEFT JOIN category c ON p.category_id = c.id
              LEFT JOIN brand b ON p.brand_id = b.id
              WHERE p.stock < 5
              ORDER BY p.stock ASC
              LIMIT :limit";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getTopSellingProducts($limit = 10, $fromDate = null, $toDate = null)
    {
        $query = "SELECT p.*, c.name AS category_name, 
                     SUM(oi.quantity) AS total_sold, 
                     SUM(oi.quantity * p.price) AS total_revenue
              FROM " . $this->table . " p
              JOIN order_item oi ON p.id = oi.product_id
              JOIN orders o ON oi.order_id = o.id
              LEFT JOIN category c ON p.category_id = c.id
              WHERE o.status = 'Đã giao thành công'"; // Thêm điều kiện kiểm tra trạng thái "Completed"

        if (!empty($fromDate)) {
            $query .= " AND o.order_date >= :fromDate";
        }

        if (!empty($toDate)) {
            $query .= " AND o.order_date <= :toDate";
        }

        $query .= " GROUP BY p.id
                ORDER BY total_sold DESC
                LIMIT :limit";

        $stmt = $this->conn->prepare($query);

        if (!empty($fromDate)) {
            $stmt->bindParam(':fromDate', $fromDate);
        }

        if (!empty($toDate)) {
            $stmt->bindParam(':toDate', $toDate);
        }

        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách sản phẩm theo tiêu chí lọc (category, brand)
    public function getProductsByCriteria($categoryIds = [], $brandIds = [])
    {
        // Xây dựng câu lệnh SQL
        $query = "SELECT * FROM " . $this->table . " WHERE 1";

        // Kiểm tra và thêm điều kiện lọc theo category_id
        if (!empty($categoryIds)) {
            $categoryPlaceholders = implode(',', array_fill(0, count($categoryIds), '?'));
            $query .= " AND category_id IN ($categoryPlaceholders)";
        }

        // Kiểm tra và thêm điều kiện lọc theo brand_id
        if (!empty($brandIds)) {
            $brandPlaceholders = implode(',', array_fill(0, count($brandIds), '?'));
            $query .= " AND brand_id IN ($brandPlaceholders)";
        }

        // Chuẩn bị câu lệnh SQL
        $stmt = $this->conn->prepare($query);

        // Liên kết các giá trị của mảng categoryIds và brandIds vào câu truy vấn
        $params = array_merge($categoryIds, $brandIds);
        $stmt->execute($params);

        // Trả về kết quả
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Lấy sản phẩm theo ID
    public function getProductById($id)
    {
        $query = "SELECT p.*, b.name AS brand_name 
                  FROM " . $this->table . " p 
                  JOIN brand b ON p.brand_id = b.id 
                  WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm theo tên
    public function getProductByName($name)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE name = :name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm mới
    public function createProduct($data)
    {
        // Gọi hàm generateNewId để lấy ID mới cho sản phẩm
        $new_id = $this->generateNewId();

        // Nếu không lấy được ID mới, trả về false
        if ($new_id === null) {
            return false;
        }

        // Truy vấn để thêm sản phẩm vào bảng
        $query = "INSERT INTO " . $this->table . " (id, name, price, stock, category_id, brand_id, description, image, created_at) 
                  VALUES (:id, :name, :price, :stock, :category_id, :brand_id, :description, :image, :created_at)";

        $stmt = $this->conn->prepare($query);

        // Lấy và làm sạch dữ liệu từ $data
        $name = htmlspecialchars(strip_tags($data['name']));
        $price = htmlspecialchars(strip_tags($data['price']));
        $stock = htmlspecialchars(strip_tags($data['stock']));
        $category_id = htmlspecialchars(strip_tags($data['category_id']));
        $brand_id = htmlspecialchars(strip_tags($data['brand_id']));
        $description = $data['description']; // giữ nguyên HTML
        $image = htmlspecialchars(strip_tags($data['image'])); // Lưu tên ảnh
        $created_at = date('Y-m-d H:i:s');

        // Gán giá trị cho các tham số
        $stmt->bindParam(':id', $new_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':brand_id', $brand_id);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':created_at', $created_at);

        // Thực hiện truy vấn và trả về kết quả
        return $stmt->execute();
    }


    // Cập nhật sản phẩm
    public function updateProduct($id, $data)
    {
        // Xây dựng phần SET động tùy thuộc vào các trường có trong $data
        $fields = [];
        if (isset($data['name'])) $fields[] = "name = :name";
        if (isset($data['price'])) $fields[] = "price = :price";
        if (isset($data['stock'])) $fields[] = "stock = :stock";
        if (isset($data['category_id'])) $fields[] = "category_id = :category_id";
        if (isset($data['brand_id'])) $fields[] = "brand_id = :brand_id";
        if (isset($data['description'])) $fields[] = "description = :description";
        if (isset($data['image'])) $fields[] = "image = :image";

        if (empty($fields)) {
            return false; // Không có gì để cập nhật
        }

        $query = "UPDATE " . $this->table . " SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu và bind param nếu tồn tại
        if (isset($data['name'])) {
            $name = htmlspecialchars(strip_tags($data['name']));
            $stmt->bindParam(':name', $name);
        }
        if (isset($data['price'])) {
            $price = htmlspecialchars(strip_tags($data['price']));
            $stmt->bindParam(':price', $price);
        }
        if (isset($data['stock'])) {
            $stock = htmlspecialchars(strip_tags($data['stock']));
            $stmt->bindParam(':stock', $stock);
        }
        if (isset($data['category_id'])) {
            $category_id = htmlspecialchars(strip_tags($data['category_id']));
            $stmt->bindParam(':category_id', $category_id);
        }
        if (isset($data['brand_id'])) {
            $brand_id = htmlspecialchars(strip_tags($data['brand_id']));
            $stmt->bindParam(':brand_id', $brand_id);
        }
        if (isset($data['description'])) {
            $description = $data['description']; // giữ nguyên HTML
            $stmt->bindParam(':description', $description);
        }
        if (isset($data['image'])) {
            $image = htmlspecialchars(strip_tags($data['image']));
            $stmt->bindParam(':image', $image);
        }

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function isProductInOrderItem($productId)
    {
        $query = "SELECT COUNT(*) as count FROM order_item WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result && $result['count'] > 0;
    }


    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function hideProduct($id)
    {
        $query = "UPDATE " . $this->table . " SET is_hide = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function setProductHide($id, $hideValue)
    {
        $query = "UPDATE " . $this->table . " SET is_hide = :hide WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':hide', $hideValue, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    // Trong ProductModel
    public function isProductSold($productId)
    {
        $query = "SELECT COUNT(*) as total FROM order_item WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result && $result['total'] > 0;
    }

    // Trong ProductModel.php

    public function generateNewId()
    {
        // Truy vấn để lấy ID nhỏ nhất mà chưa tồn tại trong bảng `product`
        $query = "SELECT MIN(t1.id + 1) AS min_id
                  FROM (
                      SELECT 0 AS id
                      UNION
                      SELECT id FROM product
                  ) AS t1
                  LEFT JOIN product t2
                  ON t1.id + 1 = t2.id
                  WHERE t2.id IS NULL";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra xem có ID trống không và gán cho NEW.id
        if ($result['min_id'] !== null) {
            return $result['min_id'];
        }

        // Nếu không tìm thấy ID trống, trả về 1 (ID bắt đầu từ 1 nếu bảng rỗng hoặc không có ID trống)
        return 1;
    }
}
