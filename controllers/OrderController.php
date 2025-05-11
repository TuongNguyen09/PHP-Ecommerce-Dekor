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
            $perPage = 10;
            $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

            // Lấy danh sách đơn hàng từ model
            $orders = $this->orderModel->getAllOrders();

            // Ưu tiên lọc theo user_id nếu có
            if (!empty($_GET['user_id'])) {
                $userId = $_GET['user_id'];
                $orders = array_filter($orders, function ($order) use ($userId) {
                    return $order['user_id'] == $userId;
                });
            }

            // Lọc theo trạng thái đơn hàng
            if (!empty($_GET['status']) && $_GET['status'] !== 'Tất cả') {
                $statuses = explode(',', $_GET['status']);
                $orders = array_filter($orders, function ($order) use ($statuses) {
                    return in_array($order['status'], $statuses);
                });
            }

            // Lọc theo phương thức thanh toán
            if (!empty($_GET['payment'])) {
                $methods = explode(',', $_GET['payment']);
                $orders = array_filter($orders, function ($order) use ($methods) {
                    return in_array($order['payment_method'], $methods);
                });
            }

            // Lọc theo khoảng ngày
            if (!empty($_GET['fromDate']) && !empty($_GET['toDate'])) {
                $from = $_GET['fromDate'];
                $to = $_GET['toDate'];
                $orders = array_filter($orders, function ($order) use ($from, $to) {
                    return $order['order_date'] >= $from && $order['order_date'] <= $to;
                });
            }

            // Lọc theo product_id nếu có
            if (!empty($_GET['product_id'])) {
                $productId = $_GET['product_id'];
                $orders = array_filter($orders, function ($order) use ($productId) {
                    $orderItems = $this->orderItemModel->getItemsByOrderId($order['id']);
                    foreach ($orderItems as $item) {
                        if ($item['product_id'] == $productId) {
                            return true;
                        }
                    }
                    return false;
                });
            }

            // Lọc theo address nếu có
            if (!empty($_GET['city']) || !empty($_GET['district']) || !empty($_GET['ward'])) {
                $city = isset($_GET['city']) ? strtolower(trim($_GET['city'])) : '';
                $district = isset($_GET['district']) ? strtolower(trim($_GET['district'])) : '';
                $ward = isset($_GET['ward']) ? strtolower(trim($_GET['ward'])) : '';

                $orders = array_filter($orders, function ($order) use ($city, $district, $ward) {
                    $address = $this->addressModel->getAddressById($order['address_id']);
                    $addressCity = isset($address['city']) ? strtolower($address['city']) : '';
                    $addressDistrict = isset($address['district']) ? strtolower($address['district']) : '';
                    $addressWard = isset($address['ward']) ? strtolower($address['ward']) : '';

                    // Kiểm tra từng trường một cách độc lập
                    $cityMatch = empty($city) || strpos($addressCity, $city) !== false;
                    $districtMatch = empty($district) || strpos($addressDistrict, $district) !== false;
                    $wardMatch = empty($ward) || strpos($addressWard, $ward) !== false;

                    return $cityMatch && $districtMatch && $wardMatch;
                });
            }

            if (empty($orders)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'message' => 'Không tìm thấy đơn hàng phù hợp',
                    'orders' => [],
                    'totalPages' => 0,
                    'currentPage' => $currentPage
                ]);
                return;
            }

            // Phân trang và gắn thông tin phụ trợ
            $totalItems = count($orders);
            $totalPages = ceil($totalItems / $perPage);
            $offset = ($currentPage - 1) * $perPage;
            $paginatedData = array_slice($orders, $offset, $perPage);

            foreach ($paginatedData as &$order) {
                $order['items'] = $this->orderItemModel->getItemsByOrderId($order['id']);
                $order['user'] = $this->userModel->getUserById($order['user_id']);
                $address = $this->addressModel->getAddressById($order['address_id']);
                $order['address_detail'] = isset($address['street'], $address['ward'], $address['district'], $address['city']) ?
                    $address['street'] . ', ' . $address['ward'] . ', ' . $address['district'] . ', ' . $address['city'] :
                    'Không có địa chỉ';
                $order['delivery_status'] = $order['delivery_date'];
            }

            header('Content-Type: application/json');
            echo json_encode([
                'orders' => array_values($paginatedData),
                'totalPages' => $totalPages,
                'currentPage' => $currentPage
            ]);
        } catch (Exception $e) {
            header('Content-Type: text/plain');
            echo "Error: " . $e->getMessage();
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

    public function cancelOrder($orderId)
    {
        try {
            // Lấy đơn hàng theo ID
            $order = $this->orderModel->getOrderById($orderId);

            if (!$order) {
                echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy đơn hàng']);
                return;
            }

            // Kiểm tra trạng thái hiện tại (chỉ cho hủy nếu chưa giao)
            if ($order['status'] !== 'Chưa xử lý') {
                echo json_encode(['status' => 'error', 'message' => 'Không thể hủy đơn hàng ở trạng thái hiện tại']);
                return;
            }

            // Cập nhật trạng thái đơn hàng thành "Đã hủy"
            $this->orderModel->updateOrderStatus($orderId, 'Đã hủy');

            echo json_encode(['status' => 'success', 'message' => 'Đơn hàng đã được hủy']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi khi hủy đơn: ' . $e->getMessage()]);
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

    public function updateOrderStatus($orderId, $newStatus)
    {
        try {
            $result = $this->orderModel->updateOrderStatus($orderId, $newStatus);

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Cập nhật trạng thái thành công']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Cập nhật thất bại']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi: ' . $e->getMessage()]);
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

            $status = 'Chưa xử lý'; // hoặc 'đang xử lý'

            // Gọi hàm đặt hàng
            $orderController = new OrderController();
            $orderController->placeOrder($userId, $items, $total, $addressId, $paymentMethod, $status);
            break;

        case 'cancelOrder':
            $orderId = $data['orderId'] ?? null;
            if (!$orderId) {
                echo json_encode(['status' => 'error', 'message' => 'Thiếu mã đơn hàng']);
                exit;
            }
            $controller = new OrderController();
            $controller->cancelOrder($orderId);
            break;


        case 'updateStatus':
            $orderId = $data['orderId'] ?? null;
            $newStatus = $data['newStatus'] ?? null;

            if (!$orderId || !$newStatus) {
                echo json_encode(['status' => 'error', 'message' => 'Thiếu orderId hoặc trạng thái']);
                exit;
            }

            $orderController = new OrderController();
            $orderController->updateOrderStatus($orderId, $newStatus);
            break;


        default:
            echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? null;

    switch ($action) {
        case 'listOrders':
            // $userId = $_SESSION['userId'] ?? null;
            // $adminId = $_SESSION['adminId'] ?? null;
            // if (!$userId || !$adminId) {
            //     echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
            //     exit;
            // }

            $orderController = new OrderController();
            $orderController->listOrders();
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
