<?php
require_once '../config/db.php';
require_once 'OrderItemModel.php';
class OrderModel
{
    private $conn;
    private $table = 'orders';
    private $orderItemModel;
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
        $this->orderItemModel = new OrderItemModel($this->conn); // Truyền connection
    }

    // Lấy tất cả đơn hàng
    public function getAllOrders()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY order_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy đơn hàng theo ID
    public function getOrderById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách đơn hàng theo user_id
    public function getOrdersByUserId($userId)
    {
        // Truy vấn JOIN giữa orders, order_item và product
        $query = "
        SELECT o.*, 
               oi.product_id, 
               oi.quantity, 
               p.price, 
               p.name AS product_name
        FROM " . $this->table . " o
        LEFT JOIN order_item oi ON o.id = oi.order_id
        LEFT JOIN product p ON oi.product_id = p.id
        WHERE o.user_id = :user_id
    ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // Lấy chi tiết sản phẩm trong đơn hàng
    public function getOrderItems($orderId)
    {
        $query = "SELECT oi.*, p.name, p.image, p.price
                  FROM order_item oi
                  JOIN product p ON oi.product_id = p.id
                  WHERE oi.order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Tạo đơn hàng mới
    public function createOrder($userId, $totalAmount, $address, $status)
    {
        // Cập nhật câu lệnh SQL cho đúng với các cột trong bảng
        $query = "INSERT INTO " . $this->table . " (user_id, status, order_date, delivery_date)
              VALUES (:user_id, :status, NOW(), NULL)"; // Chưa có delivery_date, nên đặt là NULL
        $stmt = $this->conn->prepare($query);

        // Liên kết các tham số
        $stmt->bindParam(':user_id', $userId);
        // $stmt->bindParam(':total_amount', $totalAmount); // Giả sử bạn muốn lưu total_amount, có thể chỉnh lại nếu không cần
        $stmt->bindParam(':status', $status);

        // Thực thi câu lệnh SQL
        if ($stmt->execute()) {
            return $this->conn->lastInsertId(); // Trả về ID của đơn hàng vừa tạo
        }
        return false;
    }

    public function createOrderWithId($orderId, $userId, $totalAmount, $addressId, $paymentMethod, $status)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (id, user_id, address_id, payment_method, status, order_date, delivery_date)
                  VALUES (:id, :user_id, :address_id, :payment_method, :status, NOW(), NULL)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $orderId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':address_id', $addressId);
        $stmt->bindParam(':payment_method', $paymentMethod);
        $stmt->bindParam(':status', $status);

        if (!$stmt->execute()) {
            throw new Exception("Không thể tạo đơn hàng");
        }
    }


    public function generateNewOrderId()
    {
        // Câu lệnh SQL để tìm ID nhỏ nhất chưa được sử dụng
        $query = "
        SELECT MIN(t1.id + 1) AS new_id
        FROM (
            SELECT 0 AS id
            UNION
            SELECT id FROM orders
        ) AS t1
        LEFT JOIN orders t2 ON t1.id + 1 = t2.id
        WHERE t2.id IS NULL
    ";

        // Chuẩn bị câu lệnh SQL
        $stmt = $this->conn->prepare($query);

        // Thực thi câu lệnh SQL
        if ($stmt->execute()) {
            // Lấy kết quả
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['new_id']; // Trả về ID mới
        }

        return false; // Nếu có lỗi, trả về false
    }



    // Thêm sản phẩm vào đơn hàng
    public function addOrderItem($orderId, $productId, $quantity, $price)
    {
        $query = "INSERT INTO order_item (order_id, product_id, quantity, price)
                  VALUES (:order_id, :product_id, :quantity, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus($orderId, $status)
    {
        try {
            // Nếu trạng thái là 'Đã xác nhận', trừ stock của các sản phẩm trong order
            if ($status === 'Đã xác nhận') {
                // Lấy danh sách các sản phẩm trong order_item
                $orderItems = $this->orderItemModel->getItemsByOrderId($orderId);

                // Cập nhật stock của từng sản phẩm
                foreach ($orderItems as $item) {
                    $productId = $item['product_id'];
                    $quantity = $item['quantity'];

                    // Trừ số lượng sản phẩm trong kho
                    $updateStockQuery = "UPDATE product SET stock = stock - :quantity WHERE id = :product_id";
                    $stmt = $this->conn->prepare($updateStockQuery);
                    $stmt->bindParam(':quantity', $quantity);
                    $stmt->bindParam(':product_id', $productId);
                    $stmt->execute();
                }
            }

            // Cập nhật trạng thái đơn hàng
            if ($status === 'Đã giao thành công') {
                $query = "UPDATE " . $this->table . " 
                      SET status = :status, delivery_date = NOW() 
                      WHERE id = :order_id";
            } else {
                $query = "UPDATE " . $this->table . " 
                      SET status = :status 
                      WHERE id = :order_id";
            }

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':order_id', $orderId);

            return $stmt->execute();
        } catch (Exception $e) {
            // Xử lý lỗi nếu có
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function cancelOrderById($orderId)
    {
        $sql = "UPDATE orders SET status = 'Đã hủy' WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$orderId]);
    }



    // Xoá đơn hàng
    public function deleteOrder($orderId)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        return $stmt->execute();
    }
}
