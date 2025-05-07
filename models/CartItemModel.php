<?php
require_once '../config/db.php';

class CartItemModel
{
    private $conn;
    private $table = 'cart_item';

    // Constructor tự khởi tạo kết nối
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả các sản phẩm trong giỏ hàng của một giỏ hàng cụ thể
    public function getItemsByCartId($cartId)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE cart_id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addItemToCart($cartId, $productId, $quantity)
    {
        $query = "INSERT INTO " . $this->table . " (cart_id, product_id, quantity) 
                  VALUES (:cart_id, :product_id, :quantity)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getItemByCartAndProduct($cartId, $productId)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE cart_id = :cart_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin sản phẩm nếu có, ngược lại trả về false
    }

    public function getTotalQuantityInCart($cartId)
    {
        $query = "SELECT SUM(quantity) AS total_quantity FROM " . $this->table . " WHERE cart_id = :cart_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_quantity'] ?? 0; // Trả về tổng số lượng hoặc 0 nếu không có sản phẩm
    }

    public function getCartItemsByUserId($userId)
    {
        $query = "SELECT ci.id, ci.product_id, ci.quantity, p.name, p.image, p.price
              FROM cart_item ci
              JOIN cart c ON ci.cart_id = c.id
              JOIN product p ON ci.product_id = p.id
              WHERE c.user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateItemQuantity($cartId, $productId, $quantity)
    {
        $query = "UPDATE " . $this->table . " SET quantity = :quantity 
                  WHERE cart_id = :cart_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);

        return $stmt->execute();
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


    // Xóa sản phẩm khỏi giỏ hàng
    public function removeItemFromCart($cartId, $productId)
    {
        $query = "DELETE FROM " . $this->table . " WHERE cart_id = :cart_id AND product_id = :product_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':cart_id', $cartId, PDO::PARAM_INT);
        $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
