<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
require_once '../models/CartModel.php';
require_once '../models/OrderModel.php';
require_once '../models/UserModel.php';
require_once '../models/OrderItemModel.php';
require_once '../models/AddressModel.php';
require_once '../models/ProductModel.php';
class OrderController
{
    private $orderModel;
    private $orderItemModel;
    private $cartModel;
    private $addressModel;
    private $userModel;
    private $productModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->cartModel = new CartModel();
        $this->userModel = new UserModel();
        $this->addressModel = new AddressModel();
        $this->productModel = new ProductModel();
    }

    public function listOrders()
    {
        try {
            // Lấy danh sách đơn hàng từ model
            $orders = $this->orderModel->getAllOrders();
            $perPage = 10;  // Số lượng đơn hàng mỗi trang
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

            // Lọc theo status
            if (isset($_GET['status']) && $_GET['status'] !== '') {
                $statuses = explode(',', $_GET['status']);
                $orders = array_filter($orders, function ($order) use ($statuses) {
                    return in_array($order['status'], $statuses);
                });
            }

            // Lọc theo phương thức thanh toán
            if (isset($_GET['payment']) && $_GET['payment'] !== '') {
                $methods = explode(',', $_GET['payment']);
                $orders = array_filter($orders, function ($order) use ($methods) {
                    return in_array($order['payment_method'], $methods);
                });
            }

            // Lọc theo khoảng ngày đặt hàng (order_date)
            if (isset($_GET['fromDate']) && isset($_GET['toDate'])) {
                $from = $_GET['fromDate'];
                $to = $_GET['toDate'];
                $orders = array_filter($orders, function ($order) use ($from, $to) {
                    return $order['order_date'] >= $from && $order['order_date'] <= $to;
                });
            }

            // Phân trang
            $totalItems = count($orders);
            $totalPages = ceil($totalItems / $perPage);
            $offset = ($currentPage - 1) * $perPage;
            $paginatedData = array_slice($orders, $offset, $perPage);

            // Thêm tên người dùng và địa chỉ vào mỗi đơn hàng
            foreach ($paginatedData as &$order) {
                // Lấy tên người dùng
                $order['fullname'] = $this->userModel->getFullnameById($order['user_id']);

                // Lấy địa chỉ từ address model
                $address = $this->addressModel->getAddressById($order['address_id']);

                // Kiểm tra nếu địa chỉ có đủ thông tin
                if (isset($address['street'], $address['ward'], $address['district'], $address['city'])) {
                    // Ghép địa chỉ thành chuỗi
                    $order['address_detail'] = $address['street'] . ', ' . $address['ward'] . ', ' . $address['district'] . ', ' . $address['city'];
                } else {
                    // Nếu thiếu thông tin, có thể trả về chuỗi lỗi hoặc chỉ ghi đơn giản "Không có địa chỉ"
                    $order['address_detail'] = 'Không có địa chỉ';
                }

                $order['delivery_status'] = $order['delivery_date'];  // Nếu có giá trị, trả về ngày giao

            }

            // Trả về JSON
            header('Content-Type: application/json');
            echo json_encode([
                'orders' => array_values($paginatedData),
                'totalPages' => $totalPages,
                'currentPage' => $currentPage
            ]);
        } catch (Exception $e) {
            // Xử lý lỗi nếu có, trả về lỗi dưới dạng text
            header('Content-Type: text/plain');
            echo "Error: " . $e->getMessage(); // Trả về thông điệp lỗi dưới dạng văn bản
        }
    }

    public function placeOrder($userId, $items, $total, $addressId, $paymentMethod, $status)
    {
        try {
            // Tạo ID đơn hàng mới theo logic thủ công
            $orderId = $this->orderModel->generateNewOrderId();

            if (!$orderId) {
                throw new Exception("Không thể tạo ID đơn hàng mới");
            }

            // Tạo đơn hàng với ID đã tạo và các trường mới
            $this->orderModel->createOrderWithId($orderId, $userId, $total, $addressId, $paymentMethod, $status);

            // Thêm các sản phẩm vào đơn hàng
            foreach ($items as $item) {
                $this->orderItemModel->addItem($orderId, $item['product_id'], $item['quantity'], $item['price']);
            }

            // Xóa giỏ hàng và các item trong giỏ của user sau khi đặt hàng
            $this->cartModel->clearCart($userId);

            // Phản hồi thành công
            echo json_encode([
                'status' => 'success',
                'message' => 'Đặt hàng thành công',
                'orderId' => $orderId,
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Lỗi đặt hàng: ' . $e->getMessage(),
            ]);
        }
    }


    public function getOrderDetail($orderId)
    {
        try {
            // Lấy thông tin đơn hàng
            $order = $this->orderModel->getOrderById($orderId);
            if (!$order) {
                echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy đơn hàng']);
                return;
            }

            // Lấy thông tin người dùng
            $user = $this->userModel->getUserById($order['user_id']);

            // Lấy địa chỉ giao hàng
            $address = $this->addressModel->getAddressById($order['address_id']);

            // Lấy danh sách sản phẩm trong đơn hàng
            $items = $this->orderItemModel->getItemsByOrderId($orderId);

            // Tính tổng tiền từ danh sách sản phẩm
            $totalAmount = 0;
            foreach ($items as &$item) {
                $product = $this->productModel->getProductById($item['product_id']);
                $item['name'] = $product['name'];
                $item['image_url'] = $product['image'];
                $item['price'] = $product['price'];
                $item['total'] = $item['price'] * $item['quantity'];
                $totalAmount += $item['total'];
            }

            // Trả về dữ liệu
            echo json_encode([
                'status' => 'success',
                'order_id' => $order['id'],
                'order_date' => $order['order_date'],
                'delivery_date' => $order['delivery_date'],
                'status' => $order['status'],
                'payment_method' => $order['payment_method'],
                // 'shipping_fee' => $order['shipping_fee'],
                'total_amount' => $totalAmount,
                'fullname' => $user['fullname'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'address' => $address['street'] . ', ' . $address['ward'] . ', ' . $address['district'] . ', ' . $address['city'],
                'products' => $items
            ]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi chi tiết đơn hàng: ' . $e->getMessage()]);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Đọc và giải mã dữ liệu JSON từ body
    $rawData = file_get_contents("php://input");
    $data = json_decode($rawData, true);

    // Lấy action từ body
    $action = $data['action'] ?? null;

    switch ($action) {
        case 'placeOrder':
            $order = $data['order'] ?? null;

            if (!$order || !isset($order['cartItems'])) {
                echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin đơn hàng hoặc giỏ hàng']);
                exit;
            }

            // Lấy thông tin đơn
            $fullname = $order['fullname'] ?? '';
            $email = $order['email'] ?? '';
            $phone = $order['phone'] ?? '';
            $items = $order['cartItems'];

            // Lấy địa chỉ ID và phương thức thanh toán (mới thêm)
            $addressId = $order['addressId'] ?? null;
            $paymentMethod = $order['paymentMethod'] ?? null;

            if (!$addressId || !$paymentMethod) {
                echo json_encode(['status' => 'error', 'message' => 'Thiếu địa chỉ hoặc phương thức thanh toán']);
                exit;
            }

            // Tính tổng tiền
            $total = 0;
            foreach ($items as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            // Lấy userId từ session
            $userId = $_SESSION['userId'] ?? null;
            if (!$userId) {
                echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
                exit;
            }

            $status = 'pending'; // hoặc 'đang xử lý'

            // Gọi hàm đặt hàng
            $orderController = new OrderController();
            $orderController->placeOrder($userId, $items, $total, $addressId, $paymentMethod, $status);
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? null;

    switch ($action) {
        case 'listOrders':
            $userId = $_SESSION['userId'] ?? null;
            if (!$userId) {
                echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
                exit;
            }

            $orderController = new OrderController();
            $orderController->listOrders($userId);
            break;

        case 'getOrderDetails':
            $orderId = $_GET['id'] ?? null;
            if (!$orderId) {
                echo "Thiếu ID đơn hàng";
                exit;
            }

            $orderController = new OrderController();
            $orderController->getOrderDetail($orderId);
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Hành động GET không hợp lệ']);
            break;
    }
}
