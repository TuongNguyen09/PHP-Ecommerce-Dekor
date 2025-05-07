<?php
require_once '../models/AddressModel.php';

class AddressController
{
    private $addressModel;

    public function __construct()
    {
        $this->addressModel = new AddressModel();
    }

    public function listAddresses()
    {
        session_start();
        if (!isset($_SESSION['userId'])) {
            echo json_encode(['status' => 'error', 'message' => 'Chưa đăng nhập']);
            return;
        }

        $userId = $_SESSION['userId'];
        $addresses = $this->addressModel->getAllAddressesByUser($userId);

        // Không cần phân trang nếu số lượng ít
        header('Content-Type: application/json');
        echo json_encode(['addresses' => $addresses]);
    }


    public function getAddress($id)
    {
        $address = $this->addressModel->getAddressById($id);
        if ($address) {
            header('Content-Type: application/json');
            echo json_encode($address);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Không tìm thấy địa chỉ']);
        }
    }


    public function createAddress()
    {
        $data = [
            'user_id' => $_POST['user_id'] ?? null,
            'street' => $_POST['street'] ?? '',
            'city' => $_POST['province_name'] ?? '',   // Tên tỉnh
            'district' => $_POST['district_name'] ?? '', // Tên huyện
            'ward' => $_POST['ward_name'] ?? '',       // Tên xã
            'is_default' => isset($_POST['is_default']) ? 1 : 0
        ];

        // Kiểm tra thông tin bắt buộc
        if (empty($data['user_id']) || empty($data['street'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Vui lòng nhập đầy đủ thông tin địa chỉ'
            ]);
            return;
        }

        // Gửi toàn bộ $data vào model
        $result = $this->addressModel->createAddress($data);

        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Tạo địa chỉ thành công' : 'Tạo địa chỉ thất bại'
        ]);
    }


    public function updateAddress($id)
    {
        $data = [
            'user_id' => $_POST['user_id'] ?? null,
            'street' => $_POST['street'] ?? '',
            'city' => $_POST['province_name'] ?? '',      // Tên tỉnh
            'district' => $_POST['district_name'] ?? '',  // Tên huyện
            'ward' => $_POST['ward_name'] ?? '',          // Tên xã
            'is_default' => isset($_POST['is_default']) ? 1 : 0
        ];

        // Kiểm tra thông tin bắt buộc
        if (empty($data['user_id']) || empty($data['street']) || empty($data['city'])) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Vui lòng nhập đầy đủ thông tin địa chỉ'
            ]);
            return;
        }

        // Gửi dữ liệu cập nhật vào model
        $result = $this->addressModel->updateAddress($id, $data);

        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Cập nhật địa chỉ thành công' : 'Cập nhật địa chỉ thất bại'
        ]);
    }

    public function deleteAddress($id)
    {
        $result = $this->addressModel->deleteAddress($id);

        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Xoá địa chỉ thành công' : 'Xoá địa chỉ thất bại'
        ]);
    }
}

// Router
$controller = new AddressController();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'list':
        $controller->listAddresses();
        break;
    case 'get':
        $id = $_GET['id'] ?? 0;
        $controller->getAddress($id);
        break;
    case 'create':
        $controller->createAddress();
        break;
    case 'update':
        $id = $_GET['id'] ?? 0;
        $controller->updateAddress($id);
        break;
    case 'delete':
        $id = $_GET['id'] ?? 0;
        $controller->deleteAddress($id);
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ']);
}
