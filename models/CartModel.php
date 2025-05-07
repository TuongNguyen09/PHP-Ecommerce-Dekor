<?php
require_once '../config/db.php';

class CartModel
{
    private $conn;
    private $table = 'cart';

    // Constructor tự khởi tạo kết nối
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả giỏ hàng
    public function getAllCarts()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy giỏ hàng theo ID
    public function getCartById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy giỏ hàng của người dùng theo user_id
    public function getCartByUserId($userId)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Trả về giỏ hàng đầu tiên tìm thấy (hoặc null nếu không có giỏ hàng)
    }

    public function getCartItemsByUserId($userId)
    {
        $query = "SELECT ci.id, ci.product_id, ci.quantity, p.name, p.image, p.price
              FROM cart_items ci
              JOIN cart c ON ci.cart_id = c.id
              JOIN product p ON ci.product_id = p.id
              WHERE c.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCartIdByUserId($userId)
    {
        $query = "SELECT id FROM cart WHERE user_id = :user_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }

    public function getItemByCartIdAndProductId($cartId, $productId)
    {
        $query = "SELECT ci.*, p.name, p.image, p.price 
              FROM cart_item ci
              JOIN product p ON ci.product_id = p.id
              WHERE ci.cart_id = :cart_id AND ci.product_id = :product_id
              LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTotalQuantityInCart($cartId)
    {
        $query = "SELECT SUM(ci.quantity) AS totalQuantity 
                  FROM cart_items ci 
                  WHERE ci.cart_id = :cartId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cartId', $cartId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['totalQuantity'] ? (int)$result['totalQuantity'] : 0;
    }



    // Thêm giỏ hàng mới
    public function createCart($userId)
    {
        $query = "INSERT INTO " . $this->table . " (user_id) VALUES (:user_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function clearCart($userId)
    {
        // Lấy cart_id của người dùng
        $cartId = $this->getCartIdByUserId($userId);

        if ($cartId) {
            // Xóa các mục trong giỏ hàng
            $query = "DELETE FROM cart_item WHERE cart_id = :cart_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
            $stmt->execute();

            // Xóa giỏ hàng của người dùng khỏi bảng cart (nếu cần)
            $query = "DELETE FROM cart WHERE user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        }

        return false;
    }
}
