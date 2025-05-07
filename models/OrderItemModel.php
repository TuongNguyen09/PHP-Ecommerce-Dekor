<?php
require_once '../config/db.php';

class OrderItemModel
{
    private $conn;
    private $table = 'order_item';

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Thêm sản phẩm vào đơn hàng
    public function addItem($orderId, $productId, $quantity, $price)
    {
        $query = "INSERT INTO " . $this->table . " (order_id, product_id, quantity, price)
                  VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    // Lấy danh sách sản phẩm trong đơn hàng
    public function getItemsByOrderId($orderId)
    {
        $query = "SELECT oi.*, p.name AS product_name, p.image
                  FROM " . $this->table . " oi
                  JOIN product p ON oi.product_id = p.id
                  WHERE oi.order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Xoá tất cả sản phẩm trong đơn hàng
    public function deleteItemsByOrderId($orderId)
    {
        $query = "DELETE FROM " . $this->table . " WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        return $stmt->execute();
    }
}
