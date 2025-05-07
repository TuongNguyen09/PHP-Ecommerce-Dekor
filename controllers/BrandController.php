<?php
require_once '../models/BrandModel.php';

class BrandController
{
    private $brandModel;

    public function __construct()
    {
        $this->brandModel = new BrandModel();
    }

    public function listBrands()
    {
        $brands = $this->brandModel->getAllBrands(); // trả về mảng tất cả các thương hiệu
        $perPage = 5; // số thương hiệu mỗi trang
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $totalItems = count($brands);
        $totalPages = ceil($totalItems / $perPage);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedBrands = array_slice($brands, $offset, $perPage);

        header('Content-Type: application/json');
        echo json_encode([
            'brands' => array_values($paginatedBrands),
            'totalPages' => $totalPages,
            'currentPage' => $currentPage
        ]);
    }

    public function getBrands()
    {
        try {
            $brands = $this->brandModel->getAllBrands();
            header('Content-Type: application/json');
            echo json_encode(['brands' => $brands]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Lỗi khi lấy danh sách thương hiệu: ' . $e->getMessage()
            ]);
        }
    }



    public function getBrand($id)
    {
        $brand = $this->brandModel->getBrandById($id);
        header('Content-Type: application/json');
        echo json_encode($brand);
    }

    public function createBrand()
    {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        if (empty($name)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Tên thương hiệu không được để trống'
            ]);
            return;
        }

        $data = [
            'name' => $name,
            'description' => $description
        ];

        $result = $this->brandModel->createBrand($data);

        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Tạo thương hiệu thành công' : 'Tạo thương hiệu thất bại. Vui lòng thử lại.'
        ]);
    }

    public function updateBrand($id)
    {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';

        if (empty($name)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Tên thương hiệu không được để trống'
            ]);
            return;
        }

        $data = [
            'name' => $name,
            'description' => $description
        ];

        $result = $this->brandModel->updateBrand($id, $data);

        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Cập nhật thương hiệu thành công' : 'Cập nhật thương hiệu thất bại. Vui lòng thử lại.'
        ]);
    }

    public function deleteBrand($id)
    {
        $id = (int)$id;

        // Nếu có chức năng kiểm tra brand đang được dùng
        if ($this->brandModel->isBrandUsed($id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Không thể xóa thương hiệu vì đang được sử dụng trong sản phẩm.'
            ]);
            return;
        }

        $result = $this->brandModel->deleteBrand($id);

        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Xóa thành công' : 'Xóathất bại.'
        ]);
    }
}

// Router xử lý action từ URL
$controller = new BrandController();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'listBrands': // Chỉnh lại action cho đúng
        $controller->listBrands();
        break;

    case 'getBrands':
        $controller->getBrands();
        break;


    case 'get':
        $id = $_GET['id'] ?? 0;
        $controller->getBrand($id);
        break;

    case 'create':
        $controller->createBrand();
        break;

    case 'update':
        $id = $_GET['id'] ?? 0;
        $controller->updateBrand($id);
        break;

    case 'delete':
        $id = $_GET['id'] ?? 0;
        $controller->deleteBrand($id);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ']);
}
