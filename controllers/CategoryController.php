<?php
require_once '../models/CategoryModel.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function listCategories()
    {
        $categories = $this->categoryModel->getAllCategories(); // trả về mảng tất cả categories
        $perPage = 5; // số danh mục mỗi trang
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $totalItems = count($categories);
        $totalPages = ceil($totalItems / $perPage);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedCategories = array_slice($categories, $offset, $perPage);

        header('Content-Type: application/json');
        echo json_encode([
            'categories' => array_values($paginatedCategories),
            'totalPages' => $totalPages,
            'currentPage' => $currentPage
        ]);
    }

    public function getCategories()
    {
        $categories = $this->categoryModel->getAllCategories();
        header('Content-Type: application/json');
        echo json_encode(['categories' => $categories]);
    }


    public function getCategory($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        header('Content-Type: application/json');
        echo json_encode($category);
    }

    public function createCategory()
    {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? ''; // nếu bạn có trường mô tả

        if (empty($name)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Tên danh mục không được để trống'
            ]);
            return;
        }

        $data = [
            'name' => $name,
            'description' => $description
        ];

        $result = $this->categoryModel->createCategory($data);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Tạo danh mục thành công'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Tạo danh mục thất bại. Vui lòng thử lại.'
            ]);
        }
    }


    public function updateCategory($id)
    {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? ''; // nếu có mô tả

        if (empty($name)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Tên danh mục không được để trống'
            ]);
            return;
        }

        $data = [
            'name' => $name,
            'description' => $description
        ];

        $result = $this->categoryModel->updateCategory($id, $data);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Cập nhật danh mục thành công'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Cập nhật danh mục thất bại. Vui lòng thử lại.'
            ]);
        }
    }

    public function deleteCategory($id)
    {
        $id = (int)$id;

        // Kiểm tra nếu danh mục đang được sử dụng
        if ($this->categoryModel->isCategoryUsed($id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Không thể xóa danh mục vì đang được sử dụng trong sản phẩm.'
            ]);
            return;
        }

        $result = $this->categoryModel->deleteCategory($id);

        echo json_encode([
            'status' => $result ? 'success' : 'error',
            'message' => $result ? 'Xóa danh mục thành công' : 'Xóa danh mục thất bại.'
        ]);
    }
}

// Router xử lý action từ URL
$controller = new CategoryController();
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'listCategories': // Chỉnh lại action cho đúng
        $controller->listCategories();
        break;

    case 'get':
        $id = $_GET['id'] ?? 0;
        $controller->getCategory($id);
        break;

    case 'getCategories':
        $controller->getCategories();
        break;

    case 'create':
        $controller->createCategory();
        break;

    case 'update':
        $id = $_GET['id'] ?? 0;
        $controller->updateCategory($id);
        break;

    case 'delete':
        $id = $_GET['id'] ?? 0;
        $controller->deleteCategory($id);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Hành động không hợp lệ']);
}
