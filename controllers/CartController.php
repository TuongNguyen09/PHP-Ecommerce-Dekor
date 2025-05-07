<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Khởi động session nếu chưa được khởi động
}

header('Content-Type: application/json'); // Đảm bảo phản hồi là JSON

require_once '../models/CartModel.php';
require_once '../models/CartItemModel.php';

class CartController
{
    private $cartModel;
    private $cartItemModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
    }

    // Lấy giỏ hàng của người dùng
    public function getCart($userId)
    {
        $cart = $this->cartModel->getCartById($userId);
        if (!$cart) {
            $this->cartModel->createCart($userId);
            $cart = $this->cartModel->getCartById($userId);
        }
        return $cart;
    }

    public function addItem($userId, $productId, $quantity)
    {
        try {
            // Lấy giỏ hàng của người dùng
            $cart = $this->cartModel->getCartByUserId($userId);

            if (!$cart) {
                // Nếu không có giỏ hàng, tạo mới giỏ hàng
                $this->cartModel->createCart($userId);
                $cart = $this->cartModel->getCartByUserId($userId);
            }

            // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
            $existingItem = $this->cartItemModel->getItemByCartAndProduct($cart['id'], $productId);

            if ($existingItem) {
                // Nếu sản phẩm đã có, cộng dồn số lượng
                $newQuantity = $existingItem['quantity'] + $quantity;
                $this->cartItemModel->updateItemQuantity($cart['id'], $productId, $newQuantity);
            } else {
                // Nếu sản phẩm chưa có, thêm vào giỏ hàng
                $this->cartItemModel->addItemToCart($cart['id'], $productId, $quantity);
            }

            // Lấy tổng số lượng sản phẩm trong giỏ hàng
            $totalQuantity = $this->cartItemModel->getTotalQuantityInCart($cart['id']);

            echo json_encode([
                'status' => 'success',
                'message' => 'Sản phẩm đã được thêm vào giỏ hàng.',
                'totalQuantity' => $totalQuantity
            ]);
        } catch (Exception $e) {
            // Xử lý lỗi nếu có
            echo json_encode([
                'status' => 'error',
                'message' => 'Lỗi khi thêm vào giỏ hàng: ' . $e->getMessage()
            ]);
        }
    }

    public function getCartItemsByUserId($userId)
    {
        try {
            $items = $this->cartItemModel->getCartItemsByUserId($userId);
            $this->jsonResponse('success', ['items' => $items]);
        } catch (Exception $e) {
            $this->jsonResponse('error', ['message' => 'Không thể lấy giỏ hàng: ' . $e->getMessage()]);
        }
    }

    private function jsonResponse($status, $data = [])
    {
        echo json_encode(array_merge(['status' => $status], $data));
    }



    public function updateItem($userId, $productId, $quantity)
    {
        if (!$productId || !$quantity || $quantity < 1) {
            return ['status' => 'error', 'message' => 'Thiếu hoặc sai thông tin cập nhật'];
        }

        $cartId = $this->cartModel->getCartIdByUserId($userId);

        try {
            $updated = $this->cartItemModel->updateItemQuantity($cartId, $productId, $quantity);
            if ($updated) {
                // Lấy thông tin sản phẩm sau khi cập nhật
                $item = $this->cartItemModel->getItemByCartIdAndProductId($cartId, $productId);

                // Lấy tổng số lượng sản phẩm trong giỏ hàng
                $totalQuantity = $this->cartItemModel->getTotalQuantityInCart($cartId);

                return [
                    'status' => 'success',
                    'item' => $item,
                    'totalQuantity' => $totalQuantity  // Thêm totalQuantity vào phản hồi
                ];
            } else {
                return ['status' => 'error', 'message' => 'Không cập nhật được sản phẩm'];
            }
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Lỗi: ' . $e->getMessage()];
        }
    }


    public function removeItem($userId, $productId)
    {
        if (!$productId) {
            return ['status' => 'error', 'message' => 'Thiếu productId'];
        }

        try {
            $cartId = $this->cartModel->getCartIdByUserId($userId);

            // Xóa sản phẩm khỏi giỏ hàng
            $this->cartItemModel->removeItemFromCart($cartId, $productId);

            // Lấy lại tổng số lượng sản phẩm trong giỏ hàng
            $totalQuantity = $this->cartItemModel->getTotalQuantityInCart($cartId);

            return [
                'status' => 'success',
                'message' => 'Đã xoá sản phẩm khỏi giỏ hàng',
                'totalQuantity' => $totalQuantity  // Trả về tổng số lượng
            ];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Lỗi khi xoá: ' . $e->getMessage()];
        }
    }

    public function getCartTotalQuantity($userId)
    {
        try {

            $items = $this->cartItemModel->getCartItemsByUserId($userId);
            $totalQuantity = 0;

            foreach ($items as $item) {
                $totalQuantity += $item['quantity'];  // Tính tổng số lượng sản phẩm
            }

            return ['status' => 'success', 'totalQuantity' => $totalQuantity];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Lỗi khi lấy giỏ hàng: ' . $e->getMessage()];
        }
    }
}

// Bộ xử lý chính
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $cartController = new CartController();

    if ($action) {
        switch ($action) {
            case 'addItem':
                if (!isset($_SESSION['userId'])) {
                    echo json_encode(['status' => 'error', 'message' => 'Người dùng chưa đăng nhập']);
                    exit;
                }

                $userId = $_SESSION['userId'];
                $productId = $_POST['productId'] ?? null;
                $quantity = $_POST['quantity'] ?? 1;

                if (!$productId || !$quantity) {
                    echo json_encode(['status' => 'error', 'message' => 'Thiếu thông tin sản phẩm']);
                    exit;
                }
                $cartController->addItem($userId, $productId, $quantity);
                break;

            case 'updateItem':
                if (!isset($_SESSION['userId'])) {
                    echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
                    exit;
                }

                $productId = $_POST['productId'] ?? null;
                $quantity = $_POST['quantity'] ?? null;

                echo json_encode($cartController->updateItem($_SESSION['userId'], $productId, $quantity));
                break;


            case 'removeItem':
                if (!isset($_SESSION['userId'])) {
                    echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
                    exit;
                }

                $userId = $_SESSION['userId'];
                $productId = $_POST['productId'] ?? null;

                echo json_encode($cartController->removeItem($userId, $productId));
                break;


            default:
                echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ']);
                break;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không có action nào được yêu cầu']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? null;
    $cartController = new CartController();

    if ($action) {
        switch ($action) {
            case 'getCartItems':
                if (!isset($_SESSION['userId'])) {
                    echo json_encode(['status' => 'error', 'message' => 'Người dùng chưa đăng nhập']);
                    exit;
                }

                $userId = $_SESSION['userId'];
                $cartController->getCartItemsByUserId($userId);
                break;

            case 'getCartTotalQuantity':  // Thêm case mới để gọi hàm getCartTotalQuantity
                if (!isset($_SESSION['userId'])) {
                    echo json_encode(['status' => 'error', 'message' => 'Người dùng chưa đăng nhập']);
                    exit;
                }

                $userId = $_SESSION['userId'];
                $response = $cartController->getCartTotalQuantity($userId);  // Gọi hàm
                echo json_encode($response);  // Trả về kết quả
                break;

            // case 'updateItem':
            //     if (!isset($_SESSION['userId'])) {
            //         echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
            //         exit;
            //     }

            //     // Đối với GET, phải dùng $_GET thay vì $_POST
            //     $userId = $_SESSION['userId'];
            //     $productId = $_GET['productId'] ?? null;
            //     $quantity = $_GET['quantity'] ?? null;

            //     if (!$productId || !$quantity || $quantity < 1) {
            //         echo json_encode(['status' => 'error', 'message' => 'Thiếu hoặc sai thông tin cập nhật']);
            //         exit;
            //     }

            //     try {
            //         $cartController->updateItem($userId, $productId, $quantity);
            //         echo json_encode(['status' => 'success']);
            //     } catch (Exception $e) {
            //         echo json_encode(['status' => 'error', 'message' => 'Lỗi cập nhật: ' . $e->getMessage()]);
            //     }
            //     break;

            default:
                echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ']);
                break;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Không có action nào được yêu cầu']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Phương thức yêu cầu không hợp lệ']);
}
